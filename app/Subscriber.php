<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriber extends Model
{
    use SoftDeletes, Auditable;
//    use Auditable;

    public $table = 'subscribers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'email',
        'page_link',
        'longitude',
        'latitude',
        'country',
        'region',
        'city',
        'ip',
        'client_agent',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

     public function sites()
     {
         return $this->belongsToMany(Site::class);
     }
}
