<?php

namespace App;

use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use App\Slug;

class Event extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, Auditable;

    public $table = 'events';

    protected $primaryKey = 'id';
    protected $slug_prefix = 'event/';
    protected $page_type = 'events';


    public function getBasicData()
    {
        $ret_arr = array();
        $ret_arr['table_name']  = $this->table;
        $ret_arr['primary_key'] = $this->primaryKey;
        $ret_arr['page_type']   = $this->page_type;
        $ret_arr['slug_prefix'] = $this->slug_prefix;
        return $ret_arr;
    }


    protected $appends = [
        'image',
        'banner',
        'menu_icon',
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'date',
        'slug',
        'title',
        'popular',
        'publish',
        'featured',
        'sort',
        'top',
        'bottom',
        'viewed',
        'update_by',
        'meta_title',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'meta_keywords',
        'long_description',
        'meta_description',
        'short_description',
        'banner_description',
    ];
    public function scopeCustomWhereBasedData($query,$siteid=null) {
		return $query
			->where('publish', 1)
			->has('slugs')
			//->with(['slugs','sites'])
            ->with(['slugs' => function($slugQuery){
                $slugQuery->select(['id','obj_id','slug','old_slug']);
            }])->with(['sites' => function($siteQuery){
                $siteQuery->select(['id','name']);
            }])
            ->whereHas('sites', function($q) use ($siteid){
            $q->where('site_id',$siteid);
            });
	}
    public function slugs() {
        return $this->hasOne(Slug::class, 'obj_id', $this->primaryKey)->where('table_name', $this->table);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function sites()
    {
        return $this->belongsToMany(Site::class);
    }

    public function getImageAttribute()
    {
        $file = $this->getMedia('image')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
        }

        return $file;
    }

    public function getBannerAttribute()
    {
        $file = $this->getMedia('banner')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
        }

        return $file;
    }

    public function getMenuIconAttribute()
    {
        $file = $this->getMedia('menu_icon')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
        }

        return $file;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class);
    }

    public function getDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
