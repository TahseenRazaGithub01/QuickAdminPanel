<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Press extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, Auditable;

    public $table = 'presses';

    protected $primaryKey = 'id';
    protected $slug_prefix = 'press/';
    protected $page_type = 'presses';


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
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'slug',
        'sort',
        'title',
        'viewed',
        'publish',
        'featured',
        'update_by',
        'updated_at',
        'created_at',
        'created_by',
        'meta_title',
        'deleted_at',
        'meta_keywords',
        'related_links',
        'show_on_listing',
        'meta_description',
        'long_description',
        'short_description',
    ];

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
}
