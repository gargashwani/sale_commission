<?php

namespace App;

use App\Sale;
use App\User;
use App\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Saletype extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function sale()
    {
        return $this->hasMany('App\Sale');
    }
}
