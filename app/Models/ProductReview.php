<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductReview extends Model
{
    protected $table = 'product_review';
    protected $fillable = ['user_id', 'Product_id', 'description', 'rating' ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function rating($id)
    {
        $avg = DB::table('product_review')
                  ->where('Product_id', $id)
                  ->avg('rating');
        return $avg;
    }
}
