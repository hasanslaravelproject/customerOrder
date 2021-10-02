<?php

namespace App\Http\Livewire;

use App\Models\Menu;
use Livewire\Component;
use App\Models\Company;
use App\Models\MenuCategory;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MenuCategoryMenusDetail extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public MenuCategory $menuCategory;
    public Menu $menu;
    public $menuCategoryCompanies = [];
    public $menuImage;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Menu';

    protected $rules = [
        'menu.company_id' => 'required|exists:companies,id',
        'menuImage' => 'nullable|image|max:1024',
    ];

    public function mount(MenuCategory $menuCategory)
    {
        $this->menuCategory = $menuCategory;
        $this->menuCategoryCompanies = Company::pluck('name', 'id');
        $this->resetMenuData();
    }

    public function resetMenuData()
    {
        $this->menu = new Menu();

        $this->menuImage = null;
        $this->menu->company_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newMenu()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.menu_category_menus.new_title');
        $this->resetMenuData();

        $this->showModal();
    }

    public function editMenu(Menu $menu)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.menu_category_menus.edit_title');
        $this->menu = $menu;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        if (!$this->menu->menu_category_id) {
            $this->authorize('create', Menu::class);

            $this->menu->menu_category_id = $this->menuCategory->id;
        } else {
            $this->authorize('update', $this->menu);
        }

        if ($this->menuImage) {
            $this->menu->image = $this->menuImage->store('public');
        }

        $this->menu->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Menu::class);

        collect($this->selected)->each(function (string $id) {
            $menu = Menu::findOrFail($id);

            if ($menu->image) {
                Storage::delete($menu->image);
            }

            $menu->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetMenuData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->menuCategory->menus as $menu) {
            array_push($this->selected, $menu->id);
        }
    }

    public function render()
    {
        return view('livewire.menu-category-menus-detail', [
            'menus' => $this->menuCategory->menus()->paginate(20),
        ]);
    }
}
