<?php

namespace App\Http\Controllers\Api;

use App\Models\MenuCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuCategoryResource;
use App\Http\Resources\MenuCategoryCollection;
use App\Http\Requests\MenuCategoryStoreRequest;
use App\Http\Requests\MenuCategoryUpdateRequest;

class MenuCategoryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', MenuCategory::class);

        $search = $request->get('search', '');

        $menuCategories = MenuCategory::search($search)
            ->latest()
            ->paginate();

        return new MenuCategoryCollection($menuCategories);
    }

    /**
     * @param \App\Http\Requests\MenuCategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuCategoryStoreRequest $request)
    {
        $this->authorize('create', MenuCategory::class);

        $validated = $request->validated();

        $menuCategory = MenuCategory::create($validated);

        return new MenuCategoryResource($menuCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuCategory $menuCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MenuCategory $menuCategory)
    {
        $this->authorize('view', $menuCategory);

        return new MenuCategoryResource($menuCategory);
    }

    /**
     * @param \App\Http\Requests\MenuCategoryUpdateRequest $request
     * @param \App\Models\MenuCategory $menuCategory
     * @return \Illuminate\Http\Response
     */
    public function update(
        MenuCategoryUpdateRequest $request,
        MenuCategory $menuCategory
    ) {
        $this->authorize('update', $menuCategory);

        $validated = $request->validated();

        $menuCategory->update($validated);

        return new MenuCategoryResource($menuCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuCategory $menuCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MenuCategory $menuCategory)
    {
        $this->authorize('delete', $menuCategory);

        $menuCategory->delete();

        return response()->noContent();
    }
}
