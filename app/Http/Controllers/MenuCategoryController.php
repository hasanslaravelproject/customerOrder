<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;
use Illuminate\Http\Request;
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
            ->paginate(5);

        return view(
            'app.menu_categories.index',
            compact('menuCategories', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', MenuCategory::class);

        return view('app.menu_categories.create');
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

        return redirect()
            ->route('menu-categories.edit', $menuCategory)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuCategory $menuCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MenuCategory $menuCategory)
    {
        $this->authorize('view', $menuCategory);

        return view('app.menu_categories.show', compact('menuCategory'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuCategory $menuCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, MenuCategory $menuCategory)
    {
        $this->authorize('update', $menuCategory);

        return view('app.menu_categories.edit', compact('menuCategory'));
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

        return redirect()
            ->route('menu-categories.edit', $menuCategory)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('menu-categories.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
