<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET /products
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // GET /products/create
    public function create()
    {
        return view('products.create');
    }

    // POST /products
    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());

        return redirect()->route('products.index')
                         ->with('success', 'Product created successfully.');
    }
    

    // GET /products/{product}
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // GET /products/{product}/edit
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // PUT/PATCH /products/{product}
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()->route('products.index')
                         ->with('success', 'Product updated successfully.');
    }

    // DELETE /products/{product}
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'Product deleted successfully.');
    }

    public function apiIndex()
    {
        $products = \App\Models\Product::select('id', 'name', 'sku', 'price', 'quantity')->get();
        return response()->json(['data' => $products]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $products = Product::where('name', 'like', "%{$query}%")
                    ->orderBy('name')
                    ->limit(10)
                    ->get(['id', 'name', 'quantity']); // Only necessary fields

        return response()->json($products);
    }

}

