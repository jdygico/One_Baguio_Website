<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'where','book_date','purpose','status'
    ];

    public function patients()
    {
        return $this->belongsTo(Patient::class, 'user_id');
    }

    public function consult()
    {
        return $this->hasOne(Consult::class);
    }
    
}
