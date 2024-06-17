<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Romanlazko\Telegram\Models\TelegramBot as Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TelegramBot extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('bots')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->keepOriginalImageFormat()
                    ->width(100)
                    ->height(100);
            });
    }

    public function chats()
    {
        return $this->hasMany(TelegramChat::class);
    }
}
