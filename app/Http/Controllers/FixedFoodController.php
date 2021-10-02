<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\FixedFood;
use Illuminate\Http\Request;
use App\Models\MenuCategory;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FixedFoodStoreRequest;
use App\Http\Requests\FixedFoodUpdateRequest;

class FixedFoodController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', FixedFood::class);

        $search = $request->get('search', '');

        $fixedFoods = FixedFood::search($search)
            ->latest()
            ->paginate(5);

        return view('app.fixed_foods.index', compact('fixedFoods', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', FixedFood::class);

        $menuCategories = MenuCategory::pluck('name', 'id');
        $units = Unit::pluck('name', 'id');

        return view(
            'app.fixed_foods.create',
            compact('menuCategories', 'units')
        );
    }

    /**
     * @param \App\Http\Requests\FixedFoodStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FixedFoodStoreRequest $request)
    {
        $this->authorize('create', FixedFood::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $fixedFood = FixedFood::create($validated);

        return redirect()
            ->route('fixed-foods.edit', $fixedFood)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FixedFood $fixedFood
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FixedFood $fixedFood)
    {
        $this->authorize('view', $fixedFood);

        return view('app.fixed_foods.show', compact('fixedFood'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FixedFood $fixedFood
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, FixedFood $fixedFood)
    {
        $this->authorize('update', $fixedFood);

        $menuCategories = MenuCategory::pluck('name', 'id');
        $units = Unit::pluck('name', 'id');

        return view(
            'app.fixed_foods.edit',
            compact('fixedFood', 'menuCategories', 'units')
        );
    }

    /**
     * @param \App\Http\Requests\FixedFoodUpdateRequest $request
     * @param \App\Models\FixedFood $fixedFood
     * @return \Illuminate\Http\Response
     */
    public function update(
        FixedFoodUpdateRequest $request,
        FixedFood $fixedFood
    ) {
        $this->authorize('update', $fixedFood);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($fixedFood->image) {
                Storage::delete($fixedFood->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $fixedFood->update($validated);

        return redirect()
            ->route('fixed-foods.edit', $fixedFood)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FixedFood $fixedFood
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FixedFood $fixedFood)
    {
        $this->authorize('delete', $fixedFood);

        if ($fixedFood->image) {
            Storage::delete($fixedFood->image);
        }

        $fixedFood->delete();

        return redirect()
            ->route('fixed-foods.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
