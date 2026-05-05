<?php

namespace App\Livewire\Events;

use App\Models\Event;
use App\Models\Category;
use App\Models\Organization;
use Livewire\Component;
use Illuminate\Support\Str;
use Flux\Flux;

class Index extends Component
{
    public $title = '';
    public $description = '';
    public $category_id = '';
    public $start_date = '';
    public $end_date = '';
    public $price = ''; // In euro's
    public $editingEventId = null;

    public function create()
    {
        $this->reset(['title', 'description', 'category_id', 'start_date', 'end_date', 'price', 'editingEventId']);
        Flux::modal('event-modal')->show();
    }

    public function edit(Event $event)
    {
        $this->editingEventId = $event->id;
        $this->title = $event->title;
        $this->description = $event->description;
        $this->category_id = $event->category_id;
        $this->start_date = $event->start_date?->format('Y-m-d\TH:i');
        $this->end_date = $event->end_date?->format('Y-m-d\TH:i');
        $this->price = $event->price_cents / 100;
        Flux::modal('event-modal')->show();
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|min:3',
            'category_id' => 'required|exists:categories,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'price' => 'required|numeric|min:0',
        ]);

        $organization = Organization::first() ?? Organization::create([
            'name' => 'Default Organization',
            'subdomain' => 'default',
        ]);

        $data = [
            'organization_id' => $organization->id,
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'category_id' => $this->category_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'price_cents' => (int) ($this->price * 100),
        ];

        if ($this->editingEventId) {
            $event = Event::find($this->editingEventId);
            $event->update($data);
            Flux::toast(__('Event updated successfully.'));
        } else {
            $data['uuid'] = (string) Str::uuid();
            Event::create($data);
            Flux::toast(__('Event created successfully.'));
        }

        $this->reset(['title', 'description', 'category_id', 'start_date', 'end_date', 'price', 'editingEventId']);
        Flux::modal('event-modal')->close();
    }

    public function delete(Event $event)
    {
        $event->delete();
        Flux::toast(__('Event deleted successfully.'));
    }

    public function render()
    {
        return view('livewire.events.index', [
            'events' => Event::with('category')->orderBy('start_date', 'desc')->get(),
            'categories' => Category::orderBy('name')->get(),
        ])->layout('layouts.app', ['title' => __('Events')]);
    }
}
