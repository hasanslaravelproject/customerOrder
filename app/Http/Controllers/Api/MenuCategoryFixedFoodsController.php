<?php

namespace App\Http\Controllers\Api;

use App\Models\MenuCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FixedFoodResource;
use App\Http\Resources\FixedFoodCollection;

class MenuCategoryFixedFoodsController extends Controller
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

        $fixedFoods = $menuCategory
            ->fixedFoods()
            ->search($search)
            ->latest()
            ->paginate();

        return new FixedFoodCollection($fixedFoods);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuCategory $menuCategory
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MenuCategory $menuCategory)
    {
        $this->authorize('create', FixedFood::class);

        $validated = $request->validate([
            'name' => 'required|max:255|string',
            'divnumber' => 'required|numeric',
            'unit_id' => 'required|exists:units,id',
            'image' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $fixedFood = $menuCategory->fixedFoods()->create($validated);

        return new FixedFoodResource($fixedFood);
    }
}
