<?php

namespace App\Models\Traits;

use App\Enums\Status;
use App\Jobs\PublishAnnouncementJob;
use App\Jobs\TranslateAnnouncement;
use Exception;

trait AnnouncementTrait
{
    public function moderate()
    {
        $result = $this->update([
            'status' => Status::await_moderation,
        ]);

        if ($result) {
            // ModerateAnnouncementByClarifiJob::dispatch($this)->delay(now()->addMinutes(5));
        }

        return $result;
    }

    public function moderationFailed(string $reason = null)
    {
        $result =  $this->update([
            'status' => Status::moderation_failed,
        ]);

        return $result;
    }

    public function moderationNotPassed(string $reason = null)
    {
        $result =  $this->update([
            'status' => Status::moderation_not_passed,
        ]);

        // ModerationNotPassedAnnouncement::dispatch($this)->delay(now()->addMinutes(5));

        return $result;
    }

    public function reject(string $reason = null)
    {
        $result =  $this->update([
            'status' => Status::rejected,
        ]);

        // RejectedAnnouncement::dispatch($this)->delay(now()->addMinutes(5));

        return $result;
    }

    public function approve()
    {
        $result = $this->approved();

        if ($result) {
            $this->translate();
        }

        return $result;
    }

    public function approved()
    {
        $result = $this->update([
            'status' => Status::approved,
        ]);

        return $result;
    }
    
    public function translate()
    {
        $result = $this->update([
            'status' => Status::await_translation,
        ]);

        if ($result) {
            TranslateAnnouncement::dispatch($this->id);
            // ->delay(now()->addMinutes(5))
        }

        return $result;
    }

    public function translationFailed(Exception $e = null)
    {
        $result = $this->update([
            'status' => Status::translation_failed,
        ]);

        return $result;
    }

    public function translated()
    {
        $result = $this->update([
            'status' => Status::translated,
        ]);

        if ($result) {
            $this->publish();
        }

        return $result;
    }

    public function publish()
    {
        $result = $this->update([
            'status' => Status::await_publication,
        ]);

        if ($result) {
            PublishAnnouncementJob::dispatch($this);
            // ->delay(now()->addMinutes(5))
        }
        
        return $result;
    }

    public function publishingFailed(Exception $e = null)
    {
        $result =  $this->update([
            'status' => Status::publishing_failed,
        ]);

        return $result;
    }

    public function published()
    {
        $result =  $this->update([
            'status' => Status::published,
            'should_be_published_in_telegram' => false,
        ]);

        // PublishedAnnouncement::dispatch($this)->delay(now()->addMinutes(5));
        
        return $result;
    }

    public function sold()
    {
        $result =  $this->update([
            'status' => Status::sold,
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
