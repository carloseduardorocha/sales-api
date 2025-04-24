<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Contracts\SaleContract;
use App\Http\Requests\SaleRequest;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleController extends Controller
{
    public function __construct(private SaleContract $sale_service)
    {
    }

    public function index(): JsonResponse
    {
        $sales = $this->sale_service->list();

        return ApiResponse::jsonSuccess(new JsonResource($sales), Response::HTTP_OK, 'Sales listed successfully!');
    }

    public function store(SaleRequest $request): JsonResponse
    {
        $data = $request->validated();
        $sale = $this->sale_service->create($data['seller_id'], $data['amount'], $data['sale_date']); // @phpstan-ignore-line

        return ApiResponse::jsonSuccess(new JsonResource($sale), Response::HTTP_CREATED, 'Sale created successfully!');
    }

    public function show(int $id): JsonResponse
    {
        $sale = $this->sale_service->get($id);

        return ApiResponse::jsonSuccess(new JsonResource($sale), Response::HTTP_OK, 'Sale obtained successfully!');
    }

    public function update(SaleRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $this->sale_service->update($id, $data['seller_id'], $data['amount'], $data['sale_date']); // @phpstan-ignore-line

        return ApiResponse::jsonSuccess(new JsonResource([]), Response::HTTP_OK, 'Sale updated successfully!');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->sale_service->delete($id);

        return ApiResponse::jsonSuccess(new JsonResource([]), Response::HTTP_OK, 'Sale deleted successfully!');
    }

    public function getAllSalesBySeller(int $seller_id): JsonResponse
    {
        $sales = $this->sale_service->getAllSalesBySeller($seller_id);

        return ApiResponse::jsonSuccess(new JsonResource($sales), Response::HTTP_OK, 'Sales by seller listed successfully!');
    }

    public function getCommissionBySeller(int $seller_id): JsonResponse
    {
        $commission = $this->sale_service->getCommissionBySellerId($seller_id);

        return ApiResponse::jsonSuccess(new JsonResource(['total' => $commission]), Response::HTTP_OK, 'Total commission obtained successfully!');
    }
}
