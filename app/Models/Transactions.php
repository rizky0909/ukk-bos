<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }

    public function detail()
    {
        return $this->hasMany(TransactionDetails::class, 'transaction_id');
    }


}
