<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddspaceStore extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'addspace_stores';

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
        'vertical_add_script',
        'horizontal_add_script',
    ];

    public function sites()
    {
        return $this->belongsToMany(Site::class);
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }
}
