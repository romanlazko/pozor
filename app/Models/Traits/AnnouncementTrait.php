<?php

namespace App\Models\Traits;

use App\Enums\Status;
use App\Jobs\PublishAnnouncementJob;
use Exception;

trait AnnouncementTrait
{
    public function moderate($moderator = 'system')
    {
        $result = $this->update([
            'status' => Status::await_moderation,
            'status_info' => $this->statusInfo('await_moderation', $moderator),
        ]);

        if ($result) {
            // ModerateAnnouncementByClarifiJob::dispatch($this);
        }

        return $result;
    }

    public function moderationNotPassed($moderator = 'system')
    {
        $result =  $this->update([
            'status' => Status::moderation_not_passed,
            'status_info' => $this->statusInfo('moderation_not_passed', $moderator),
        ]);

        // ModerationNotPassedMarketplaceAnnouncement::dispatch($this);

        return $result;
    }

    public function moderationPassed($moderator = 'system')
    {
        $result = $this->update([
            'status' => Status::moderation_passed,
            'status_info' => $this->statusInfo('moderation_passed', $moderator),
        ]);

        $this->publish($moderator);

        return $result;
    }

    public function publish($moderator = 'system')
    {
        $result = $this->update([
            'status' => Status::await_publication,
            'status_info' => $this->statusInfo('await_publication', $moderator),
        ]);

        if ($result) {
            PublishAnnouncementJob::dispatch($this)->delay(now()->addMinutes(5));
        }
        
        return $result;
    }

    public function publishingFailed(Exception $e, $moderator = 'system')
    {
        $result =  $this->update([
            'status' => Status::publishing_failed,
            'status_info' => $this->statusInfo('publishing_failed', $moderator, $e->getMessage()),
        ]);

        return $result;
    }

    public function published($moderator = 'system')
    {
        $result =  $this->update([
            'status' => Status::published,
            'status_info' => $this->statusInfo('published', $moderator),
        ]);

        // PublishedMarketplaceAnnouncement::dispatch($this);
        
        return $result;
    }

    public function reject($moderator = 'system')
    {
        $result =  $this->update([
            'status' => Status::rejected,
            'status_info' => $this->statusInfo('rejected', $moderator),
        ]);

        // RejectedMarketplaceAnnouncement::dispatch($this);

        return $result;
    }

    public function fail(Exception $e, $moderator = 'system')
    {
        $result = $this->update([
            'status' => Status::failed,
            'status_info' => $this->statusInfo('failed', $moderator, $e),
        ]);

        return $result;
    }

    public function sold($moderator = 'system')
    {
        $result =  $this->update([
            'status' => Status::sold,
            'status_info' => $this->statusInfo('sold', $moderator),
        ]);

        return $result;
    }

    public function discount($new_price)
    {
        if ($new_price) {
            $result = $this->update([
                'price' => $new_price
            ]);

            return $result;
        }
    }

    public function statusInfo($status, $moderator = 'system', $error = null)
    {
        $status_info = json_decode($this->attributes['status_info'], true) ?? [];

        array_push($status_info, [
            'user' => $moderator,
            'change_status_from' => $this->attributes['status'],
            'change_status_to' => $status,
            'error' => $error,
            'datetime' => now()->format('Y-m-d H:s:i'),
        ]);

        return $status_info;
    }
}
