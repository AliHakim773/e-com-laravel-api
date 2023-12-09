<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function add_product(Request $req)
    {
        $req->validate([
            'name' => 'required|string|min:3',
            'description' => 'required|string|max:255',
            'price' => 'required',
            'stock' => 'required',
        ]);

        $product = Product::create([
            'name' => $req->name,
            'description' => $req->description,
            'price' => $req->price,
            'stock' => $req->stock,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Product added successfully',
            'product' => $product,
        ]);
    }

    public function edit_product(Request $req, $id)
    {
        if (!Product::find($id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
                'product_id' => $id,
            ]);
        }

        Product::where('id', $id)->update([
            'name' => $req->name,
            'description' => $req->description,
            'price' => $req->price,
            'stock' => $req->stock,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
        ]);
    }

    public function get_products($id = null)
    {
        if ($id) {
            return response()->json([
                'status' => 'success',
                'message' => 'product by id',
                'products' => Product::find($id),
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'list of all products',
                'products' => Product::get(),
            ]);
        }
    }

    public function delete_product($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
                'product_id' => $id,
            ]);
        }
        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'product deleted',
            'product' => $product,
        ]);
    }
}
