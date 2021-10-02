<?php

namespace App\Http\Livewire;

use App\Models\Menu;
use Livewire\Component;
use App\Models\Company;
use App\Models\MenuCategory;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CompanyMenusDetail extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public Company $company;
    public Menu $menu;
    public $companyMenuCategories = [];
    public $menuImage;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Menu';

    protected $rules = [
        'menu.menu_category_id' => 'required|exists:menu_categories,id',
        'menuImage' => 'nullable|image|max:1024',
    ];

    public function mount(Company $company)
    {
        $this->company = $company;
        $this->companyMenuCategories = MenuCategory::pluck('name', 'id');
        $this->resetMenuData();
    }

    public function resetMenuData()
    {
        $this->menu = new Menu();

        $this->menuImage = null;
        $this->menu->menu_category_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newMenu()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.company_menus.new_title');
        $this->resetMenuData();

        $this->showModal();
    }

    public function editMenu(Menu $menu)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.company_menus.edit_title');
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

        if (!$this->menu->company_id) {
            $this->authorize('create', Menu::class);

            $this->menu->company_id = $this->company->id;
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

        foreach ($this->company->menus as $menu) {
            array_push($this->selected, $menu->id);
        }
    }

    public function render()
    {
        return view('livewire.company-menus-detail', [
            'menus' => $this->company->menus()->paginate(20),
        ]);
    }
}
