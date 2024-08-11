<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementChannel extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => Status::class,
        'info' => 'array',
    ];

    public function channel()
    {
        return $this->belongsTo(TelegramChat::class, 'telegram_chat_id', 'id');
    }

    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }

    public function published(array $info = [])
    {
        return $this->update([
            'status' => Status::published,
            'info' => $info,
        ]);
    }

    public function publishingFailed(array $info = [])
    {
        return $this->update([
            'status' => Status::publishing_failed,
            'info' => $info,
        ]);
    }
}
