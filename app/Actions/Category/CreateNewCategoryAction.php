<?php

namespace App\Actions\Category;

use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use League\CommonMark\Normalizer\SlugNormalizer;
use Symfony\Component\HttpFoundation\Response;

class CreateNewCategoryAction
{
    public function __construct(
        public Category $category,
        public SlugNormalizer $slugNormalizer
    ) {
        //
    }

    public function handle(array $validatedData)
    {

        $validatedData['slug'] = $this->slugNormalizer->normalize($validatedData['name']);

        $createdData = $this->category->create($validatedData);

        $resourceData = new CategoryResource($createdData);

        /**
         * @var Response::HTTP_CREATED => 201
         */
        return successResponse(
            message: 'Category created successfully',
            data: $resourceData,
            statusCode: Response::HTTP_CREATED
        );
    }
}
