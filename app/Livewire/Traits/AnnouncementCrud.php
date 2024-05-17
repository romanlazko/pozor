<?php

namespace App\Livewire\Traits;

use App\Enums\Status;
use App\Models\Attribute;
use Igaster\LaravelCities\Geo;
use Illuminate\Database\Eloquent\Builder;

trait AnnouncementCrud
{
    public function createAnnouncement(object $data)
    {
        $location = Geo::find($data->geo_id)?->toArray() ?? [];

        $announcement = auth()->user()->announcements()->create([
            'title'             => $data->title,
            'description'       => $data->description,
            'current_price'     => $data->current_price,
            'currency_id'       => $data->currency_id,
            'geo_id'            => $data->geo_id,
            'latitude'          => $location['lat'] ?? null,
            'longitude'         => $location['long'] ?? null,
        
            'should_be_published_in_telegram' => true,
            'status'            => Status::created,
        ]);

        $announcement->categories()->sync($data->categories);

        if (isset($data->attributes) AND !empty($data->attributes)) {
            $announcement->attributes()->sync($this->setAttributes($data->categories, $data->attributes));
        }
        
        if (isset($data->attachments) AND !empty($data->attributes)) {
            foreach ($data->attachments ?? [] as $attachment) {
                $announcement->addMedia($attachment)->toMediaCollection('announcements', 's3');
            }
        }

        if ($announcement) {
            $announcement->moderate();
        }

        return $announcement;
    }

    public function updateAnnouncement(object $data)
    {
        $location = Geo::find($data->geo_id)?->toArray() ?? [];

        $announcement = auth()->user()->announcements()->find($data->id);

        $announcement->update([
            'title'             => $data->title,
            'description'       => $data->description,
            'current_price'     => $data->current_price,
            'currency_id'       => $data->currency_id,
            'geo_id'            => $data->geo_id,
            'latitude'          => $location['lat'] ?? null,
            'longitude'         => $location['long'] ?? null,
        
            'should_be_published_in_telegram' => true,
            'status'            => Status::created,
        ]);

        $announcement->categories()->sync($data->categories);
        $announcement->attributes()->sync($this->setAttributes($data->categories, $data->attributes));

        $announcement->getMedia('announcements')->each(function ($attachment) use ($data) {
            if (!in_array($attachment->uuid, $data->attachments)) {
                $attachment->delete();
            }
        });

        foreach ($data->attachments ?? [] as $attachment) {
            if ($attachment instanceof \Illuminate\Http\UploadedFile) {
                $announcement->addMedia($attachment)->toMediaCollection('announcements', 's3');
            }
        }

        if ($announcement) {
            $announcement->moderate();
        }

        return $announcement;
    }

    private function setAttributes($categories, $attributes)
    {
        $sync = [];

        $availableAttributes = Attribute::whereHas('categories', fn (Builder $query) => $query->whereIn('category_id', $categories))->get();

        foreach ($availableAttributes as $availableAttribute) {
            if (isset($attributes[$availableAttribute->name]) && !empty($attributes[$availableAttribute->name]) && $availableAttribute->is_feature) {
                $sync[$availableAttribute->id] = ['value' => ['original' => $attributes[$availableAttribute->name]]];
            }
        }

        return $sync;
    }
}