<?php

namespace App\Http\Controllers\Api;

use App\Models\MenuCategory;
use Illuminate\Http\Request;
use App\Http\Resources\FoodResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\FoodCollection;

class MenuCategoryAllFoodController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuCategory $menuCategory
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, MenuCategory $menuCategory)
    {
        $this->authorize('view', $menuCategory);

        $search = $request->get('search', '');

        $allFood = $menuCategory
            ->allFood()
            ->search($search)
            ->latest()
            ->paginate();

        return new FoodCollection($allFood);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuCategory $menuCategory
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MenuCategory $menuCategory)
    {
        $this->authorize('create', Food::class);

        $validated = $request->validate([
            'name' => 'required|max:255|string',
            'divnumber' => 'required|numeric',
            'unit_id' => 'required|exists:units,id',
            'image' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $food = $menuCategory->allFood()->create($validated);

        return new FoodResource($food);
    }
}
