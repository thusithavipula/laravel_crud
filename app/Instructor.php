<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function instructor_subjects() {
        return $this->hasMany('App\InstructorSubject', 'instructor_id', 'id');
    }
    
}
