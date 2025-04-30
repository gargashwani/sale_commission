<?php

namespace App\Models;

use App\Models\Sale;
use App\Models\User;
use App\Models\Saletype;
use App\Models\CommissionRate;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    //because all the fields are guarded by default, so we are making them free from guard
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'status', 'city', 'state', 'address', 'zip', 'phone', 'bgcolor', 'bordercolor'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function saletypes()
    {
        return $this->hasMany(Saletype::class);
    }

    public function commissionRates()
    {
        return $this->hasMany(CommissionRate::class);
    }
}
