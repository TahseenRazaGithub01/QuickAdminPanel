<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use App\Slug;

class ProductCategory extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, Auditable;

    protected $appends = [
        'image',
    ];

    public $table = 'product_categories';

    protected $primaryKey = 'id';
    protected $slug_prefix = 'product/';
    protected $page_type = 'productCategory';


    public function getBasicData()
    {
        $ret_arr = array();
        $ret_arr['table_name']  = $this->table;
        $ret_arr['primary_key'] = $this->primaryKey;
        $ret_arr['page_type']   = $this->page_type;
        $ret_arr['slug_prefix'] = $this->slug_prefix;
        return $ret_arr;
    }


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const TEMPLATE_SELECT = [
        'template_1' => 'template 1',
        'template_2' => 'template_2',
    ];

    protected $fillable = [
        'slug',
        'name',
        'sort',
        'popular',
        'new_url',
        'old_url',
        'publish',
        'featured',
        'template',
        'parent_id',
        'created_at',
        'meta_title',
        'updated_at',
        'deleted_at',
        'description',
        'sub_heading',
        'title_heading',
        'meta_keywords',
        'long_description',
        'meta_description',
        'about_description',
    ];
    
    public function scopeCustomWhereBasedData($query,$siteid=null) {
		return $query
			->where('publish', 1)
			->has('slugs')
			->with(['slugs','sites'])
            ->whereHas('sites', function($q) use ($siteid){
            $q->where('site_id',$siteid);
            });
	}

    public function slugs(){
        return $this->hasOne(Slug::class, 'obj_id', $this->primaryKey)->where('table_name', $this->table);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(90)->height(45);
    }

    public function parentProductCategories()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id');
    }

    public function productAddSpaceProducts()
    {
        return $this->belongsToMany(AddSpaceProduct::class);
    }

    public function productCategoryProducts()
    {
        return $this->belongsToMany(Product::class);
    }

    public function sites()
    {
        return $this->belongsToMany(Site::class);
    }

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
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
