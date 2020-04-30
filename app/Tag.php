<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'tags';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'update_by',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function tagBlogs()
    {
        return $this->belongsToMany(Blog::class);
    }

    public function sites()
    {
        return $this->belongsToMany(Site::class);
    }
}
