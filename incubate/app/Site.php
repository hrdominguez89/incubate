<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
	protected $table = 'site';

	protected $fillable =['twitter','youtube','facebook','instagram','email','phone_ciudadano','phone_social','phone_same','phone_emergencia','api_key','list_mailchimp','image','image_1','image_2','image_3','name','description','keywords','description_en','keywords_en'];

	/**
     * Set name attribute
     * @param type $value
     */
    public function setNameAttribute($value) {

        $value=strip_tags($value);
        $value=preg_replace('/[^a-zA-Z0-9á-źÁ-Ź[\s]/s', '', $value);
        $value=trim($value);
        $this->attributes['name'] = $value;
    }

    /**
     * Set email attribute
     * @param type $value
     */
    public function setEmailAttribute($value) {

        $value=strip_tags($value);
        $value=preg_replace('/[^a-zA-Z0-9á-źÁ-Ź[?¿¡!.,@\s]/s', '', $value);
        $value=trim($value);
        $this->attributes['email'] = $value;
    }

    /**
     * Set phone_ciudadano attribute
     * @param type $value
     */
    public function setPhoneCiudadanoAttribute($value) {

        $value=strip_tags($value);
        $value=preg_replace('/[^0-9[.+-_\s]/s', '', $value);
        $value=trim($value);
        $this->attributes['phone_ciudadano'] = $value;
    }

     /**
     * Set phone_social attribute
     * @param type $value
     */
    public function setPhoneSocialAttribute($value) {

        $value=strip_tags($value);
        $value=preg_replace('/[^0-9[.+-_\s]/s', '', $value);
        $value=trim($value);
        $this->attributes['phone_social'] = $value;
    }

    /**
     * Set phone_same attribute
     * @param type $value
     */
    public function setPhoneSameAttribute($value) {

        $value=strip_tags($value);
        $value=preg_replace('/[^0-9[.+-_\s]/s', '', $value);
        $value=trim($value);
        $this->attributes['phone_same'] = $value;
    }

    /**
     * Set phone_emergencia attribute
     * @param type $value
     */
    public function setPhoneEmergenciaAttribute($value) {

        $value=strip_tags($value);
        $value=preg_replace('/[^0-9[.+-_\s]/s', '', $value);
        $value=trim($value);
        $this->attributes['phone_emergencia'] = $value;
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

}
