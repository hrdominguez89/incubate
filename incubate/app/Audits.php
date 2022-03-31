<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audits extends Model
{
	protected $table = 'audits';

	protected $fillable =['id_user','activity','ip'];
}
