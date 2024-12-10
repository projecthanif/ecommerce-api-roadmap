<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Http\Resources\Brand\BrandCollection;
use App\Http\Resources\Brand\BrandResource;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use League\CommonMark\Normalizer\SlugNormalizer;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class BrandController extends Controller
{
    public function index(Brand $brand): JsonResponse|BrandCollection
    {
        return new BrandCollection($brand->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request, Brand $brand): JsonResponse
    {
        $validatedData = $request->validated();

        $validatedData['slug'] = (new SlugNormalizer())->normalize($validatedData['name']);

        $createdData = $brand->create($validatedData);

        return successResponse(
            'Brand created successfully',
            new BrandResource($createdData),
            201
        );

    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug): JsonResponse
    {
        try {
            $brand = Brand::where('slug', $slug)?->get()?->first();
            if (!$brand) {
                throw new NotFoundResourceException('Brand not found');
            }

            $brandsWithProduct = new BrandCollection($brand->with('products')->get());
            return successResponse('Brand retrieved successfully', $brandsWithProduct);

        } catch (NotFoundResourceException $exception) {

            return errorResponse($exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, string $id): JsonResponse
    {
        try {
            $brand = Brand::find($id);
            if (!$brand) {
                throw new NotFoundResourceException('Brand not found');
            }
            $brand->update($request->validated());
            return successResponse('Brand updated successfully', new BrandResource($brand));

        } catch (NotFoundResourceException $exception) {
            return errorResponse($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $brand = Brand::find($id);

            if (!$brand) {
                throw new NotFoundResourceException('Brand not found');
            }
            $brand->delete();

            return successResponse('Brand deleted successfully');

        } catch (NotFoundResourceException $exception) {
            return errorResponse($exception->getMessage());
        }
    }
}
