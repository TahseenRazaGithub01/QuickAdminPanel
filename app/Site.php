<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Site extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, Auditable;

    public $table = 'sites';

    protected $appends = [
        'flag',
        'logo',
        'favicon',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'url',
        'name',
        'twitter',
        'youtube',
        'publish',
        'facebook',
        'html_tags',
        'linked_in',
        'created_at',
        'updated_at',
        'deleted_at',
        'country_name',
        'country_code',
        'language_code',
        'javascript_tags',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function siteCategories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function siteStores()
    {
        return $this->belongsToMany(Store::class);
    }

    public function siteCoupons()
    {
        return $this->belongsToMany(Coupon::class);
    }

    public function sitePages()
    {
        return $this->belongsToMany(Page::class);
    }

    public function sitePresses()
    {
        return $this->belongsToMany(Press::class);
    }

    public function siteEvents()
    {
        return $this->belongsToMany(Event::class);
    }

    public function siteTags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function siteProductCategories()
    {
        return $this->belongsToMany(ProductCategory::class);
    }

    public function siteAddspaceStores()
    {
        return $this->belongsToMany(AddspaceStore::class);
    }

    public function siteAddSpaceProducts()
    {
        return $this->belongsToMany(AddSpaceProduct::class);
    }

    public function siteBanners()
    {
        return $this->belongsToMany(Banner::class);
    }

    public function siteNetworks()
    {
        return $this->belongsToMany(Network::class);
    }

    public function siteBlogs()
    {
        return $this->belongsToMany(Blog::class);
    }

    public function siteProducts()
    {
        return $this->belongsToMany(Product::class);
    }

    public function getFlagAttribute()
    {
        $file = $this->getMedia('flag')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
        }

        return $file;
    }

    public function getLogoAttribute()
    {
        $file = $this->getMedia('logo')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
        }

        return $file;
    }

    public function getFaviconAttribute()
    {
        $file = $this->getMedia('favicon')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
        }

        return $file;
    }
}
