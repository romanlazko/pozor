<?php

use App\Enums\Status;

return [
    Status::created => 'Создан',
    Status::await_moderation => 'Ожидает модерации',
    Status::moderation_not_passed => 'Модерация не пройдена',
    Status::moderation_passed => 'Модерация пройдена',
    Status::await_publication => 'Ожидает публикации',
    Status::publishing_failed => 'Ошибка публикации',
    Status::published => 'Опубликован',
    Status::rejected => 'Отклонен',
    Status::sold => 'Продан',
    Status::failed => 'Ошибка',
];