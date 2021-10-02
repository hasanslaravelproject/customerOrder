<?php

namespace App\Http\Controllers\Api;

use App\Models\MenuCategory;
use Illuminate\Http\Request;
use App\Http\Resources\MenuResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuCollection;

class MenuCategoryMenusController extends Controller
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

        $menus = $menuCategory
            ->menus()
            ->search($search)
            ->latest()
            ->paginate();

        return new MenuCollection($menus);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuCategory $menuCategory
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MenuCategory $menuCategory)
    {
        $this->authorize('create', Menu::class);

        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'image' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $menu = $menuCategory->menus()->create($validated);

        return new MenuResource($menu);
    }
}
