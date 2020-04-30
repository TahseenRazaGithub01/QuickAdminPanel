<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Category extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, Auditable;

    public $table = 'categories';
    protected $primaryKey   = 'id';
    protected $slug_prefix  = 'categories/';
    protected $page_type    = 'categories';

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
        'icon',
        'image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'sort',
        'slug',
        'title',
        'user_id',
        'popular',
        'publish',
        'featured',
        'parent_id',
        'update_by',
        'updated_at',
        'created_at',
        'created_by',
        'meta_title',
        'deleted_at',
        'meta_keywords',
        'meta_description',
        'long_description',
        'short_description',
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
    public function blogs()
    {
        return $this->belongsToMany(Blog::class);
    }

    public function slugs() {
		return $this->hasOne(Slug::class, 'obj_id', $this->primaryKey)->where('table_name', $this->table);
	}

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function parentCategories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function categoryBlogs()
    {
        return $this->belongsToMany(Blog::class);
    }

    public function categoryCoupons()
    {
        return $this->belongsToMany(Coupon::class);
    }

    public function categoryEvents()
    {
        return $this->belongsToMany(Event::class);
    }

    public function categoryStores()
    {
        return $this->belongsToMany(Store::class);
    }

    public function sites()
    {
        return $this->belongsToMany(Site::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
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

    public function getIconAttribute()
    {
        $file = $this->getMedia('icon')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
        }

        return $file;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
