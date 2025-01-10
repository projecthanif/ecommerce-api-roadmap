<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Query\ProductQuery;
use Illuminate\Support\Facades\Request;
use League\CommonMark\Normalizer\SlugNormalizer;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $queryParams = Request::query();

        $products = $this->getfilteredProduct($queryParams);

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found'], 404);
        }

        $productCollection = ProductResource::collection($products);

        return successResponse('Products', $productCollection);
    }

    public function getfilteredProduct(array $queryParams)
    {
        if (count($queryParams) === 0) {
            return Product::paginate(10);
        }

        $productQuery = new ProductQuery;
        $filters = $productQuery->filter($queryParams);

        $products = Product::where(function ($query) use ($filters) {
            foreach ($filters as $filter) {
                $query->where(...$filter);
            }
        })->paginate(10);

        return $products;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['slug'] = (new SlugNormalizer)->normalize($data['name']);
        $createdProduct = $product->create($data);

        return successResponse('Product created Successfully', new ProductResource($createdProduct), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::find($id);
            if (! $product) {
                throw new NotFoundResourceException('Product does not exists');
            }
            $retrievedProduct = (new ProductResource($product))->additional([
                'include_description' => true,
            ]);

            return successResponse('Product retrieved Successfully', $retrievedProduct);
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validatedData = $request->validated();

        // return successResponse('Updated Successfully', $validatedData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
