<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $guarded = ['id'];

    public function transaction()
    {
        return $this->hasOne(Transactions::class);
    }
}
