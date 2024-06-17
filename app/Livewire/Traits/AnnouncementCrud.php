<?php

namespace App\Livewire\Traits;

use App\Enums\Status;
use App\Models\Announcement;
use App\Models\Attribute;
use Igaster\LaravelCities\Geo;
use Illuminate\Database\Eloquent\Builder;
use App\Models\TelegramChat;

trait AnnouncementCrud
{
    public function createAnnouncement(object $data)
    {
        $announcement = auth()->user()->announcements()->create([
            'geo_id' => $data->geo_id,
        ]);

        if ($announcement) {
            $announcement->categories()->sync($data->categories);
            $announcement->features()->createMany($this->setFeatures($data->categories, $data->attributes));
            $announcement->channels()->createMany($this->setChannels($announcement));
            
            if (isset($data->attachments) AND !empty($data->attachments)) {
                foreach ($data->attachments as $attachment) {
                    $announcement->addMedia($attachment)->toMediaCollection('announcements', 's3');
                }
            }

            $announcement->moderate();
        }

        return $announcement;
    }

    private function setFeatures($categories, $attributes)
    {
        $features = [];
        
        if (isset($attributes) AND !empty($attributes)) {
            $availableAttributes = Attribute::whereHas('categories', fn (Builder $query) => $query->whereIn('category_id', $categories))->get();

            foreach ($availableAttributes as $availableAttribute) {
                if (isset($attributes[$availableAttribute->name]) && !empty($attributes[$availableAttribute->name])) {
                    $className = "App\\AttributeType\\".str_replace('_', '', ucwords($availableAttribute?->create_type, '_'));

                    if (class_exists($className)) {
                        $features[] = (new $className($availableAttribute, $attributes))->create();
                    }
                }
            }
        }

        return $features;
    }

    private function setChannels($announcement)
    {
        $channels = [];

        $channelsByCategory = $announcement->categories
            ->pluck('channels')->flatten();

        $channelsByLocation = TelegramChat::whereIn('id', $channelsByCategory->pluck('id'))
            ->whereHas('geo', fn ($query) => $query->radius($announcement->geo->latitude, $announcement->geo->longitude, 30))
            ->get();

        if ($channelsByLocation->count() === 0) {
            $channelsByLocation = TelegramChat::whereIn('id', $channelsByCategory->pluck('id'))->get();
        }

        foreach ($channelsByLocation as $channel) {
            $channels[] = [
                'telegram_chat_id' => $channel->id,
            ];
        }

        return $channels;
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
}