<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\Saletype;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Sale extends Model
{
    use HasFactory, Notifiable;

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

    public function saletype(){
        return $this->belongsTo('App\Models\Saletype');
    }
}
