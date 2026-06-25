<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;
use Flux\Flux;

class Index extends Component
{
    public $name = '';
    public $slug = '';
    public $editingCategoryId = null;
    public $usesCategories = false;

    public function mount()
    {
        $organization = auth()->user()->organization;
        if ($organization) {
            $this->usesCategories = $organization->uses_categories;
        }
    }

    public function enableCategories()
    {
        $organization = auth()->user()->organization;
        if ($organization) {
            $organization->update(['uses_categories' => true]);
            $this->usesCategories = true;
            \Flux::toast('Categorieën geactiveerd voor je organisatie!', 'success');
        }
    }

    protected $rules = [
        'name' => 'required|min:2',
        'slug' => 'required',
    ];

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function create()
    {
        $this->reset(['name', 'slug', 'editingCategoryId']);
        Flux::modal('category-modal')->show();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->editingCategoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        Flux::modal('category-modal')->show();
    }

    public function save()
    {
        $this->validate([
            'name' => [
                'required',
                'min:2',
                \Illuminate\Validation\Rule::unique('categories', 'name')
                    ->where('organization_id', auth()->user()->organization_id)
                    ->ignore($this->editingCategoryId),
            ],
            'slug' => [
                'required',
                \Illuminate\Validation\Rule::unique('categories', 'slug')
                    ->where('organization_id', auth()->user()->organization_id)
                    ->ignore($this->editingCategoryId),
            ],
        ]);

        if ($this->editingCategoryId) {
            $category = Category::find($this->editingCategoryId);
            $category->update([
                'name' => $this->name,
                'slug' => $this->slug,
            ]);
            Flux::toast(__('Category updated successfully.'));
        } else {
            Category::create([
                'name' => $this->name,
                'slug' => $this->slug,
            ]);
            Flux::toast(__('Category created successfully.'));
        }

        $this->reset(['name', 'slug', 'editingCategoryId']);
        Flux::modal('category-modal')->close();
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        Flux::toast(__('Category deleted successfully.'));
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();
        Flux::toast(__('Category restored successfully.'));
    }

    public function render()
    {
        return view('livewire.categories.index', [
            'categories' => Category::withTrashed()->orderBy('name')->get(),
        ])->layout('layouts.app', ['title' => __('Categories')]);
    }
}
