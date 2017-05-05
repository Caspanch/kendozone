<?php

namespace App;

use App\Exceptions\NotOwningAssociationException;
use App\Exceptions\NotOwningClubException;
use App\Exceptions\NotOwningFederationException;
use Cviebrock\EloquentSluggable\Sluggable;
use DateTime;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\AuditingTrait;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;

/**
 * @property  mixed name
 * @property  mixed email
 * @property  mixed password
 * @property bool verified
 * @property mixed token
 * @property  mixed clearPassword
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, SoftDeletes, Sluggable, AuditingTrait, Notifiable, HasApiTokens, Impersonate;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'email'
            ]
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'password_confirmation'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Boot the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            $softDeletedUser = User::onlyTrashed()->where('email', '=', $user->email)->first();
            if ($softDeletedUser != null) {
                $softDeletedUser->restore();
                return false;
            } else {
                $user->token = str_random(30);
                if ($user->country_id == 0) {
                    $user->addGeoData();
                }


            }
            return true;
        });

        // If a User is deleted, you must delete:
        // His tournaments, his competitors

        static::deleting(function ($user) {
            foreach ($user->tournaments as $tournament) {
                $tournament->delete();
            }
            $user->competitors()->delete();

        });
        static::restoring(function ($user) {
            $user->competitors()->withTrashed()->restore();
            foreach ($user->tournaments()->withTrashed()->get() as $tournament) {
                $tournament->restore();
            }

        });
    }


    /**
     * Add geoData based on IP
     */
    function addGeoData()
    {
        $ip = request()->ip();
        $location = geoip($ip);
        $country = Country::where('name', '=', $location->country)->first();
        if (is_null($country)) {
            $countryId = config('constants.COUNTRY_ID_DEFAULT');
            $city = "Paris";
            $latitude = 48.858222;
            $longitude = 2.2945;

        } else {
            $countryId = $country->id;
            $city = $location['city'];
            $latitude = $location['lat'];
            $longitude = $location['lon'];

        }
        $this->country_id = $countryId;
        $this->city = $city;
        $this->latitude = $latitude;
        $this->longitude = $longitude;


    }


    /**
     * Confirm the user.
     *
     * @return void
     */
    public function confirmEmail()
    {
        $this->verified = true;
        $this->token = null;
        $this->save();
    }

    /**
     * Upload Pic
     * @param $data
     * @return array
     */
    public static function uploadPic($data)
    {
        $file = array_first(Input::file(), null);

        if ($file != null && $file->isValid()) {

            $destinationPath = config('constants.RELATIVE_AVATAR_PATH');
            $date = new DateTime();
            $timestamp = $date->getTimestamp();
            $ext = $file->getClientOriginalExtension();
            $fileName = $timestamp . "_" . $file->getClientOriginalName();
            $fileName = Str::slug($fileName, '-') . "." . $ext;

            if (!$file->move($destinationPath, $fileName)) {
                flash()->error("La subida del archivo ha fallado, vuelve a subir su foto por favor");
                return $data;
            } else {
                $data['avatar'] = $fileName;
                // Redimension and pic
                $img = Image::make($destinationPath . $fileName);
                if ($img->width() > $img->height()) {
                    $img->resize(200, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                } else {
                    $img->resize(null, 200, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $img->save($destinationPath . $fileName);


                return $data;
            }
        }
        return $data;
    }


    /**
     * @param $avatar
     * @return string
     */
    public function getAvatarAttribute($avatar)
    {

        if (!isset($avatar) && Gravatar::exists($this->email)) {
            $avatar = Gravatar::src($this->email);
        }

        if (!str_contains($avatar, 'http') && isset($avatar)) {

            $avatar = config('constants.AVATAR_PATH') . $avatar;
        }
        return $avatar;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grade()
    {
        return $this->belongsTo('App\Grade');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function settings()
    {
        return $this->hasOne('App\Settings');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invites()
    {
        return $this->hasMany('App\Invite', 'email', 'email');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('Webpatser\Countries\Countries');
    }

    /**
     * Get all user's created (owned) tournmanents
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tournaments()
    {
        return $this->hasMany('App\Tournament');
    }

    /**
     * Get all deleted user's tournmanents
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tournamentsDeleted()
    {
        return $this->hasMany('App\Tournament')->onlyTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'competitor', 'user_id', 'championship_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function championships()
    {
        return $this->belongsToMany(Championship::class, 'competitor')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function federation()
    {
        return $this->belongsTo(Federation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function association()
    {
        return $this->belongsTo(Association::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function associations()
    {
        return $this->hasMany(Association::class, 'president_id');
    }

    /**
     * A president of federation owns a federation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function federationOwned()
    {
        return $this->belongsTo(Federation::class, 'id', 'president_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function associationOwned()
    {
        return $this->belongsTo(Association::class, 'id', 'president_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clubOwned()
    {
        return $this->belongsTo(Club::class, 'id', 'president_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function competitors()
    {
        return $this->hasMany(Competitor::class);
    }

    /**
     * @return mixed
     */
    public function myTournaments()
    {
        return Tournament::leftJoin('championship', 'championship.tournament_id', '=', 'tournament.id')
            ->leftJoin('competitor', 'competitor.championship_id', '=', 'championship.id')
            ->where('competitor.user_id', '=', $this->id)
            ->select('tournament.*')
            ->distinct();
    }


    /**
     * Generate random password
     * @return string
     */
    public static function generatePassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->deleted_at != null;
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->role_id == config('constants.ROLE_SUPERADMIN');
    }

    /**
     * @return bool
     */
    public function isFederationPresident()
    {
        return $this->role_id == config('constants.ROLE_FEDERATION_PRESIDENT');
    }

    /**
     * @return bool
     */
    public function isAssociationPresident()
    {
        return $this->role_id == config('constants.ROLE_ASSOCIATION_PRESIDENT');
    }

    /**
     * @return bool
     */
    public function isClubPresident()
    {
        return $this->role_id == config('constants.ROLE_CLUB_PRESIDENT');
    }

    /**
     * @return bool
     */
    public function isUser()
    {
        return $this->role_id == config('constants.ROLE_USER');
    }

    /**
     * @param $tournament
     * @return bool
     */
    public function isOwner($tournament)
    {
        return $tournament->user_id == $this->id;
    }

    /**
     * @param $query
     * @param User $user
     * @return Builder
     * @throws AuthorizationException
     * @throws NotOwningAssociationException
     * @throws NotOwningClubException
     * @throws NotOwningFederationException
     */
    public function scopeForUser($query, User $user)
    {
        // If user manage a structure, he will be limited to see entity of this structure
        // If user has the role but manage no structure --> AuthorizationException
        switch (true) {
            case $user->isSuperAdmin():
                return $query;
            case $user->isFederationPresident() && $user->federationOwned != null:
                return $query->where('federation_id', '=', $user->federationOwned->id);
            case $user->isAssociationPresident() && $user->associationOwned:
                return $query->where('association_id', '=', $user->associationOwned->id);
            case $user->isClubPresident() && $user->clubOwned != null:
                return $query->where('club_id', '=', $user->clubOwned->id);

            case $user->isFederationPresident() && !$user->federationOwned != null:
                throw new NotOwningFederationException();
            case $user->isAssociationPresident() && !$user->associationOwned:
                throw new NotOwningAssociationException();
            case $user->isClubPresident() && $user->clubOwned == null:
                throw new NotOwningClubException();
            default:
                throw new AuthorizationException();
        }

    }

    /**
     * @param $firstname
     * @param $lastname
     */
    public function updateUserFullName($firstname, $lastname)
    {
        Auth::user()->firstname = $firstname;
        Auth::user()->lastname = $lastname;
        Auth::user()->save();
    }

    /**
     * @param $attributes
     * @return static $user
     */
    public static function registerToCategory($attributes)
    {
        $user = User::where(['email' => $attributes['email']])->withTrashed()->first();

        if ($user == null) {
            $password = null;
            $user = new User;
            $user->name = $attributes['name'];
            $user->firstname = $attributes['firstname'];
            $user->lastname = $attributes['lastname'];
            $user->email = $attributes['email'];
            $password = User::generatePassword();
            $user->password = bcrypt($password);
            $user->verified = 1;
            $user->save();
            $user->clearPassword = $password;
        } // If user is deleted, this is restoring the user only, but not his asset ( tournaments, categories, etc.)
        else if ($user->isDeleted()) {
            $user->deleted_at = null;
            $user->save();
        }
        // Fire Events

        return $user;
    }

    /**
     * @return Collection
     */
    public static function fillSelect()
    {

        $users = new Collection();
        if (Auth::user()->isSuperAdmin()) {
            $users = User::pluck('name', 'id')->prepend('-', 0);
        } else if (Auth::user()->isFederationPresident() && Auth::user()->federationOwned != null) {
            $users = User::where('federation_id', '=', Auth::user()->federationOwned->id)->pluck('name', 'id')->prepend('-', 0);
        } else if (Auth::user()->isAssociationPresident() && Auth::user()->associationOwned != null) {
            $users = User::where('association_id', '=', Auth::user()->associationOwned->id)->pluck('name', 'id')->prepend('-', 0);
        } else if (Auth::user()->isClubPresident() && Auth::user()->clubOwned != null) {
            $users = User::where('club_id', '=', Auth::user()->clubOwned->id)->pluck('name', 'id')->prepend('-', 0);
        }
        return $users;
    }

    /**
     * @return Collection
     */
    public static function getClubPresidentsList()
    {
        $users = new Collection();
        if (Auth::user()->isSuperAdmin()) {
            $users = User::pluck('name', 'id');
        } else if (Auth::user()->isFederationPresident() && Auth::user()->federationOwned != null) {
            $users = User::where('federation_id', '=', Auth::user()->federationOwned->id)->pluck('name', 'id')->prepend('-', 0);
        } else if (Auth::user()->isAssociationPresident() && Auth::user()->associationOwned != null) {
            $users = User::where('association_id', '=', Auth::user()->associationOwned->id)->pluck('name', 'id')->prepend('-', 0);
        } else if (Auth::user()->isClubPresident() && Auth::user()->clubOwned != null) {
            $users = User::where('id', Auth::user()->id)->pluck('name', 'id')->prepend('-', 0);
        }
        return $users;

    }

    /**
     * Check if a user is registered to a tournament
     * @param Tournament $tournament
     * @return bool
     */
    public function isRegisteredTo(Tournament $tournament)
    {
        $championships = $tournament->championships;
        $ids = $championships->pluck('id');

        $isRegistered = Competitor::where('user_id', $this->id)
            ->whereIn('championship_id', $ids)
            ->get();

        return sizeof($isRegistered) > 0;
    }

    /**
     * @return bool
     */
    public function canImpersonate()
    {
        return $this->isSuperAdmin();
    }

    /**
     * @return bool
     */
    public function canBeImpersonated()
    {
        return $this->isSuperAdmin();
    }


    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->firstname ?? '' . " " . $this->lastname ?? '';
    }
}
