<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $title
 * @property array|null $translated_title
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $translated_description
 * @property int|null $current_price
 * @property int|null $old_price
 * @property string|null $currency_id
 * @property int|null $category_id
 * @property int|null $geo_id
 * @property float|null $latitude
 * @property float|null $longitude
 * @property int $should_be_published_in_telegram
 * @property int $views
 * @property \App\Enums\Status|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attribute> $attributes
 * @property-read int|null $attributes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Romanlazko\Telegram\Models\TelegramChat|null $chat
 * @property-read \App\Models\AttributeOption|null $currency
 * @property-read mixed $original_description
 * @property-read mixed $original_title
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement categories(?\App\Models\Category $category)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement features(?\App\Models\Category $category, ?array $attributes)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement isPublished()
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement price($price = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement radius($latitude, $longitude, $radius)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement search($search = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereCurrentPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereGeoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereOldPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereShouldBePublishedInTelegram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereTranslatedDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereTranslatedTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement withoutTrashed()
 */
	class Announcement extends \Eloquent implements \Spatie\MediaLibrary\HasMedia, \OwenIt\Auditing\Contracts\Auditable {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AnnouncementAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnouncementAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnouncementAttachment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnouncementAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnouncementAttachment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnouncementAttachment withoutTrashed()
 */
	class AnnouncementAttachment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $announcement_id
 * @property int $attribute_id
 * @property array|null $value
 * @property-read \App\Models\Attribute $attribute
 * @property-read mixed $formated_value
 * @property-read mixed $original_value
 * @method static \Illuminate\Database\Eloquent\Builder|AnnouncementAttribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnouncementAttribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnouncementAttribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnouncementAttribute whereAnnouncementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnouncementAttribute whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnouncementAttribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnouncementAttribute whereValue($value)
 */
	class AnnouncementAttribute extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $label
 * @property array|null $alterlabels
 * @property string|null $create_type
 * @property string|null $search_type
 * @property int|null $attribute_section_id
 * @property string|null $column_span
 * @property string|null $column_start
 * @property int|null $order_number
 * @property array|null $visible
 * @property int|null $attribute_option_id
 * @property int $translatable
 * @property int $is_feature
 * @property int $required
 * @property int $searchable
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttributeOption> $attribute_options
 * @property-read int|null $attribute_options_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read mixed $featured_name
 * @property-read \App\Models\AttributeSection|null $section
 * @method static \Database\Factories\AttributeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute findByName($name)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereAlterlabels($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereAttributeOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereAttributeSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereColumnSpan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereColumnStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereCreateType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereIsFeature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereSearchType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereSearchable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereTranslatable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereVisible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute withoutTrashed()
 */
	class Attribute extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $attribute_id
 * @property string|null $name
 * @property array|null $alternames
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption whereAlternames($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption withoutTrashed()
 */
	class AttributeOption extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $slug
 * @property array|null $alternames
 * @property int|null $order_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attribute> $attributes
 * @property-read int|null $attributes_count
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSection onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSection query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSection whereAlternames($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSection whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSection whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSection whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSection whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSection withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeSection withoutTrashed()
 */
	class AttributeSection extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $name
 * @property array|null $alternames
 * @property string|null $slug
 * @property string|null $icon_name
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Announcement> $announcements
 * @property-read int|null $announcements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attribute> $attributes
 * @property-read int|null $attributes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $children
 * @property-read int|null $children_count
 * @property-read mixed $translated_name
 * @property-read Category|null $parent
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereAlternames($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIconName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Category withoutTrashed()
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\Attribute|null $attribute
 * @property-read mixed $label
 * @property-read mixed $not_formated_value
 * @property-read mixed $value
 * @method static \Illuminate\Database\Eloquent\Builder|Feature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature withoutTrashed()
 */
	class Feature extends \Eloquent {}
}

namespace App\Models\Messanger{
/**
 * 
 *
 * @property int $id
 * @property int $thread_id
 * @property int $user_id
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereThreadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Message withoutTrashed()
 */
	class Message extends \Eloquent {}
}

namespace App\Models\Messanger{
/**
 * 
 *
 * @property int $id
 * @property int $announcement_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Announcement $announcement
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Messanger\Message> $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Thread newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Thread newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Thread onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Thread query()
 * @method static \Illuminate\Database\Eloquent\Builder|Thread whereAnnouncementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thread whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thread whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thread whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thread whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thread withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Thread withoutTrashed()
 */
	class Thread extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Translation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation query()
 */
	class Translation extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $avatar
 * @property int|null $telegram_chat_id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $phone
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Announcement> $announcements
 * @property-read int|null $announcements_count
 * @property-read \Romanlazko\Telegram\Models\TelegramChat|null $chat
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Romanlazko\Telegram\Models\TelegramBot> $telegram_bots
 * @property-read int|null $telegram_bots_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Messanger\Thread> $threads
 * @property-read int|null $threads_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTelegramChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

