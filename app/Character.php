<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Encryption\Encrypter;

class Character extends Model
{

    protected $guarded = ['id'];

    #attributes to encrypt
    protected $encrypt = ['firstname','lastname','email','house','aka','actor_firstname','actor_lastname'];
    public $timestamps = true;

    

    public static function initialize() {

    	$characters = [
    		[
    			'firstname'=>'John',
    			'lastname'=>'Snow',
    			'email'=>'jsnow@thewall.com',
    			'house'=>'Stark',
    			'aka'=>'King Crow',
    			'actor_firstname'=>'Kit',
    			'actor_lastname'=>'Harington'
    		],
    		[
    			'firstname'=>'Daenerys',
    			'lastname'=>'Targaryen',
    			'email'=>'khaleesi@motherofdragons.com',
    			'house'=>'Targaryen',
    			'aka'=>'Khaleesi',
    			'actor_firstname'=>'Emilia',
    			'actor_lastname'=>'Clarke'
    		],
    		[
    			'firstname'=>'Arya',
    			'lastname'=>'Stark',
    			'email'=>'arya@winterfell.com',
    			'house'=>'Stark',
    			'actor_firstname'=>'Maisie',
    			'actor_lastname'=>'Williams'
    		],
    		[
    			'firstname'=>'Tyrion',
    			'lastname'=>'Lannister',
    			'email'=>'imp@lannister.com',
    			'house'=>'Lannister',
    			'aka'=>'The Imp',
    			'actor_firstname'=>'Peter',
    			'actor_lastname'=>'Dinklage'
    		],
    		[
    			'firstname'=>'Petyr',
    			'lastname'=>'Baelish',
    			'email'=>'info@kingslandingbrothel.com',
    			'house'=>'Baelish',
    			'aka'=>'Littlefinger',
    			'actor_firstname'=>'Aidan',
    			'actor_lastname'=>'Gillen'
    		]
    	];

    	foreach ($characters as $character) {
    		self::create($character);
    	}
    }

    public function setAttribute($key, $value) {

        # if key is in encrypt array, encrypt the value with the attribute name as a encryption key
        if (in_array($key, $this->encrypt))
        {
            #create 16bit key for AES-256-CBC cipher
        	$pass = \md5($key); 

        	$encrypter = new Encrypter($pass,'AES-256-CBC'); 

            #encrypt value
            $this->attributes[$key] = $encrypter->encrypt($value); 
        }
    }

    protected function decrypt($key,$value) {

        # if key is in encrypt array, decrypt the value
    	if (in_array($key, $this->encrypt) && $value)
        {
            #create 16bit key for AES-256-CBC cipher
        	$pass = \md5($key);

        	$encrypter = new Encrypter($pass,'AES-256-CBC');

            #decrypt value
            $value = $encrypter->decrypt($value);
        }

        return $value;
    }


    /**
     * Overwritten Eloquent functions
     */

    public function getAttributes() {

        $attributes = parent::getAttributes();

        foreach ($attributes as $key => $value) {
            $attributes[$key] = $this->decrypt($key,$value);
        }
        return $attributes;
    }

    protected function getAttributeFromArray($key)
    {
        return $this->decrypt($key, parent::getAttributeFromArray($key));
    }

    protected function getArrayableAttributes()
    {
        $attributes = parent::getArrayableAttributes();

        foreach ($attributes as $key => $value) {
            $attributes[$key] = $this->decrypt($key,$value);
        }

        return $attributes;
    }
    
}
