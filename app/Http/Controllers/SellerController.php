<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Contracts\SellerContract;
use App\Http\Requests\SellerRequest;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerController extends Controller
{
    public function __construct(private SellerContract $seller_service)
    {
    }

    public function index(): JsonResponse
    {
        $sellers = $this->seller_service->list();

        return ApiResponse::jsonSuccess(new JsonResource($sellers), Response::HTTP_OK, 'Sellers listed successfully!');
    }

    public function store(SellerRequest $request): JsonResponse
    {
        $data   = $request->validated();
        $seller = $this->seller_service->create($data['name'], $data['email']); // @phpstan-ignore-line

        return ApiResponse::jsonSuccess(new JsonResource($seller), Response::HTTP_CREATED, 'Seller created successfully!');
    }

    public function show(int $id): JsonResponse
    {
        $seller = $this->seller_service->get($id);

        return ApiResponse::jsonSuccess(new JsonResource($seller), Response::HTTP_OK, 'Seller obtained successfuly!');
    }

    public function update(SellerRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $this->seller_service->update($id, $data['name'], $data['email']); // @phpstan-ignore-line

        return ApiResponse::jsonSuccess(new JsonResource([]), Response::HTTP_OK, 'Seller updated successfully!');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->seller_service->delete($id);

        return ApiResponse::jsonSuccess(new JsonResource([]), Response::HTTP_OK, 'Seller deleted successfully!');
    }
}
