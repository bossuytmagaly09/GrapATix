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
        $this->modal('category-modal')->show();
    }

    public function edit(Category $category)
    {
        $this->editingCategoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->modal('category-modal')->show();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:2|unique:categories,name,' . ($this->editingCategoryId ?? 'NULL'),
            'slug' => 'required|unique:categories,slug,' . ($this->editingCategoryId ?? 'NULL'),
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
        $this->modal('category-modal')->close();
    }

    public function delete(Category $category)
    {
        $category->delete();
        Flux::toast(__('Category deleted successfully.'));
    }

    public function render()
    {
        return view('livewire.categories.index', [
            'categories' => Category::orderBy('name')->get(),
        ])->layout('layouts.app');
    }
}
