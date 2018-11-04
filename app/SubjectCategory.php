<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectCategory extends Model
{
    public function subjects() {
        return $this->hasMany('App\Subject', 'category', 'id')->where('is_active', 1);
    }
}
