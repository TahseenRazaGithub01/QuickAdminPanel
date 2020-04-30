<?php

namespace App;

use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Coupon extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, Auditable;

    public $table = 'coupons';

    protected $appends = [
        'image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'date_expiry',
        'date_available',
    ];

    const TYPE_SELECT = [
        'coupon'   => 'Coupon',
        'banner'   => 'Banner',
        'featured' => 'Featured',
    ];

    protected $fillable = [
        'type',
        'code',
        'sort',
        'title',
        'viewed',
        'publish',
        'popular',
        'featured',
        'store_id',
        'verified',
        'coupon_id',
        'recommended',
        'exclusive',
        'updated_at',
        'created_at',
        'deleted_at',
        'updated_by',
        'created_by',
        'date_expiry',
        'description',
        'affiliate_url',
        'free_shipping',
        'date_available',
        'special_event_sort',
        'custom_image_title',
    ];

    public function scopeCustomWhereBasedData($query,$siteid=null) {
		return $query
			->where('publish', 1)
            ->orderBy('sort')
			->with('sites')
            ->whereHas('sites', function($q) use ($siteid){
            $q->where('site_id',$siteid);
            });
	}

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(150)->height(150);
    }

    public function couponCoupons()
    {
        return $this->hasMany(Coupon::class, 'coupon_id', 'id');
    }

    public function couponEvents()
    {
        return $this->belongsToMany(Event::class);
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

    public function getDateAvailableAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateAvailableAttribute($value)
    {
        $this->attributes['date_available'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDateExpiryAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateExpiryAttribute($value)
    {
        $this->attributes['date_expiry'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
}
