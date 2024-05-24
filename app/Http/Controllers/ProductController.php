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
}
