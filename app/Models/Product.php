<?php

namespace App\Models;

use Sqware\Auth\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'name', 'price', 'vendor_id'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }


}
