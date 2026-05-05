<?php

namespace App\Livewire\Events;

use App\Models\Event;
use App\Models\Category;
use App\Models\Organization;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Flux\Flux;

class Index extends Component
{
    use WithFileUploads;

    public $title = '';
    public $description = '';
    public $category_id = '';
    public $start_date = '';
    public $end_date = '';
    public $price = ''; // In euro's
    public $image; // Voor de coverfoto
    public $seo_title = '';
    public $seo_description = '';
    public $editingEventId = null;

    public function create()
    {
        $this->reset(['title', 'description', 'category_id', 'start_date', 'end_date', 'price', 'image', 'seo_title', 'seo_description', 'editingEventId']);
        Flux::modal('event-modal')->show();
    }

    public function edit(Event $event)
    {
        $this->editingEventId = $event->id;
        $this->title = $event->title;
        $this->description = $event->description;
        $this->seo_title = $event->seo_title;
        $this->seo_description = $event->seo_description;
        $this->category_id = $event->category_id;
        $this->start_date = $event->start_date?->format('Y-m-d\TH:i');
        $this->end_date = $event->end_date?->format('Y-m-d\TH:i');
        $this->price = $event->price_cents / 100;
        $this->image = null;
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

        $slug = Str::slug($this->title);

        // Controleer of de slug uniek is (behalve voor het event dat we nu bewerken)
        $this->validate([
            'title' => [
                function ($attribute, $value, $fail) use ($slug) {
                    if (Event::where('slug', $slug)->where('id', '!=', $this->editingEventId)->exists()) {
                        $fail(__('An event with this title already exists.'));
                    }
                },
            ],
        ]);

        $organization = Organization::first() ?? Organization::create([
            'name' => 'Default Organization',
            'subdomain' => 'default',
        ]);

        $data = [
            'organization_id' => $organization->id,
            'title' => $this->title,
            'slug' => $slug,
            'description' => $this->description,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'category_id' => $this->category_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'price_cents' => (int) ($this->price * 100),
        ];

        if ($this->editingEventId) {
            $event = Event::find($this->editingEventId);
            $event->update($data);
            
            if ($this->image) {
                $event->addMedia($this->image)->toMediaCollection('cover');
            }
            
            Flux::toast(__('Event updated successfully.'));
        } else {
            $data['uuid'] = (string) Str::uuid();
            $event = Event::create($data);
            
            if ($this->image) {
                $event->addMedia($this->image)->toMediaCollection('cover');
            }
            
            Flux::toast(__('Event created successfully.'));
        }

        $this->reset(['title', 'description', 'category_id', 'start_date', 'end_date', 'price', 'image', 'seo_title', 'seo_description', 'editingEventId']);
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
            'events' => Event::with(['category', 'media'])->orderBy('start_date', 'desc')->get(),
            'categories' => Category::orderBy('name')->get(),
        ])->layout('layouts.app', ['title' => __('Events')]);
    }
}
