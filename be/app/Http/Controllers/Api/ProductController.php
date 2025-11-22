<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(5);
        return new ProductResource(true, "List Product", $products);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "type" => "required",
            "specification" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = Product::create([
            "name" => $request->name,
            "type" => $request->type,
            "specification" => $request->specification,
        ]);

        return new ProductResource(true, "Product added", $product);
    }

    public function show($id)
    {
        $product = Product::find($id);
        return new ProductResource(true, "Detail product", $product);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "type" => "required",
            "specification" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = Product::find($id);
        $product->update([
            "name" => $request->name,
            "type" => $request->type,
            "specification" => $request->specification,
        ]);

        return new ProductResource(true, "Product changed", $product);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return new ProductResource(true, "Product deleted", null);
    }
}
