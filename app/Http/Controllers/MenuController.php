<?php

namespace App\Http\Controllers;

use App\Models\Kot;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Unit;
use App\Models\Order;
use App\Models\Company;
use App\Models\FixedFood;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MenuStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\MenuUpdateRequest;

class MenuController extends Controller
{
    public function savefinalmenu(Request $request)
    {
        //return $request->all();
         $food_id= implode(',',$request->food_id);
         $food_quantity= implode(',',$request->quantity);
         $food_group= implode(',',$request->food_group);
         $group_quantity= implode(',',$request->group_quantity);
        
         Kot::create([
           'company_id' =>$request->company_id,
           'menu_category_id'=> $request->menu_category_id,
           'food_id'=> $food_id,
           'food_group'=> $food_group,
           'quantity'=> $food_quantity,
           'group_quantity'=>$group_quantity
         ]);

         return back();
    
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Menu::class);

        $search = $request->get('search', '');
        
        $menus = Menu::search($search)
            ->latest()
            ->paginate(5);
        
        return view('app.menus.index', compact('menus', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        $this->authorize('create', Menu::class);
    
       $companies = Company::pluck('name', 'id');
        $menuCategories = MenuCategory::pluck('name', 'id');
        $foods = Food::all();
        $units = Unit::all();
        
        $menus = Menu::all();
         $last_order = Order::latest()->first();
         $food = Food::all();
        
        $fixedfood = FixedFood::all();
        
        $fg= $fixedfood->groupBy('menu_category_id');
        $fgroup = $fg->all();
                
        return view('app.menus.create', compact('fgroup','fixedfood','companies', 'menuCategories','foods', 'menus', 'last_order','food', 'units'));
    }
    
    /**
     * @param \App\Http\Requests\MenuStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuStoreRequest $request)
    {
        $this->authorize('create', Menu::class);
        
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $menu = Menu::create($validated);

        return redirect()
            ->route('menus.edit', $menu)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Menu $menu)
    {
        $this->authorize('view', $menu);

        return view('app.menus.show', compact('menu'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Menu $menu)
    {
        $this->authorize('update', $menu);

        $companies = Company::pluck('name', 'id');
        $menuCategories = MenuCategory::pluck('name', 'id');

        return view(
            'app.menus.edit',
            compact('menu', 'companies', 'menuCategories')
        );
    }

    /**
     * @param \App\Http\Requests\MenuUpdateRequest $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function update(MenuUpdateRequest $request, Menu $menu)
    {
        $this->authorize('update', $menu);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::delete($menu->image);
            }
            
            $validated['image'] = $request->file('image')->store('public');
        }

        $menu->update($validated);

        return redirect()
            ->route('menus.edit', $menu)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Menu $menu)
    {
        $this->authorize('delete', $menu);

        if ($menu->image) {
            Storage::delete($menu->image);
        }

        $menu->delete();

        return redirect()
            ->route('menus.index')
            ->withSuccess(__('crud.common.removed'));
    }
    
    public function showunit(Request $request)
    {
        //return $request->all();
        $food = Food::whereId($request->foodid)->first();
        return $food->unit->name;
    }

    public function fixedmenu(Request $request)
    {
        
        return $request->all();
    }
}
