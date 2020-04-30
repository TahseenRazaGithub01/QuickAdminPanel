<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddSpaceProduct extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'add_space_products';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'vertical_script',
        'horizontal_script',
    ];

    public function sites()
    {
        return $this->belongsToMany(Site::class);
    }

    public function products()
    {
        return $this->belongsToMany(ProductCategory::class);
    }
}
