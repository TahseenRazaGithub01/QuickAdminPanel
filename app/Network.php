<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Network extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'networks';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'api_key',
        'publish',
        'affiliate',
        'secret_key',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function networkStores()
    {
        return $this->hasMany(Store::class, 'network_id', 'id');
    }

    public function sites()
    {
        return $this->belongsToMany(Site::class);
    }
}
