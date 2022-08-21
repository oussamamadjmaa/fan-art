<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Artwork
 *
 * @property int $id
 * @property int $user_id
 * @property string $slug
 * @property string $title
 * @property int $price
 * @property string $image
 * @property string|null $materials_used
 * @property string|null $tools
 * @property bool $outer_frame
 * @property string|null $dimensions
 * @property bool $covered_with_glass
 * @property string|null $location
 * @property string|null $description
 * @property int $status
 * @property string|null $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $price_format
 * @property-read mixed $status_text
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork activeSubscribedArtist()
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork notReady()
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork query()
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork ready()
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork sold()
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork whereCoveredWithGlass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork whereDimensions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork whereMaterialsUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork whereOuterFrame($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork whereTools($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artwork whereUserId($value)
 */
	class Artwork extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Carousel
 *
 * @property int $id
 * @property string $name
 * @property string $background_image
 * @property bool $cover
 * @property string|null $text
 * @property string|null $secondary_text
 * @property int $order
 * @property string $action
 * @property array|null $action_data
 * @property bool $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel active()
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereActionData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereBackgroundImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereSecondaryText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereUpdatedAt($value)
 */
	class Carousel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Exhibition
 *
 * @property int $id
 * @property int $user_id
 * @property int $sponsor_id
 * @property string $slug
 * @property string $name
 * @property \Illuminate\Support\Carbon $from_date
 * @property \Illuminate\Support\Carbon $to_date
 * @property string $country
 * @property string|null $city
 * @property string|null $registration_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $from_to_date
 * @property-read \App\Models\Sponsor $sponsor
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Exhibition activeSubscribedArtist()
 * @method static \Illuminate\Database\Eloquent\Builder|Exhibition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exhibition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exhibition query()
 * @method static \Illuminate\Database\Eloquent\Builder|Exhibition whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exhibition whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exhibition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exhibition whereFromDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exhibition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exhibition whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exhibition whereRegistrationUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exhibition whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exhibition whereSponsorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exhibition whereToDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exhibition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exhibition whereUserId($value)
 */
	class Exhibition extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\News
 *
 * @property int $id
 * @property int $user_id
 * @property string $slug
 * @property string $title
 * @property string $image
 * @property string|null $image_description
 * @property string $body
 * @property array|null $seo
 * @property bool $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News published()
 * @method static \Illuminate\Database\Eloquent\Builder|News query()
 * @method static \Illuminate\Database\Eloquent\Builder|News whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereImageDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSeo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUserId($value)
 */
	class News extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Page
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $content
 * @property array|null $seo
 * @property bool $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $link
 * @method static \Illuminate\Database\Eloquent\Builder|Page active()
 * @method static \Database\Factories\PageFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSeo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 */
	class Page extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $user_id
 * @property int $paymentable_id
 * @property string $paymentable_type
 * @property string|null $transaction_id
 * @property string|null $payment_method
 * @property string|null $confirmation_picture
 * @property array|null $payment_data
 * @property int $price
 * @property string $description
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $paymentable
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereConfirmationPicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUserId($value)
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Plan
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property string|null $short_description
 * @property string|null $description
 * @property array|null $features
 * @property int $price
 * @property int $level
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read int|null $payments_count
 * @method static \Illuminate\Database\Eloquent\Builder|Plan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereUpdatedAt($value)
 */
	class Plan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SiteConfig
 *
 * @property int $id
 * @property string $key
 * @property array|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SiteConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteConfig query()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteConfig whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteConfig whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteConfig whereValue($value)
 */
	class SiteConfig extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Sponsor
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $logo
 * @property string|null $website
 * @property string $country
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exhibition[] $exhibitions
 * @property-read int|null $exhibitions_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereWebsite($value)
 */
	class Sponsor extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Subscription
 *
 * @property int $id
 * @property int $user_id
 * @property int $plan_id
 * @property int $status
 * @property \Illuminate\Support\Carbon $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $status_text
 * @property-read \App\Models\Plan $plan
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription active()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereUserId($value)
 */
	class Subscription extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property string $name
 * @property string|null $phone
 * @property string $email
 * @property string|null $skype
 * @property string|null $country
 * @property string|null $nationality
 * @property string|null $address
 * @property string $gender
 * @property string|null $website
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property bool $status
 * @property string|null $avatar
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Subscription|null $activeSubscription
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artwork[] $artworks
 * @property-read int|null $artworks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exhibition[] $exhibitions
 * @property-read int|null $exhibitions_count
 * @property-read mixed $avatar_url
 * @property-read mixed $fullname
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\News[] $news
 * @property-read int|null $news_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\UserProfile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Sponsor[] $sponsors
 * @property-read int|null $sponsors_count
 * @property-read \App\Models\Subscription|null $subscription
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User active()
 * @method static \Illuminate\Database\Eloquent\Builder|User activeSubscribedArtist()
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User subscribed()
 * @method static \Illuminate\Database\Eloquent\Builder|User verified()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSkype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App\Models{
/**
 * App\Models\UserProfile
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $bio
 * @property array|null $social_media
 * @property array|null $docs
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereDocs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereSocialMedia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereUserId($value)
 */
	class UserProfile extends \Eloquent {}
}

