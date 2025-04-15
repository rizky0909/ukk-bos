<?php

namespace App\Exports;

use App\Models\Transactions;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromArray, WithHeadings
{
   public function array() : array {
        $data = [];

        $transactions = Transactions::with('detail.product', 'customer', 'user')->get();

        foreach ($transactions as $transaction) {
            $data[] = [
                'nama' => $transaction->customer->name ?? 'NON-MEMBER',
                'tanggal' => $transaction->created_at->format('d F Y'),
                'total' => 'Rp .' . number_format($transaction->total_price),
                'dibuat' => $transaction->user->name,
            ];
        }

        return $data;
   }

   public function headings() : array {
        return  [
            'nama',
            'tanggal',
            'total',
            'dibuat'
        ];
   }
}
