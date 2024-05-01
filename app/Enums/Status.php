<?php

namespace App\Enums;

enum Status: int
{
    case created = 1;
    case await_moderation = 2;
    case moderation_not_passed = 3;
    case moderation_passed = 4;
    case await_publication = 5;
    case publishing_failed = 6;
    case published = 7;
    case rejected = 8;
    case sold = 9;
    case failed = 10;

    public function isCreated(): bool
    {
        return $this === static::created;
    }

    public function isAwaitModeration(): bool
    {
        return $this === static::await_moderation;
    }

    public function isModerationNotPassed(): bool
    {
        return $this === static::moderation_not_passed;
    }

    public function isModerationPassed(): bool
    {
        return $this === static::moderation_passed;
    }

    public function isAwaitPublication(): bool
    {
        return $this === static::await_publication;
    }

    public function isPublishingFailed(): bool
    {
        return $this === static::publishing_failed;
    }

    public function isPublished(): bool
    {
        return $this === static::published;
    }

    public function isRejected(): bool
    {
        return $this === static::rejected;
    }

    public function isSold(): bool
    {
        return $this === static::sold;
    }

    public function isFailed(): bool
    {
        return $this === static::failed;
    }

    public function color()
    {
        return match ($this) {
            self::await_moderation => 'orange',
            self::moderation_not_passed => 'red',
            self::moderation_passed => 'green',
            self::await_publication => 'blue',
            self::publishing_failed => 'purple',
            self::published => 'green',
            self::rejected => 'red',
            self::sold => 'gray',
            self::failed => 'red',
            default => 'gray',
        };
    }

    public function filamentColor()
    {
        return match ($this) {
            self::await_moderation => 'warning',
            self::moderation_not_passed => 'danger',
            self::moderation_passed => 'success',
            self::await_publication => 'primary',
            self::publishing_failed => 'purple',
            self::published => 'success',
            self::rejected => 'danger',
            self::sold => 'success',
            self::failed => 'danger',
            default => 'info',
        };
    }

    public function trans($lang = null)
    {
        return __('statuses.'.$this->name, [], $lang);
    }
}