<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

	protected $guarded = array('id'); //$guardedは、値を用意しておかない項目に指定することで、値がnullであってもエラーにならないようにするために使用する

	public function cart() {

//		return $this->hasMany('App\cart');
	}

}
