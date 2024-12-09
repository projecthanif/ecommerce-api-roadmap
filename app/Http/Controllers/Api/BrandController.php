<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Http\Resources\Brand\BrandCollection;
use App\Http\Resources\Brand\BrandResource;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    public function index(Brand $brand): JsonResponse|BrandCollection
    {
        if ($brand->count() === 0) {
            return successResponse('Brand is empty', data: null);
        }

        return new BrandCollection($brand->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request, Brand $brand): JsonResponse
    {
        $validatedData = $request->validated();

        $exist = $brand->where([
            'name' => $validatedData['name']
        ])->exists();

        if ($exist) {
            return successResponse('Brand already exist', data: null);
        }

        $createdData = $brand->create($validatedData);

        return successResponse('Brand created successfully', new BrandResource($createdData), 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand): JsonResponse
    {
        return successResponse('Brand retrieved successfully', new BrandResource($brand));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $brand->update($request->validated());
        return successResponse('Brand updated successfully', new BrandResource($brand));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
