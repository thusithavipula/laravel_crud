<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function student_subjects() {
        return $this->hasMany('App\StudentSubject', 'student_id', 'id');
    }
}
