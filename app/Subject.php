<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function category() {
        return $this->hasOne('App\SubjectCategory', 'id', 'category');
    }

}
