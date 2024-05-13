<?php

namespace App\Enums;

enum Status: int
{
    case created = 1;
    case await_moderation = 2;
    case moderation_failed = 3;
    case moderation_not_passed = 4;
    case rejected = 5;
    case approved = 6;
    case await_translation = 7;
    case translation_failed = 8;
    case translated = 9;
    case await_publication = 10;
    case publishing_failed = 11;
    case published = 12;
    case sold = 13;

    public function isCreated(): bool
    {
        return $this === static::created;
    }

    public function isOnModeration(): bool
    {
        return $this === static::await_moderation || $this === static::moderation_failed || $this === static::moderation_not_passed;
    }

    public function isAwaitModeration(): bool
    {
        return $this === static::await_moderation;
    }

    public function isModerationNotPassed(): bool
    {
        return $this === static::moderation_not_passed;
    }

    public function isModerationFailed(): bool
    {
        return $this === static::moderation_failed;
    }

    public function isRejected(): bool
    {
        return $this === static::rejected;
    }

    public function isApproved(): bool
    {
        return $this === static::approved;
    }

    public function isOnTranslation(): bool
    {
        return $this === static::await_translation || $this === static::translation_failed;
    }

    public function isAwaitTranslation(): bool
    {
        return $this === static::await_translation;
    }

    public function isTranslationFailed(): bool
    {
        return $this === static::translation_failed;
    }

    public function isTranslated(): bool
    {
        return $this === static::translated;
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

    public function isSold(): bool
    {
        return $this === static::sold;
    }

    public function color()
    {
        return match ($this) {
            self::created => 'blue',
            self::await_moderation => 'orange',
            self::moderation_not_passed => 'red',
            self::moderation_failed => 'red',
            self::rejected => 'red',
            self::approved => 'green',
            self::await_translation => 'orange',
            self::translation_failed => 'red',
            self::translated => 'green',
            self::await_publication => 'orange',
            self::publishing_failed => 'red',
            self::published => 'green',
            self::sold => 'green',
            default => 'gray',
        };
    }

    public function filamentColor()
    {
        return match ($this) {
            self::created => 'info',
            self::await_moderation => 'warning',
            self::moderation_not_passed => 'danger',
            self::moderation_failed => 'danger',
            self::rejected => 'danger',
            self::approved => 'success',
            self::await_translation => 'warning',
            self::translation_failed => 'danger',
            self::translated => 'success',
            self::await_publication => 'warning',
            self::publishing_failed => 'danger',
            self::published => 'success',
            self::sold => 'info',
            default => 'gray',
        };
    }

    public function trans($lang = null)
    {
        return __('statuses.'.$this->name, [], $lang);
    }
}