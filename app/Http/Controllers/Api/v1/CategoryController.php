<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index()
    {
        //
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::query()->create($request->validated());

        return response()->json([
            'message' => 'Category created successfully',
            new CategoryResource($category),
        ], Response::HTTP_CREATED);
    }

    public function show(Category $category)
    {
        //
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    public function destroy(Category $category)
    {
        //
    }
}
