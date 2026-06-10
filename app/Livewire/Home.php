<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Event;
use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\On;

class Home extends Component
{
    public $search = '';
    public $selectedCategory = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => ''],
    ];

    public function selectCategory($categorySlug)
    {
        $this->selectedCategory = $categorySlug;
    }

    #[On('category-selected')]
    public function selectCategoryFromEvent($categorySlug)
    {
        $this->selectedCategory = $categorySlug;
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->selectedCategory = '';
    }

    #[On('search-updated')]
    public function updateSearch($query)
    {
        $this->search = $query;
    }

    public function render()
    {
        // 1. Featured Hero Event
        $featuredEvent = Event::withoutGlobalScopes()
            ->with(['category', 'venue', 'organization'])
            ->where('is_published', true)
            ->where('start_date', '>=', now())
            ->where('slug', 'tomorrowland-2026')
            ->first();

        if (!$featuredEvent) {
            // Fallback to highest priced upcoming event
            $featuredEvent = Event::withoutGlobalScopes()
                ->with(['category', 'venue', 'organization'])
                ->where('is_published', true)
                ->where('start_date', '>=', now())
                ->orderBy('price_cents', 'desc')
                ->first();
        }

        // 2. Fetch all global categories
        $categories = Category::withoutGlobalScopes()->get();

        // 3. Query filtered upcoming events
        $query = Event::withoutGlobalScopes()
            ->with(['category', 'venue', 'organization', 'ticketTypes'])
            ->where('is_published', true)
            ->where('start_date', '>=', now());

        if ($this->selectedCategory) {
            $query->whereHas('category', function ($q) {
                $q->where('slug', $this->selectedCategory);
            });
        }

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        $events = $query->orderBy('start_date', 'asc')->get();

        // 4. Recently Added Events
        $recentEvents = Event::withoutGlobalScopes()
            ->with(['category', 'venue', 'organization'])
            ->where('is_published', true)
            ->latest()
            ->take(4)
            ->get();

        return view('livewire.home', [
            'featuredEvent' => $featuredEvent,
            'categories' => $categories,
            'events' => $events,
            'recentEvents' => $recentEvents,
        ])->layout('components.layouts.public');
    }
}

