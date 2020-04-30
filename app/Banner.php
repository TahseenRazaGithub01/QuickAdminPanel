<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Banner extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, Auditable;

    public $table = 'banners';

    protected $appends = [
        'image',
        'store_image',
        'mobile_image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'link',
        'sort',
        'title',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
    public function scopeCustomWhereBasedData($query,$siteid=null) {
		return $query
			->with(['sites' => function($siteQuery){
                $siteQuery->select('id','name','html_tags','javascript_tags');
            }])
            ->whereHas('sites', function($q) use ($siteid){
            $q->where('site_id',$siteid);
            });
	}
    
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(400)->height(90);
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

    public function getStoreImageAttribute()
    {
        $file = $this->getMedia('store_image')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
        }

        return $file;
    }

    public function getMobileImageAttribute()
    {
        $file = $this->getMedia('mobile_image')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
        }

        return $file;
    }
}
