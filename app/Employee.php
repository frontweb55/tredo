<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = ['id'];

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }
}
