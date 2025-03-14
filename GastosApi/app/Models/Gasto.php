<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gasto extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'description', 'amount', 'category'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}