<?php

namespace App\Livewire\Dashboard\Master;

use App\Models\Organization;
use Livewire\Component;
use Illuminate\Support\Str;
use Flux\Flux;

class Organizations extends Component
{
    public $name = '';
    public $subdomain = '';
    public $editingOrganizationId = null;

    public function render()
    {
        // Haal alle organisaties op inclusief soft-deleted items om ze te kunnen restoren
        $organizations = Organization::withTrashed()
            ->withCount([
                'events' => function ($query) {
                    $query->withoutGlobalScopes();
                },
                'users' => function ($query) {
                    $query->withoutGlobalScopes();
                }
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.dashboard.master.organizations', [
            'organizations' => $organizations
        ])->layout('layouts.app', ['title' => 'Beheer Organisaties']);
    }

    public function create()
    {
        $this->reset(['name', 'subdomain', 'editingOrganizationId']);
        $this->resetValidation();
        Flux::modal('organization-modal')->show();
    }

    public function edit($id)
    {
        $org = Organization::withTrashed()->findOrFail($id);
        $this->editingOrganizationId = $org->id;
        $this->name = $org->name;
        $this->subdomain = $org->subdomain;
        $this->resetValidation();
        Flux::modal('organization-modal')->show();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3|max:255',
            'subdomain' => [
                'required',
                'alpha_dash',
                'min:3',
                'max:50',
                function ($attribute, $value, $fail) {
                    $query = Organization::withTrashed()->where('subdomain', Str::lower($value));
                    if ($this->editingOrganizationId) {
                        $query->where('id', '!=', $this->editingOrganizationId);
                    }
                    if ($query->exists()) {
                        $fail(__('Dit subdomein is al in gebruik.'));
                    }
                }
            ],
        ]);

        $subdomain = Str::lower($this->subdomain);
        $slug = Str::slug($this->name);

        $data = [
            'name' => $this->name,
            'subdomain' => $subdomain,
            'slug' => $slug,
        ];

        if ($this->editingOrganizationId) {
            $org = Organization::withTrashed()->findOrFail($this->editingOrganizationId);
            $org->update($data);
            Flux::toast(__('Organisatie succesvol bijgewerkt.'));
        } else {
            Organization::create($data);
            Flux::toast(__('Organisatie succesvol aangemaakt.'));
        }

        Flux::modal('organization-modal')->hide();
        $this->reset(['name', 'subdomain', 'editingOrganizationId']);
    }

    public function delete($id)
    {
        $org = Organization::findOrFail($id);
        $org->delete();
        Flux::toast(__('Organisatie is gearchiveerd (soft deleted).'));
    }

    public function restore($id)
    {
        $org = Organization::withTrashed()->findOrFail($id);
        $org->restore();
        Flux::toast(__('Organisatie succesvol hersteld.'));
    }

    public function forceDelete($id)
    {
        $org = Organization::withTrashed()->findOrFail($id);
        
        // Prevent deletion if organization has events to avoid database orphan constraint errors
        if ($org->events()->exists() || $org->users()->exists()) {
            Flux::toast(__('Kan organisatie niet definitief verwijderen: er zijn nog actieve evenementen of gekoppelde gebruikers aanwezig.'), 'error');
            return;
        }

        $org->forceDelete();
        Flux::toast(__('Organisatie is definitief verwijderd uit het platform.'));
    }
}
