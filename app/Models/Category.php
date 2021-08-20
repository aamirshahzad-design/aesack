<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'category_name',
        'user_id',
        
    ];


    public function userCat()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }






}
