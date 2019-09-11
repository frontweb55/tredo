<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }
}
