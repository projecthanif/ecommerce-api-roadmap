<?php

namespace App\Actions\Category;

use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use League\CommonMark\Normalizer\SlugNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

class CreateNewCategoryAction
{
    public function __construct(
        public Category $category,
        public SlugNormalizer $slugNormalizer
    ) {
    }

    public function handle(array $validatedData): JsonResponse
    {

        $validatedData['slug'] = $this->slugNormalizer->normalize($validatedData['name']);

        $createdData = $this->category->create($validatedData);

        $resourceData = new CategoryResource($createdData);

        return successResponse(
            message: 'Category created successfully',
            data: $resourceData,
            statusCode: Response::HTTP_CREATED
        );
    }
}
