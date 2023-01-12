<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $primaryKey = 'employee_id';
    protected $dates = ['created_at', 'dob','updated_at', 'hire_date'];
    protected $fillable = ['first_name','last_name','email',
    'phone_number','hire_date','job_id','department_id','salary','manager_id','photo'];
   
    public function department() {
        return $this->belongsTo('App\Models\Department','employee_id');
    }
    public function job() {
        return $this->belongsTo('App\Models\Job','employee_id');
    }
}
