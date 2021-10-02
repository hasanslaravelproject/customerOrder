<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\MenuCategory;
use App\Http\Requests\FoodStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FoodUpdateRequest;

class FoodController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Food::class);

        $search = $request->get('search', '');

        $allFood = Food::search($search)
            ->latest()
            ->paginate(5);

        return view('app.all_food.index', compact('allFood', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Food::class);

        $menuCategories = MenuCategory::pluck('name', 'id');
        $units = Unit::pluck('name', 'id');

        return view('app.all_food.create', compact('menuCategories', 'units'));
    }

    /**
     * @param \App\Http\Requests\FoodStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FoodStoreRequest $request)
    {
        $this->authorize('create', Food::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $food = Food::create($validated);

        return redirect()
            ->route('all-food.edit', $food)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Food $food
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Food $food)
    {
        $this->authorize('view', $food);

        return view('app.all_food.show', compact('food'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Food $food
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Food $food)
    {
        $this->authorize('update', $food);

        $menuCategories = MenuCategory::pluck('name', 'id');
        $units = Unit::pluck('name', 'id');

        return view(
            'app.all_food.edit',
            compact('food', 'menuCategories', 'units')
        );
    }

    /**
     * @param \App\Http\Requests\FoodUpdateRequest $request
     * @param \App\Models\Food $food
     * @return \Illuminate\Http\Response
     */
    public function update(FoodUpdateRequest $request, Food $food)
    {
        $this->authorize('update', $food);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($food->image) {
                Storage::delete($food->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $food->update($validated);

        return redirect()
            ->route('all-food.edit', $food)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Food $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Food $food)
    {
        $this->authorize('delete', $food);

        if ($food->image) {
            Storage::delete($food->image);
        }

        $food->delete();

        return redirect()
            ->route('all-food.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
