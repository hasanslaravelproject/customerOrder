<?php

namespace App\Http\Controllers\Api;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Resources\FoodResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\FoodCollection;

class UnitAllFoodController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Unit $unit)
    {
        $this->authorize('view', $unit);

        $search = $request->get('search', '');

        $allFood = $unit
            ->allFood()
            ->search($search)
            ->latest()
            ->paginate();

        return new FoodCollection($allFood);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Unit $unit)
    {
        $this->authorize('create', Food::class);

        $validated = $request->validate([
            'name' => 'required|max:255|string',
            'menu_category_id' => 'required|exists:menu_categories,id',
            'divnumber' => 'required|numeric',
            'image' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $food = $unit->allFood()->create($validated);

        return new FoodResource($food);
    }
}
