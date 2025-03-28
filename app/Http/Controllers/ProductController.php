<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::with('images')->get(), 200);
    }

    public function store(Request $request)
    {

        
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $product = Product::create($request->only(['name', 'price']));

        if ($request->hasFile('images')) {
            foreach($request->file('images') as $image) { 
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
            
        }

        return response()->json(['message' => 'Product created successfully', 'product' => $product->load('images')], 201);
    }

    public function show($id)
    {
        return response()->json(Product::with('images')->findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->only(['name', 'price']));
        return response()->json(['message' => 'Product updated successfully', 'product' => $product], 200);
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }

}
