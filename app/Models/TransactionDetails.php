<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    protected $guarded = ['id'];


    public function transaction()
    {
        return $this->belongsTo(Transactions::class, 'transaction_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
