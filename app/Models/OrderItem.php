<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
	protected $filliable =[
	'order_id','product_id','quantity','price'
	];

	public function product()
	{
		return $this->belongsTo('App\Models\Product','product_id');
	}	
}