<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::orderBy('name', 'asc')->get();
        if ($category->isEmpty())
        {
            return response()->json([
                'message' => 'Category is Empty'
            ]);
        }
        return response()->json([$category], 200);
    }
    public function store(CreateCategoryRequest $request)
    {
        $validatedData = $request->validated();

        $category = Category::create($validatedData);
        return response()->json($category, 201);
    }
}
