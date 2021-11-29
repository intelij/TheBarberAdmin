<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'module';
    public $primaryKey = 'id';
    public $timestamps = true;
}
