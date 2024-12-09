<?php

namespace App\Http\Controllers\Api;

use App\Actions\Category\CreateNewCategoryAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use SebastianBergmann\CodeCoverage\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class CategoryController extends Controller
{
    public function __construct(
        public Category $category,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): CategoryCollection
    {
        return new CategoryCollection($this->category->paginate(10));
    }

    public function store(StoreCategoryRequest $request, CreateNewCategoryAction $action): JsonResponse
    {
        $validatedData = $request->validated();

        return $action->handle($validatedData);
    }

    public function show(string $id): JsonResponse
    {

        $category = Category::find($id);
        try {

            if (! $category) {
                throw new NotFoundResourceException('Category not found');
            }

            $allCategory = new CategoryCollection($category->with('products')->get());

            return successResponse(
                message: 'Category retrieved successfully',
                data: $allCategory
            );
        } catch (NotFoundResourceException $e) {

            return errorResponse(
                message: $e->getMessage(),
                statusCode: Response::HTTP_NOT_FOUND
            );
        }
    }

    public function update(UpdateCategoryRequest $request, string $id): JsonResponse
    {
        try {
            $category = Category::find($id);

            if (! $category) {
                throw new NotFoundResourceException('Category does not exists');
            }
            $validatedData = $request->validated();
            $category->update($validatedData);

            return successResponse(
                'Category updated Successfully',
                data: new CategoryResource($category),
            );
        } catch (NotFoundResourceException $exception) {
            return errorResponse($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \Exception
     */
    public function destroy(string $id): JsonResponse
    {
        try {

            $category = Category::find($id);

            if (! $category) {
                throw new NotFoundResourceException('Category does not exists');
            }

            if ($category->delete()) {
                return successResponse('Category deleted successfully');
            }

            throw new \Exception('Category Failed to delete');
        } catch (Exception $exception) {
            return errorResponse($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
