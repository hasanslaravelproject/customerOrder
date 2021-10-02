<?php

namespace App\Http\Controllers\Api;

use App\Models\Food;
use Illuminate\Http\Request;
use App\Http\Resources\FoodResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\FoodCollection;
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
            ->paginate();

        return new FoodCollection($allFood);
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

        return new FoodResource($food);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Food $food
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Food $food)
    {
        $this->authorize('view', $food);

        return new FoodResource($food);
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

        return new FoodResource($food);
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

        return response()->noContent();
    }
}
