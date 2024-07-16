<?php

namespace App\Livewire\Traits;

use App\AttributeType\AttributeFactory;
use App\Models\Announcement;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Builder;
use App\Models\TelegramChat;
use Illuminate\Support\Facades\DB;

trait AnnouncementCrud
{
    public function createAnnouncement(object $data): ?Announcement
    {
        return DB::transaction(function () use ($data) {
            $announcement = auth()->user()->announcements()->create([
                'geo_id' => $data->geo_id,
            ]);
    
            if ($announcement) {
                $announcement->categories()->sync($data->categories);
                $announcement->features()->createMany($this->getFeatures($data->categories, $data->attributes));
                $announcement->channels()->createMany($this->getChannels($announcement));
                
                if (isset($data->attachments) AND !empty($data->attachments)) {
                    foreach ($data->attachments as $attachment) {
                        $announcement->addMedia($attachment)->toMediaCollection('announcements', 's3');
                    }
                }
    
                $announcement->moderate();
            }

            return $announcement;
        });
    }

    private function getFeatures(array $categories, array $attributes) : array
    {
        if (empty($attributes)) {
            return [];
        }

        return Attribute::whereHas('categories', fn (Builder $query) => $query->whereIn('category_id', $categories))
            ->get()
            ->map(function ($attribute) use ($attributes) {
                return empty($attributes[$attribute->name]) 
                    ? null 
                    : AttributeFactory::getCreateSchema($attribute, $attributes);
            })
            ->filter()
            ->all();
    }

    private function getChannels($announcement) : array
    {
        $categoryChannelIds = $announcement->categories->pluck('channels')->flatten()->pluck('id');

        $locationChannels = TelegramChat::whereIn('id', $categoryChannelIds)
            ->whereHas('geo', fn ($query) => $query->radius($announcement->geo->latitude, $announcement->geo->longitude, 30))
            ->get();

        if ($locationChannels->isEmpty()) {
            $locationChannels = TelegramChat::whereIn('id', $categoryChannelIds)->get();
        }

        return $locationChannels->map(fn ($channel) => ['telegram_chat_id' => $channel->id])->all();
    }
}

// public function updateAnnouncement(object $data)
    // {
    //     $location = Geo::find($data->geo_id)?->toArray() ?? [];

    //     $announcement = auth()->user()->announcements()->find($data->id);

    //     $announcement->update([
    //         'title'             => $data->title,
    //         'description'       => $data->description,
    //         'current_price'     => $data->current_price,
    //         'currency_id'       => $data->currency_id,
    //         'geo_id'            => $data->geo_id,
    //         'latitude'          => $location['lat'] ?? null,
    //         'longitude'         => $location['long'] ?? null,
        
    //         'should_be_published_in_telegram' => true,
    //         'status'            => Status::created,
    //     ]);

    //     $announcement->categories()->sync($data->categories);
    //     $announcement->attributes()->sync($this->setAttributes($data->categories, $data->attributes));

    //     $announcement->getMedia('announcements')->each(function ($attachment) use ($data) {
    //         if (!in_array($attachment->uuid, $data->attachments)) {
    //             $attachment->delete();
    //         }
    //     });

    //     foreach ($data->attachments ?? [] as $attachment) {
    //         if ($attachment instanceof \Illuminate\Http\UploadedFile) {
    //             $announcement->addMedia($attachment)->toMediaCollection('announcements', 's3');
    //         }
    //     }

    //     if ($announcement) {
    //         $announcement->moderate();
    //     }

    //     return $announcement;
    // }