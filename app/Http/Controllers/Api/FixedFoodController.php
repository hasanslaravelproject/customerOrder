<?php

namespace App\Http\Controllers\Api;

use App\Models\FixedFood;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\FixedFoodResource;
use App\Http\Resources\FixedFoodCollection;
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
            ->paginate();

        return new FixedFoodCollection($fixedFoods);
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

        return new FixedFoodResource($fixedFood);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FixedFood $fixedFood
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FixedFood $fixedFood)
    {
        $this->authorize('view', $fixedFood);

        return new FixedFoodResource($fixedFood);
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

        return new FixedFoodResource($fixedFood);
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

        return response()->noContent();
    }
}
