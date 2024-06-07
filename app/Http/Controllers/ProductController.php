<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Requests\CreateRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Category;
use Hamcrest\Arrays\IsArray;
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
        $requestData = $request->only([
                        'name',
                        'description',
                        'quantity',
                        'unit_price',
                        'amount_sold',
                        ]);

        $product = auth()->user()->products()->create($requestData);
        /**
         * Check if incomming request contains category name 
         * and then associate the product with the category
         */
        if ($request->has('category_name')) 
        {
            $categoryNames = $request->category_name; 
            // make sure the categoryNames is an array
            if (!is_array($categoryNames))
            {
                $categoryNames = [$categoryNames];
            }
            //  retrieve the category Ids based on the category name
            $categories = Category::whereIn('name', $categoryNames)->pluck('id')->toArray();
            /**
             * Check if one or more categories returned by the request
             * do not exist in the category id returned from the DB
             */
            if (count($categoryNames) !== count($categories))
            {
                return response()->json(['error' => 'One or more categories do not exist'], 422);
            }
        
            $product->categories()->sync($categories);
        }

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
        /**
         * Check if incomming request contains category name 
         * and then associate the product with the category
         */
        if ($request->has('category_name')) 
        {
            $categoryNames = $request->category_name; 
            // make sure the categoryNames is an array
            if (!is_array($categoryNames))
            {
                $categoryNames = [$categoryNames];
            }
            //  retrieve the category Ids based on the category name
            $categories = Category::whereIn('name', $categoryNames)->pluck('id')->toArray();
            /**
             * Check if one or more categories returned by the request
             * do not exist in the category id returned from the DB
             */
            if (count($categoryNames) !== count($categories))
            {
                return response()->json(['error' => 'One or more categories do not exist'], 422);
            }
        
            $product->categories()->sync($categories);
        }
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
