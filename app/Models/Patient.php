<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'prefix','last_name','first_name','middle_name','suffix','sex','birth_date','birth_place','civil_status','maiden_last_name',
        'maiden_middle_name','educational_attainment','employment_status','occupation','monthly_income','nationality','tax_identification',
        'religion','ethnic_group','indigenous','number_street_name','barangay','blood_type','mobile','landline','email',
        "mother_last_name","mother_first_name","mother_middle_name","mother_birth_date","dsdw_member","facility_household_no","household_no",
        "pantawid_member","pantawid_member_no","family_serial_no","philhealth_member","philhealth_status","philhealth_no","philhealth_category", "pcb_member"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
