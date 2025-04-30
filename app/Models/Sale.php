<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\Saletype;
use App\Models\CommissionRate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guarded = [];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function saletype()
    {
        return $this->belongsTo(Saletype::class);
    }

    public function commissionRate()
    {
        return $this->belongsTo(CommissionRate::class);
    }
}
