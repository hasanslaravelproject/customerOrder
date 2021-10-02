<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Company;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CompanyUsersDetail extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public Company $company;
    public User $user;
    public $userPassword;
    public $userImage;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New User';

    protected $rules = [
        'user.name' => 'required|max:255|string',
        'user.email' => 'required|unique:users,email|email',
        'userPassword' => 'required',
        'userImage' => 'nullable|image|max:1024',
    ];

    public function mount(Company $company)
    {
        $this->company = $company;
        $this->resetUserData();
    }

    public function resetUserData()
    {
        $this->user = new User();

        $this->userPassword = '';
        $this->userImage = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newUser()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.company_users.new_title');
        $this->resetUserData();

        $this->showModal();
    }

    public function editUser(User $user)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.company_users.edit_title');
        $this->user = $user;

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
        if (!$this->user->company_id) {
            $this->validate();
        } else {
            $this->validate([
                'user.name' => 'required|max:255|string',
                'user.email' => 'required|unique:users,email|email',
                'userPassword' => 'nullable',
                'userImage' => 'nullable|image|max:1024',
            ]);
        }

        if (!$this->user->company_id) {
            $this->authorize('create', User::class);

            $this->user->company_id = $this->company->id;
        } else {
            $this->authorize('update', $this->user);
        }

        if (!empty($this->userPassword)) {
            $this->user->password = Hash::make($this->userPassword);
        }

        if ($this->userImage) {
            $this->user->image = $this->userImage->store('public');
        }

        $this->user->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', User::class);

        collect($this->selected)->each(function (string $id) {
            $user = User::findOrFail($id);

            if ($user->image) {
                Storage::delete($user->image);
            }

            $user->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetUserData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->company->users as $user) {
            array_push($this->selected, $user->id);
        }
    }

    public function render()
    {
        return view('livewire.company-users-detail', [
            'users' => $this->company->users()->paginate(20),
        ]);
    }
}
