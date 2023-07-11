<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $transactions = Transaction::query();
        $limit = $request->input('limit', 10);

        $sortby = $request->input('sortby', 'created_at');

        $orderby = $request->input('orderby', 'asc');

        $transactions->orderBy($sortby, $orderby);
        $transactions->with('user');
        if ($user->role == 2) {
            $transactions->where('user_id', $user->uuid);
        }

        $transactions = $transactions->paginate($limit);

        return TransactionResource::collection($transactions);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request)
    {
        $product = Product::where('uuid', $request->product_id)->first();

        if (!$product) {
            return response(['message' => "Produk tidak ditemukan.", "success" => false], 400);
        }

        if ($product->quantity < $request->quantity) {
            return response(['message' => "Stok barang tidak mencukupi.", "success" => false], 400);
        }

        $tax = $product->price * 0.1;
        $adminFee = $product->price * 0.05 + $tax;
        $total = ($product->price + $adminFee) * $request->quantity;

        $transaction = Transaction::create([
            'product_id' => $product->uuid,
            'user_id' => auth()->id(),
            'price' => $product->price,
            'quantity' => $request->quantity,
            'admin_fee' => $adminFee,
            'tax' => $tax,
            'total' => $total,
        ]);

        $product->quantity -= $request->quantity;
        $product->save();

        return $transaction;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = request()->user();
        $transaction = Transaction::findOrFail($id);

        if ($user->role == 1 || ($user->role == 2 && $transaction->user_id == $user->uuid)) {
            return new TransactionResource($transaction);
        } else {
            abort(403, 'Unauthorized');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
