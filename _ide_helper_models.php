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
 * App\Models\ApiLog
 *
 * @property-read \App\Models\ApiService|null $apiService
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog query()
 * @mixin \Eloquent
 */
	class IdeHelperApiLog {}
}

namespace App\Models{
/**
 * App\Models\ApiService
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ApiService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiService query()
 * @mixin \Eloquent
 */
	class IdeHelperApiService {}
}

namespace App\Models{
/**
 * App\Models\BankService
 *
 * @property-read \App\Models\ApiService|null $apiService
 * @method static \Illuminate\Database\Eloquent\Builder|BankService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankService query()
 * @mixin \Eloquent
 */
	class IdeHelperBankService {}
}

namespace App\Models{
/**
 * App\Models\LawRegistration
 *
 * @property-read \App\Models\LawService|null $bankService
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|LawRegistration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LawRegistration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LawRegistration query()
 * @mixin \Eloquent
 */
	class IdeHelperLawRegistration {}
}

namespace App\Models{
/**
 * App\Models\LawService
 *
 * @property-read \App\Models\ApiService|null $apiService
 * @method static \Illuminate\Database\Eloquent\Builder|LawService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LawService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LawService query()
 * @mixin \Eloquent
 */
	class IdeHelperLawService {}
}

namespace App\Models{
/**
 * App\Models\PaymentAccount
 *
 * @property-read \App\Models\BankService|null $bankService
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccount query()
 * @mixin \Eloquent
 */
	class IdeHelperPaymentAccount {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $uuid
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $phone
 * @property string $email
 * @property string|null $password
 * @property int $status
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property-read \Illuminate\Database\Eloquent\Collection|\Silber\Bouncer\Database\Ability[] $abilities
 * @property-read int|null $abilities_count
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Silber\Bouncer\Database\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User active()
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIs($role)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAll($role)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsNot($role)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUuid($value)
 */
	class IdeHelperUser {}
}

namespace Silber\Bouncer\Database{
/**
 * Silber\Bouncer\Database\Ability
 *
 * @property int $id
 * @property string $name
 * @property string|null $title
 * @property int|null $entity_id
 * @property string|null $entity_type
 * @property bool $only_owned
 * @property array $options
 * @property int|null $scope
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $identifier
 * @property-read string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection|\Silber\Bouncer\Database\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ability byName($name, $strict = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Ability forModel($model, $strict = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Ability newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ability newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ability query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ability simpleAbility()
 * @method static \Illuminate\Database\Eloquent\Builder|Ability whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ability whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ability whereEntityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ability whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ability whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ability whereOnlyOwned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ability whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ability whereScope($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ability whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ability whereUpdatedAt($value)
 */
	class IdeHelperAbility {}
}

namespace Silber\Bouncer\Database{
/**
 * Silber\Bouncer\Database\Role
 *
 * @property int $id
 * @property string $name
 * @property string|null $title
 * @property int|null $scope
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Silber\Bouncer\Database\Ability[] $abilities
 * @property-read int|null $abilities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereAssignedTo($model, ?array $keys = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereScope($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class IdeHelperRole {}
}

