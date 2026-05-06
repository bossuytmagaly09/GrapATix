<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use App\Models\Event;
use Livewire\Component;

class Show extends Component
{
    public Category $category;
    public $search = '';
    public $dateFilter = 'all';

    public function mount(Category $category)
    {
        $this->category = $category;
    }

    public function render()
    {
        $query = Event::with(['category', 'media'])
            ->where('category_id', $this->category->id)
            ->where('title', 'like', '%' . $this->search . '%');

        if ($this->dateFilter === 'today') {
            $query->whereDate('start_date', now()->toDateString());
        } elseif ($this->dateFilter === 'tomorrow') {
            $query->whereDate('start_date', now()->addDay()->toDateString());
        } elseif ($this->dateFilter === 'weekend') {
            $query->whereBetween('start_date', [
                now()->next('friday')->at('18:00'),
                now()->next('sunday')->at('23:59')
            ]);
        }

        $events = $query->orderBy('start_date', 'asc')->get();

        return view('livewire.categories.show', [
            'events' => $events,
        ])->layout('components.layouts.public', [
            'title' => $this->category->name . ' | GrapATix'
        ]);
    }
}
