<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Requests\CreateRequest;
use App\Http\Requests\UpdateRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

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
    public function store(CreateRequest $request){
        $validatedData = $request->validated();

        $product = auth()->user()->products()->create($validatedData);
        return response()->json($product, 201);

    }

    // Show a detais of a particular product
    public function show($id){
        $product = Products::findorFail($id);
        return response()->json($product, 201);
    }

    //  Update a product
    public function update($id, UpdateRequest $request){
        $validatedData = $request->validated() ;

        $product = Products::findorFail($id);
        $product->update($validatedData);
        return response()->json([$product, 'message'=>'Product updated succesfully']);

    }
    //  Delete a product
    public function destroy($id, Request $request){
        $product = Products::findorFail($id);
        // use gate to check if user is authorized to delete a prooduct
        try{
            Gate::authorize('destroy-product', $product);
        } catch(AuthorizationException $e){
            return response()->json([
                'error_message' => $e->getMessage()
            ], 403);
        }
        // if authorization passes, delete the product
        $product->delete($product);
        return response()->json(['message'=>'Product was deleted succesfully']);

    }
}
