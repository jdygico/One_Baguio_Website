<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consult extends Model
{
    use HasFactory;

    protected $fillable = [
        'nature','purpose','consult_datetime','age','mode_of_transaction','height','weight',
        'BMI','bmi_category','complaint','name_of_attending_provider','patient_consent', 'book_id'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
