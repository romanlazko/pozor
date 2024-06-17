<?php

namespace App\Models\Traits;

use App\Enums\Status;
use App\Jobs\PublishAnnouncementJob;
use App\Jobs\TranslateAnnouncement;
use App\Models\AnnouncementStatus as AnnouncementStatusModel;

trait AnnouncementStatus
{
    public function statuses()
    {
        return $this->hasMany(AnnouncementStatusModel::class);
    }

    public function currentStatus()
    {
        return $this->hasOne(AnnouncementStatusModel::class)->orderBy('id', 'desc')->latestOfMany();
    }

    public function getStatusAttribute()
    {
        return $this->currentStatus?->status;
    }

    public function moderate(array $info = [])
    {
        $result = $this->statuses()->create([
            'status' => Status::await_moderation,
            'info' => $info,
        ]);

        if ($result) {
            // ModerateAnnouncementByClarifiJob::dispatch($this)->delay(now()->addMinutes(5));
        }

        return $result;
    }

    public function moderationFailed(array $info = [])
    {
        $result =  $this->statuses()->create([
            'status' => Status::moderation_failed,
            'info' => $info,
        ]);

        return $result;
    }

    public function moderationNotPassed(array $info = [])
    {
        $result =  $this->statuses()->create([
            'status' => Status::moderation_not_passed,
            'info' => $info,
        ]);

        // ModerationNotPassedAnnouncement::dispatch($this)->delay(now()->addMinutes(5));

        return $result;
    }

    public function reject(array $info = [])
    {
        $result =  $this->statuses()->create([
            'status' => Status::rejected,
            'info' => $info,
        ]);

        // RejectedAnnouncement::dispatch($this)->delay(now()->addMinutes(5));

        return $result;
    }

    public function approve(array $info = [])
    {
        $result = $this->approved();

        if ($result) {
            $this->translate();
        }

        return $result;
    }

    public function approved(array $info = [])
    {
        $result = $this->statuses()->create([
            'status' => Status::approved,
            'info' => $info,
        ]);

        return $result;
    }
    
    public function translate(array $info = [])
    {
        $result = $this->statuses()->create([
            'status' => Status::await_translation,
            'info' => $info,
        ]);

        if ($result) {
            TranslateAnnouncement::dispatch($this->id);
            // ->delay(now()->addMinutes(5))
        }

        return $result;
    }

    public function translationFailed(array $info = [])
    {
        $result = $this->statuses()->create([
            'status' => Status::translation_failed,
            'info' => $info,
        ]);

        return $result;
    }

    public function translated(array $info = [])
    {
        $result = $this->statuses()->create([
            'status' => Status::translated,
            'info' => $info,
        ]);

        if ($result) {
            $this->publish();
        }

        return $result;
    }

    public function publish(array $info = [])
    {
        $result = $this->statuses()->create([
            'status' => Status::await_publication,
            'info' => $info,
        ]);

        if ($result) {
            // PublishOnTelegram::dispatch($this);
            PublishAnnouncementJob::dispatch($this->id);
            // ->delay(now()->addMinutes(5))
        }
        
        return $result;
    }

    public function publishingFailed(array $info = [])
    {
        $result = $this->statuses()->create([
            'status' => Status::publishing_failed,
            'info' => $info,
        ]);

        return $result;
    }

    public function published(array $info = [])
    {
        $result = $this->statuses()->create([
            'status' => Status::published,
            'info' => $info,
        ]);

        // PublishedAnnouncement::dispatch($this)->delay(now()->addMinutes(5));
        
        return $result;
    }

    public function sold(array $info = [])
    {
        $result = $this->statuses()->create([
            'status' => Status::sold,
            'info' => $info,
        ]);

        return $result;
    }

    public function discount($new_price)
    {
        if ($new_price) {
            return $this->update([
                'current_price' => $new_price,
                'old_price' => $this->current_price,
            ]);
        }

        return false;
    }

    public function indicateAvailability()
    {
        if ($this->status == Status::sold) {
            return $this->publish();
        }

        return false;
    }
}
