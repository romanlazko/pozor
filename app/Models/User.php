<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Messanger\Thread;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Romanlazko\Telegram\Models\TelegramChat;
use Romanlazko\Telegram\Traits\HasBots;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasBots, HasRoles; use InteractsWithMedia; use HasSlug; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'avatar',
        'email',
        'password',
        'phone',
        'telegram_chat_id',
        'lang',
        'locale',
        'telegram_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'lang' => 'array'
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->keepOriginalImageFormat()
                    ->width(100)
                    ->height(100);
            });
    }

    public function chat()
    {
        return $this->belongsTo(TelegramChat::class, 'telegram_chat_id', 'id');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function threads()
    {
        return $this->belongsToMany(Thread::class);
    }

    public function getUnreadMessagesCountAttribute()
    {
        return $this->threads
            ->pluck('messages_count')
            ->sum();
    }

    public function wishlist()
    {
        return $this->belongsToMany(Announcement::class, 'votes')->where('vote', true);
    }

    public function isProfileFilled()
    {
        return ! is_null($this->phone) AND ! is_null($this->lang) AND ! is_null($this->name); 
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('super-duper-admin');
    }
}
