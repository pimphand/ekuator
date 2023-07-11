<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query();

        $limit = $request->input('limit', 10);

        $sortby = $request->input('sortby', 'name');

        $orderby = $request->input('orderby', 'asc');

        $products->orderBy($sortby, $orderby);

        $products = $products->paginate($limit);

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        Product::create($request->validated());

        return response(['message' => 'Produk Berhasil di simpan', 'success' => false], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductStoreRequest $request, string $id)
    {
        Product::findOrFail($id)->update($request->validated());

        return response(['message' => 'Produk Berhasil di ubah', 'success' => false], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);

        return response(['message' => 'Produk Berhasil di hapus', 'success' => false], 200);
    }
}
