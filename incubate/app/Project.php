<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {
    /**
     * Name of the table
     * @var type 
     */
    protected $table = 'projects';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','url','content','title_en','url_en','content_en','resume','resume_en','image','video','categories','status','position','facebook','linkedin','instagram','twitter','mentor','website','youtube','flickr','email'];
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
     * Set title_en attribute
     * @param type $value
     */
    public function setTitleEnAttribute($value) {

        $value=strip_tags($value);
        $value=preg_replace('/[^a-zA-Z0-9á-źÁ-Ź[?¿¡!.,\s]/s', '', $value);
        $value=trim($value);
        //Asignamos Valor al atributo  Title
        $this->attributes['title_en'] = $value;
    }
    /**
     * Set resume attribute
     * @param type $value
     */
    public function setResumeAttribute($value) {

        $value=strip_tags($value);
        $value=preg_replace('/[^a-zA-Z0-9á-źÁ-Ź[?¿¡!.,\s]/s', '', $value);
        $value=trim($value);
        //Asignamos Valor al atributo  Title
        $this->attributes['resume'] = $value;
    }
    /**
     * Set resume attribute
     * @param type $value
     */
    public function setResumeEnAttribute($value) {

        $value=strip_tags($value);
        $value=preg_replace('/[^a-zA-Z0-9á-źÁ-Ź[?¿¡!.,\s]/s', '', $value);
        $value=trim($value);
        //Asignamos Valor al atributo  resume
        $this->attributes['resume_en'] = $value;
    }
    /**
     * Set url attribute
     * @param type $value
     */
    public function setUrlAttribute($value) {

        $value = strtolower($value);
        $value=mb_strtolower($value,'UTF-8');
        $value=trim($value);
        $value=preg_replace('/[^a-zA-Z0-9á-źÁ-Ź[\s]/s', '', $value);
        //Rememplazamos caracteres especiales latinos
        $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
        $repl = array('a', 'e', 'i', 'o', 'u', 'n');
        $value = str_replace($find, $repl, $value);
        // Añadimos los guiones
        $find = array(' ', '&', '\r\n', '\n', '+');
        $value = str_replace($find, '-', $value);
        // Eliminamos y Reemplazamos otros carácteres especiales
        $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
        $repl = array('', '-', '');
        $value = preg_replace($find, $repl, $value);
        //Asignamos Valor al atributo  URL
        $this->attributes['url'] = $value;
    }

    /**
     * Set url en attribute
     * @param type $value
     */
    public function setUrlEnAttribute($value) {

        $value = strtolower($value);
        $value=mb_strtolower($value,'UTF-8');
        $value=trim($value);
        $value=preg_replace('/[^a-zA-Z0-9á-źÁ-Ź[\s]/s', '', $value);
        //Rememplazamos caracteres especiales latinos
        $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
        $repl = array('a', 'e', 'i', 'o', 'u', 'n');
        $value = str_replace($find, $repl, $value);
        // Añadimos los guiones
        $find = array(' ', '&', '\r\n', '\n', '+');
        $value = str_replace($find, '-', $value);
        // Eliminamos y Reemplazamos otros carácteres especiales
        $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
        $repl = array('', '-', '');
        $value = preg_replace($find, $repl, $value);
        //Asignamos Valor al atributo  URL
        $this->attributes['url_en'] = $value;
    }

    /**
     * Set facebook attribute
     * @param type $value
     */
    public function setFacebookAttribute($value) {

        $value = strtolower($value);
        $value=mb_strtolower($value,'UTF-8');
        $value=preg_replace('/[^a-zA-Z0-9[#&=[\/]-_.:\s]/s', '', $value);
        $value = str_replace('https://', 'http://', $value);
        $value = str_replace('www.', 'http://', $value);
        $value = str_replace('http://http://', 'http://', $value);
        $value=trim($value);
        $this->attributes['facebook'] = $value;
    }
/**
     * Set instragram attribute
     * @param type $value
     */
    public function setInstagramAttribute($value) {

        $value = strtolower($value);
        $value=mb_strtolower($value,'UTF-8');
        $value=preg_replace('/[^a-zA-Z0-9[#&=[\/]-_.:\s]/s', '', $value);
        $value = str_replace('https://', 'http://', $value);
        $value = str_replace('www.', 'http://', $value);
        $value = str_replace('http://http://', 'http://', $value);
        $value=trim($value);
        $this->attributes['instagram'] = $value;
    }
    /**
     * Set twitter attribute
     * @param type $value
     */
    public function setTwitterAttribute($value) {

        $value = strtolower($value);
        $value=mb_strtolower($value,'UTF-8');
        $value=preg_replace('/[^a-zA-Z0-9[#&=[\/]-_.:\s]/s', '', $value);
        $value = str_replace('https://', 'http://', $value);
        $value = str_replace('www.', 'http://', $value);
        $value = str_replace('http://http://', 'http://', $value);
        $value=trim($value);
        $this->attributes['twitter'] = $value;
    }
    /**
     * Set youtube attribute
     * @param type $value
     */
    public function setYoutubeAttribute($value) {

        $value = strtolower($value);
        $value=mb_strtolower($value,'UTF-8');
        $value=preg_replace('/[^a-zA-Z0-9[#&=[\/]-_.:\s]/s', '', $value);
        $value = str_replace('https://', 'http://', $value);
        $value = str_replace('www.', 'http://', $value);
        $value = str_replace('http://http://', 'http://', $value);
        $value=trim($value);
        $this->attributes['youtube'] = $value;
    }

    /**
     * Set linkedin attribute
     * @param type $value
     */
    public function setLinkedinAttribute($value) {

        $value = strtolower($value);
        $value=mb_strtolower($value,'UTF-8');
        $value=preg_replace('/[^a-zA-Z0-9[#&=[\/]-_.:\s]/s', '', $value);
        $value = str_replace('https://', 'http://', $value);
        $value = str_replace('www.', 'http://', $value);
        $value = str_replace('http://http://', 'http://', $value);
        $value=trim($value);
        $this->attributes['linkedin'] = $value;
    }

    /**
     * Set website attribute
     * @param type $value
     */
    public function setWebSiteAttribute($value) {

        $value = strtolower($value);
        $value=mb_strtolower($value,'UTF-8');
        $value=preg_replace('/[^a-zA-Z0-9[#&=[\/]-_.:\s]/s', '', $value);
        $value = str_replace('https://', 'http://', $value);
        $value = str_replace('www.', 'http://', $value);
        $value = str_replace('http://http://', 'http://', $value);
        $value=trim($value);
        $this->attributes['website'] = $value;
    }

}

