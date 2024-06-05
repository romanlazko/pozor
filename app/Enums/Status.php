<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Facades\App;

enum Status: int implements HasLabel
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

    public function getLabel() : ?string
    {
        return match ($this) {
            self::created => match (App::getLocale()) {
                'ru' => 'Создан',
                'en' => 'Created',
                'cs' => 'Vytvořen',
            },
            self::await_moderation => match (App::getLocale()) {
                'ru' => 'Ожидает модерации',
                'en' => 'Await moderation',
                'cs' => 'Ceka na moderaci',
            },
            self::moderation_not_passed => match (App::getLocale()) {
                'ru' => 'Модерация не прошла',
                'en' => 'Moderation not passed',
                'cs' => 'Moderace nebyla prosána',
            },
            self::moderation_failed => match (App::getLocale()) {
                'ru' => 'Ошибка модерации',
                'en' => 'Moderation failed',
                'cs' => 'Chyba moderace',
            },
            self::rejected => match (App::getLocale()) {
                'ru' => 'Отклонено',
                'en' => 'Rejected',
                'cs' => 'Zamitnuto',
            },
            self::approved => match (App::getLocale()) {
                'ru' => 'Одобрено',
                'en' => 'Approved',
                'cs' => 'Schváleno',
            },
            self::await_translation => match (App::getLocale()) {
                'ru' => 'Ожидает перевода',
                'en' => 'Await translation',
                'cs' => 'Ceka na prevod',
            },
            self::translation_failed => match (App::getLocale()) {
                'ru' => 'Перевод не прошёл',
                'en' => 'Translation failed',
                'cs' => 'Prevod nebyl prosán',
            },
            self::translated => match (App::getLocale()) {
                'ru' => 'Переведено',
                'en' => 'Translated',
                'cs' => 'Prevod',
            },
            self::await_publication => match (App::getLocale()) {
                'ru' => 'Ожидает публикации',
                'en' => 'Await publication',
                'cs' => 'Ceka na publikaci',
            },
            self::publishing_failed => match (App::getLocale()) {
                'ru' => 'Публикация не прошла',
                'en' => 'Publishing failed',
                'cs' => 'Publikace nebyla prosána',
            },
            self::published => match (App::getLocale()) {
                'ru' => 'Опубликовано',
                'en' => 'Published',
                'cs' => 'Publikovano',
            },
            self::sold => match (App::getLocale()) {
                'ru' => 'Продано',
                'en' => 'Sold',
                'cs' => 'Prodáno',
            },
            default => null,
        };
    }
}