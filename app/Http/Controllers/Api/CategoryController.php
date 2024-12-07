<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use League\CommonMark\Normalizer\SlugNormalizer;

class CategoryController extends Controller
{
    public function __construct(
        public Category $category,
        public SlugNormalizer $slugNormalizer
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): CategoryCollection
    {
        return new CategoryCollection($this->category->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $check = $this->category->where('name', $request->get('name'))->get()?->first();

        if ($check) {
            return response()->json([
                'message' => 'This category already exists',
            ]);
        }
        $validatedData['slug'] = $this->slugNormalizer->normalize($validatedData['name']);

        $createdData = $this->category->create($validatedData);

        $resourceData = new CategoryResource($createdData);

        return successResponse(message: 'Category created successfully', data: $resourceData, statusCode: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): JsonResponse
    {
        return successResponse(message: 'Category retrieved successfully', data: new CategoryResource($category));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $validatedData = $request->validated();
        $category->update($validatedData);

        return successResponse(
            'Category updated Successfully',
            data: new CategoryResource($category),
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
