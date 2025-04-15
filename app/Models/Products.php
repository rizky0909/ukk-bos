<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $guarded = ['id'];

    public function detail()
    {
        return $this->hasMany(TransactionDetails::class);
    }

}
