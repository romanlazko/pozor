<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementStatus extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => Status::class,
        'info' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (AnnouncementStatus $announcement_status) {
            $announcement_status->announcement->update([
                'current_status' => $announcement_status->status,
                'updated_at' => now(),
            ]);
        });

        static::updating(function (AnnouncementStatus $announcement_status) {
            $announcement_status->announcement->update([
                'current_status' => $announcement_status->status,
                'updated_at' => now(),
            ]);
        });
    }

    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }
}
