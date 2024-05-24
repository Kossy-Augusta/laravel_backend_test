<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //Lists all the product
    public function index(){
        $products = Products::latest()->paginate(5);

        if($products->isEmpty()) {
            return response()->json(['message' => 'No products listed']);
        }

        return response()->json($products);
    }
    //create a new product
    public function store(Request $request){
        $formFields = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|integer',
            'unit_price' => 'required|decimal:2',
            'amount_sold' => 'required|integer'

        ]);

        $product = auth()->user()->products()->create($formFields);
        return response()->json($product, 201);

    }

    // Show a detais of a particular product
    public function show($id){
        $product = Products::findorFail($id);
        return response()->json($product, 201);
    }

    //  Update a product
    public function update($id, Request $request){
        $product = Products::findorFail($id);

        if($product->user_id !== auth()->id()){
            return response()->json(['error_message'=>'Unauthorized access'], 403);
        }

        $formFields = $request->validate([
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'quantity' => 'sometimes|required|integer',
            'unit_price' => 'sometimes|required|decimal:2',
            'amount_sold' => 'sometimes|required|integer'
        ]);

        $product->update($formFields);
        return response()->json([$product, 'message'=>'Product updated succesfully']);

    }
}
