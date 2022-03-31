<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presentations extends Model

{
   /**
     * Name of the table
     * @var type 
     */
	protected $table = 'presentations';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable =['name','last_name','dni','phone','email','person','project_name','website','category','members','dedicated','state','video','documents','interest','description'];

	

}

