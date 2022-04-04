<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model {
    /**
     * Name of the table
     * @var type 
     */
    protected $table = 'documents';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','title_en','archive','status','position','video','type'];
    /**
     * Set title attribute
     * @param type $value
     */
    public function setTitleAttribute($value) {

        $value=strip_tags($value);
        $value=preg_replace('/[^a-zA-Z0-9á-źÁ-Ź[?¿¡!.,\s]/s', '', $value);
        $value=trim($value);
        //Asignamos Valor al atributo  Title
        $this->attributes['title'] = $value;
    }
    /**
     * Set title attribute
     * @param type $value
     */
    public function setTitleEnAttribute($value) {

        $value=strip_tags($value);
        $value=preg_replace('/[^a-zA-Z0-9á-źÁ-Ź[?¿¡!.,\s]/s', '', $value);
        $value=trim($value);
        //Asignamos Valor al atributo  Title
        $this->attributes['title_en'] = $value;
    }


}

