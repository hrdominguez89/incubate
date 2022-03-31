<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mentors extends Model {
    /**
     * Name of the table
     * @var type 
     */
    protected $table = 'mentors';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','content','content_en','image','categories','status','position','facebook','linkedin','instagram'];
    

}

