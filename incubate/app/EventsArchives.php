<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventsArchives extends Model {
    /**
     * Name of the table
     * @var type 
     */
    protected $table = 'events_archives';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','name_en','archive','file_size','event'];
    /**
     * Set name attribute
     * @param type $value
     */
    public function setNameAttribute($value) {

        $value=strip_tags($value);
        $value=preg_replace('/[^a-zA-Z0-9á-źÁ-Ź[.,[\/]\s]/s', '', $value);
        $value=trim($value);
        //Asignamos Valor al atributo  name
        $this->attributes['name'] = $value;
    }
    /**
     * Set name_en attribute
     * @param type $value
     */
    public function setNameEnAttribute($value) {

        $value=strip_tags($value);
        $value=preg_replace('/[^a-zA-Z0-9á-źÁ-Ź[.,[\/]\s]/s', '', $value);
        $value=trim($value);
        //Asignamos Valor al atributo  name
        $this->attributes['name_en'] = $value;
    }
    

}

