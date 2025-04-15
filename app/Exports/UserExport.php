<?php

namespace App\Exports;

use App\Models\Transactions;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class   UserExport implements FromArray, WithHeadings
{
   public function array() : array {
        $data = [];

        $transactions = Transactions::with('detail.product', 'customer', 'user')->get();

        foreach ($transactions as $transaction) {
            foreach ($transaction->detail[0]['product'] as $value) { $aep = $value['nama_produk'];}
            $data[] = [
                'nama' => $transaction->customer->name ?? 'NON-MEMBER',
                'tanggal' => $transaction->created_at->format('d F Y'),
                'total' => 'Rp .' . number_format($transaction->total_price),
                'produk' =>  $aep[0] ,
                'qty' => $transaction->detail[0]['quantity'],
                'dibuat' => $transaction->user->name,
            ];
        }

        return $data;
   }

   public function headings() : array {
        return  [
            'nama',
            'tanggal',
            'produk',
            'qty',
            'total',
            'dibuat'
        ];
   }
}
