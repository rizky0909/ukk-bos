<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\select;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::all();
        return view('products.index', compact('products'));
    }


    public function detailPembelian(int $id){
       $data = Transactions::where('id',$id)->with('detail.product')->first();
    //    dd($data);
    //    $data['produk_name'] = Products::where('id',$data->detail->first()->id)->select('name')->get();
    //    dd($data);
return view('purchases.detailpembelian',compact('data'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_produk' => 'required|string',
                'gambar' => 'required|image|mimes:png,jpg,jpeg|max:2048',
                'harga' => 'required|string',
                'stok' => 'required|integer',
            ]);

            // dd($request);
            if ($request->hasFile('gambar')) {
                $image = $request->file('gambar');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $imageName);
            }
            $harga = (int) str_replace(['Rp', '.', ','], '', $request->harga);
            // $gambar = $request->file('gambar')->store('images', 'public');

            Products::create([
                'nama_produk' => $request->nama_produk,
                'gambar' => $imageName,
                'harga' => $harga,
                'stok' => $request->stok,
            ]);

            return redirect()->route('products')->with('success', 'Berhasil Menambah Barang');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function updateStock(Request $request, $id)
    {
        try {
            $product = Products::findOrFail($id);
            $request->validate([
                'stok' => 'required|integer',
            ]);

            $product->stok = $request->stok;
            $product->save();
            return redirect()->route('products')->with('success', 'Berhasil Mengupdate Stok');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Products::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $product = Products::findOrFail($id);
            $request->validate([
                'nama_produk' => 'required|string',
                'harga' => 'required|string',
            ]);

            $harga = (int) str_replace(['Rp', '.', ','], '', $request->harga);
            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar')->store('images', 'public');
                $product->gambar = $gambar;
            }

            $product->harga = $harga;
            $product->nama_produk = $request->nama_produk;
            $product->save();
            return redirect()->route('products')->with('success', 'Berhasil Mengupdate Barang');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Products::findOrFail($id);

            if ($product->gambar) {
                Storage::delete(['images/' . $product->gambar]);
            }
            $product->delete();

            return redirect()->route('products')->with('success', 'Berhasil Menghapus Barang');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
