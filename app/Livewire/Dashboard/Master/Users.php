<?php

namespace App\Livewire\Dashboard\Master;

use App\Models\User;
use App\Models\Organization;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Flux\Flux;

class Users extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $organization_id = '';
    public $editingUserId = null;

    public function render()
    {
        // Bypass global tenant scopes so the Master Admin can see ALL users
        $users = User::withoutGlobalScopes()
            ->withTrashed()
            ->with('organization')
            ->orderBy('created_at', 'desc')
            ->get();

        // Organizations list for dropdown
        $organizations = Organization::withTrashed()->orderBy('name', 'asc')->get();

        return view('livewire.dashboard.master.users', [
            'users' => $users,
            'organizations' => $organizations,
        ])->layout('layouts.app', ['title' => 'Beheer Gebruikers']);
    }

    public function create()
    {
        $this->reset(['name', 'email', 'password', 'organization_id', 'editingUserId']);
        $this->resetValidation();
        Flux::modal('user-modal')->show();
    }

    public function edit($id)
    {
        $user = User::withoutGlobalScopes()->withTrashed()->findOrFail($id);
        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->organization_id = $user->organization_id ?? '';
        $this->password = ''; // empty, don't show hashed password
        $this->resetValidation();
        Flux::modal('user-modal')->show();
    }

    public function save()
    {
        $rules = [
            'name' => 'required|min:2|max:255',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $query = User::withoutGlobalScopes()->withTrashed()->where('email', Str::lower($value));
                    if ($this->editingUserId) {
                        $query->where('id', '!=', $this->editingUserId);
                    }
                    if ($query->exists()) {
                        $fail(__('Dit e-mailadres is al in gebruik.'));
                    }
                }
            ],
            'organization_id' => 'nullable|exists:organizations,id',
        ];

        if (!$this->editingUserId) {
            $rules['password'] = 'required|min:8';
        } else {
            $rules['password'] = 'nullable|min:8';
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'email' => Str::lower($this->email),
            'organization_id' => $this->organization_id ?: null,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editingUserId) {
            $user = User::withoutGlobalScopes()->withTrashed()->findOrFail($this->editingUserId);
            $user->update($data);
            Flux::toast(__('Gebruiker succesvol bijgewerkt.'));
        } else {
            User::create($data);
            Flux::toast(__('Gebruiker succesvol aangemaakt.'));
        }

        Flux::modal('user-modal')->hide();
        $this->reset(['name', 'email', 'password', 'organization_id', 'editingUserId']);
    }

    public function delete($id)
    {
        if ($id == auth()->id()) {
            Flux::toast(__('U kunt uw eigen account niet archiveren.'), 'error');
            return;
        }

        $user = User::withoutGlobalScopes()->findOrFail($id);
        $user->delete();
        Flux::toast(__('Gebruiker is gearchiveerd (soft deleted).'));
    }

    public function restore($id)
    {
        $user = User::withoutGlobalScopes()->onlyTrashed()->findOrFail($id);
        $user->restore();
        Flux::toast(__('Gebruiker succesvol hersteld.'));
    }

    public function forceDelete($id)
    {
        if ($id == auth()->id()) {
            Flux::toast(__('U kunt uw eigen account niet definitief verwijderen.'), 'error');
            return;
        }

        $user = User::withoutGlobalScopes()->withTrashed()->findOrFail($id);
        $user->forceDelete();
        Flux::toast(__('Gebruiker is definitief verwijderd uit het platform.'));
    }
}
