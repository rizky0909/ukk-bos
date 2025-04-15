<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\Customers;
use App\Models\Products;
use App\Models\TransactionDetails;
use App\Models\Transactions;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('pagi', 5);

        $transactions = Transactions::with('detail.product', 'user')->when($search, function ($query, $search) {
            return $query->whereHas('customer', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('total_price', 'like', "%{$search}%");
        })->paginate($perPage);

        return view('purchases.index', compact('transactions'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Products::all();
        return view('purchases.create', compact('products'));
    }

    public function cart(Request $request)
    {
        $cart = [];

        foreach ($request->input('jumlah') as $id => $qty) {
            if ($qty > 0) {
                $harga = $request->input("harga.$id");
                $cart[$id] = [
                    'id' => $id,
                    'nama_produk' => $request->input("nama_produk.$id"),
                    'harga' => $harga,
                    'jumlah' => $qty,
                    'subtotal' => $harga * $qty,
                ];
            }
        }

        session(['cart' => $cart]);

        return redirect()->route('checkout');
    }

    public function checkout()
    {
        $cart = session('cart');
        return view('purchases.checkout', compact('cart'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            if (!$request->no_hp || !$request->member) {
                $request->validate([
                    'total_payment_clean' => 'required|integer',
                    'total_price' => 'required|integer',
                ]);
                $return = $request->total_payment_clean - $request->total_price;

                $transaction = Transactions::create([
                    'user_id' => Auth::user()->id,
                    'total_return' => $return,
                    'total_payment' => $request->total_payment_clean,
                    'total_price' => $request->total_price,
                    'point' => '0'
                ]);

                $cart = session('cart');

                foreach ($cart as $item) {
                    TransactionDetails::create([
                        'product_id' => $item['id'],
                        'transaction_id' => $transaction->id,
                        'quantity' => $item['jumlah'],
                        'sub_total' => $item['subtotal']
                    ]);

                    $product = Products::find($item['id']);

                    if ($product) {
                        $product->stok -= $item['jumlah'];
                    }
                }

                session()->forget('cart');
                return redirect()->route('invoice', ['id' => $transaction->id]);
            } else {
                $request->validate([
                    'total_payment_clean' => 'required|integer',
                    'total_price' => 'required|integer',
                    'no_hp' => 'required|string'
                ]);

                $return = $request->total_payment_clean - $request->total_price;
                $point = floor($request->total_price / 1000);


                $customer = Customers::where('no_hp', $request->no_hp)->first();

                if (!$customer) {
                    $customer = Customers::create([
                        'no_hp' => $request->no_hp,
                        'total_point' => $point
                    ]);
                } else {
                    $customer->total_point += $point;
                    $customer->save();
                }

                $transaction = Transactions::create([
                    'customer_id' => $customer->id,
                    'user_id' => Auth::user()->id,
                    'total_return' => $return,
                    'total_payment' => $request->total_payment_clean,
                    'total_price' => $request->total_price,
                    'point' => $point,
                ]);

                $cart = session('cart');

                foreach ($cart as $item) {
                    TransactionDetails::create([
                        'product_id' => $item['id'],
                        'transaction_id' => $transaction->id,
                        'quantity' => $item['jumlah'],
                        'sub_total' => $item['subtotal']
                    ]);

                    $product = Products::find($item['id']);

                    if ($product) {
                        $product->stok -= $item['jumlah'];
                        $product->save();
                    }
                }

                return redirect()->route('member', ['id' => $transaction->id]);
            }
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function member($id)
    {
        $cart = session('cart');
        $transaction = Transactions::with('detail.product')->findOrFail($id);
        return view('purchases.member', compact('cart', 'transaction'));
    }

    public function downloadPDF($id)
    {
        $transaction = Transactions::with('detail.product')->findOrFail($id);
        $pdf = Pdf::loadView('export.transaction_pdf', compact('transaction'));
        return $pdf->download('invoice.pdf');
    }

    public function downloadExcel()
    {
        return Excel::download(new UserExport, 'Transaksi.xlsx');
    }

    public function updateMember(Request $request)
    {
        // dd($request->all());
        try {
            $transaction = Transactions::findOrFail($request->transaction_id);
            if ($request->use_point) {
                $currentPoint = $transaction->customer->total_point - $request->total_point;
                $transaction->customer->total_point = $currentPoint;
                $transaction->used_point = $request->total_point;
            }

            if (!$transaction->customer->name) {
                $transaction->customer->name = $request->nama;
            }

            $transaction->customer->save();
            $transaction->save();

            return redirect()->route('invoice', ['id' => $transaction->id]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function invoice($id)
    {
        $transaction = Transactions::with('detail.product')->findOrFail($id);
        return view('purchases.invoice', compact('transaction'));
    }
    /**
     * Display the specified resource.
     */
    public function show(Transactions $transactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transactions $transactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transactions $transactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transactions $transactions)
    {
        //
    }
}
