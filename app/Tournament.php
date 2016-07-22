<?php

namespace App;

use Carbon\Carbon;
use Countries;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use GeoIP;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\AuditingTrait;


/**
 * @property mixed type
 * @property float latitude
 * @property float longitude
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed deleted_at
 */
class Tournament extends Model implements SluggableInterface
{
    use SoftDeletes;
    use SluggableTrait;
    use AuditingTrait;

    protected $sluggable = [
        'build_from' => 'name',
        'save_to' => 'slug',
    ];
    protected $table = 'tournament';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'dateIni',
        'dateFin',
        'registerDateLimit',
        'sport',
        'promoter',
        'host_organization',
        'technical_assistance',
        'category',
        'rule_id',
        'type',
        'venue',
        'latitude',
        'longitude',
        'level_id'
    ];


    protected $dates = ['date', 'registerDateLimit', 'created_at', 'updated_at', 'deleted_at'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($tournament) {

            $tournament->addGeoData();

        });
        static::deleting(function ($tournament) {
            foreach ($tournament->categoryTournaments as $ct) {
                $ct->delete();
            }
            $tournament->invites()->delete();

        });
        static::restoring(function ($tournament) {

            foreach ($tournament->categoryTournaments()->withTrashed()->get() as $ct) {
                $ct->restore();
            }

        });

    }

    function addGeoData()
    {
        $location = GeoIP::getLocation(getIP()); // Simulating IP in Mexico DF
        $country = Countries::where('name', '=', $location['country'])->first();
        if (is_null($country)) {
            $latitude = 48.858222;
            $longitude = 2.2945;
        } else {
            $latitude = $location['lat'];
            $longitude = $location['lon'];
        }
        $this->latitude = $latitude;
        $this->longitude = $longitude;


    }

    /**
     * A tournament is owned by a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Get All Tournaments levels
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level()
    {
        return $this->belongsTo('App\TournamentLevel', 'level_id', 'id');
    }


    // We can use $tournament->categories()->attach(id);
    // Or         $tournament->categories()->sync([1, 2, 3]);
    public function categories()
    {
        return $this->belongsToMany('App\Category')
            ->withPivot('id')
            ->withTimestamps();
    }

    /**
     * Get All categoriesTournament that belongs to a tournament
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoryTournaments()
    {
        return $this->hasMany(CategoryTournament::class);
    }


    /**
     * Get All categoriesSettings that belongs to a tournament
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function categorySettings()
    {
        return $this->hasManyThrough(CategorySettings::class, CategoryTournament::class);
    }

    public function teams()
    {
        return $this->hasManyThrough(Team::class, CategoryTournament::class);
    }

    /**
     * Get All competitors that belongs to a tournament
     * @param null $CategoryTournamentId
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function competitors($CategoryTournamentId = null)
    {
        return $this->hasManyThrough(CategoryTournamentUser::class, CategoryTournament::class);
    }


    /**
     * Get all Invitations that belongs to a tournament
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invites()
    {
        return $this->morphMany(Invite::class, 'object');
    }

    public function getCategoryList()
    {
        return $this->categories->lists('id')->all();
    }


    public function getRegisterDateLimitAttribute($date)
    {
        return $date;
    }

    public function setDateIniAttribute($date)
    {
        $this->attributes['dateIni'] = Carbon::createFromFormat('Y-m-d', $date);
    }

    public function setDateFinAttribute($date)
    {
        $this->attributes['dateFin'] = Carbon::createFromFormat('Y-m-d', $date);
    }

    public function setLimitRegisterDateAttribute($date)
    {
        $this->attributes['registerDateLimit'] = Carbon::createFromFormat('Y-m-d', $date);
    }

    public function isOpen()
    {
        return $this->type == 1;
    }

    public function needsInvitation()
    {
        return $this->type == 0;
    }

    public function isInternational()
    {
        return $this->level_id == 8;
    }

    public function isNational()
    {
        return $this->level_id == 7;
    }

    public function isRegional()
    {
        return $this->level_id == 6;
    }

    public function isEstate()
    {
        return $this->level_id == 5;
    }

    public function isMunicipal()
    {
        return $this->level_id == 4;
    }

    public function isDistrictal()
    {
        return $this->level_id == 3;
    }

    public function isLocal()
    {
        return $this->level_id == 2;
    }

    public function hasNoLevel()
    {
        return $this->level_id == 1;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function isDeleted()
    {
        return $this->deleted_at != null;
    }


    public function setAndConfigureCategories($ruleId)
    {
        if ($ruleId == 0) return; // No Rules Selected

        $options = $this->loadRulesOptions($ruleId);

        // Create Tournament Categories
        $arrCategories = array_keys($options);
        $this->categories()->sync($arrCategories);

        // Configure each category creating categorySetting Object

        foreach ($this->categoryTournaments as $categoryTournament) {
            (new CategorySettings)->createCategorySettingFromOptions($options, $categoryTournament);
        }

    }

//    private function categoryModel($id)
//    {
//        return Category::findOrFail($id);
//    }


    private function loadRulesOptions($ruleId)
    {
        switch ($ruleId) {
            case 0: // No preset selected
                return null;
            case 1:
                return $options = config('options.ikf_settings');
                break;
            case 2:
                return $options = config('options.ekf_settings');
                break;
            case 3:
                return $options = config('options.lakc_settings');
                break;
            default:
                return null;
        }
    }

    /**
     * create a category List with Category name associated to categoryTournamentId
     *
     * @return array
     */
    public function buildCategoryList()
    {
        $cts = CategoryTournament::with('category')->where('tournament_id', $this->id)->get();

        $array = [];
        foreach ($cts as $ct) {
            $array[$ct->id] = $ct->category->name;

        }

        return $array;

    }


    public function hasTeamCategory()
    {
        return $this
            ->categorySettings()
            ->where('teamSize', '>', '0')
            ->where('teamSize', '<>', null)
            ->count();
    }


}