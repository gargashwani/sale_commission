<?php

namespace App\Models;

use App\Models\Sale;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Saletype extends Model
{
    use HasFactory;
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
        return $this->belongsTo('App\Models\User');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    public function sale()
    {
        return $this->hasMany('App\Models\Sale');
    }
}
