<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //
	protected $table='news';
	protected $fillable=[
		'user_id',
		'title',
		'photo',
		'description',
		'content',
	]; 


 public function addby()
 {
 	return $this->hasOne('App\User','id','user_id');

 }
 public function files()
 {
 	return $this->hasMany('App\File','news_id','id');

 }
}