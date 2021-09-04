<?php

namespace App\Http\Controllers;

use App\Helpers\EloquentHelper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response as BaseResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Illuminate\Support\Facades\Validator;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $data
     * @param int $code
     * @return JsonResponse
     */
    public function respondWithSuccess($data, int $code = Response::HTTP_OK): JsonResponse
    {
        return ResponseFacade::json([
            'success' => true,
            'data'    => $data,
        ], $code);
    }

    /**
     * @param string $error
     * @param int $code
     * @return JsonResponse
     */
    public function respondWithError(string $error, int $code = Response::HTTP_NOT_FOUND): JsonResponse
    {
        return ResponseFacade::json([
            'success' => false,
            'error' => $error,
        ], $code, ['Content-Type' => 'application/problem+json']);
    }

    /**
     * @param Request $request
     * @return array
     */
    #[ArrayShape(['offset' => "int", 'limit' => "int", 'filter_params' => "array", 'sort_params' => "array"])]
    public function aggregateRequestParams(Request $request): array
    {
        $offset = (int)$request->get('page', 1);
        $limit = (int)$request->get('limit');
        $filterParams = $request->get('filter', []);
        $sortParams = $request->get('sort', []);
        $search = $request->get('search', '');
        $filterParams['search'] = $search;

        return [
            'offset' => $offset,
            'limit' => $limit,
            'filter_params' => $filterParams,
            'sort_params' => $sortParams,
        ];
    }

    public function prepareResource(
        Collection $collection,
        Mediator $mediator
    ): array
    {
        $output = $mediator->fractalManager->collection($collection, $mediator->transformer);

        return [
            'items' => $output,
        ];
    }

    /**
     * @param LengthAwarePaginator $paginator
     * @param Mediator $mediator
     * @return array
     */
    #[ArrayShape(['items' => "array", 'meta' => "array"])]
    public function preparePaginatedResource(
        LengthAwarePaginator $paginator,
        Mediator $mediator
    ): array
    {
        $entityCollection = $paginator->getCollection();

        $meta = EloquentHelper::extractPaginatorMeta($paginator);

        $output = $mediator->fractalManager->collection($entityCollection, $mediator->transformer);

        return [
            'items' => $output,
            'meta' => $meta
        ];
    }

    /**
     * @param array $data
     * @param array $rules
     * @return JsonResponse|null
     */
    public function validateRequest(array $data, array $rules): ?JsonResponse
    {
        $validator = Validator::make($data, $rules);

        if($validator->fails()) {
            return ResponseFacade::json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422, ['Content-Type' => 'application/problem+json']);
        } else {
            return null;
        }
    }
}
