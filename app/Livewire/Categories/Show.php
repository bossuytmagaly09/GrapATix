<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use App\Models\Event;
use Livewire\Component;

class Show extends Component
{
    public Category $category;
    public $search = '';

    public function mount(Category $category)
    {
        $this->category = $category;
    }

    public function render()
    {
        $events = Event::with(['category', 'media'])
            ->where('category_id', $this->category->id)
            ->where('title', 'like', '%' . $this->search . '%')
            ->orderBy('start_date', 'asc')
            ->get();

        return view('livewire.categories.show', [
            'events' => $events,
        ])->layout('components.layouts.public', [
            'title' => $this->category->name . ' | GrapATix'
        ]);
    }
}
