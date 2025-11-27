<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // These are the columns we are allowed to write data to
    protected $fillable = [
        'user_id',
        'item_key',
        'item_name',
        'price'
    ];

    // Optional: Helper to link back to the user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}