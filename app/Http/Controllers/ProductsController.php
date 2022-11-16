<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Repositories\ProductsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public $repository;

    public function __construct(ProductsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *  path="/api/products/all",
     *  summary="Get All Products",
     *  tags={"Products"},
     *  security={{"bearerAuth":{}}},
     *  @OA\Response(response=200, description="Return a list of resources"),
     * )
     * @param  Request  $request
     * @return JsonResponse
     */

    public function index(Request $request)
    {
        $collection = $request->all();
        $products = $this->repository->all($collection);
        return response()->json($products, $products['status']);
    }

    /**
     * @OA\Post(
     *  path="/api/products/create",
     *  summary="Create a Product",
     *  tags={"Products"},
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", example="Apple Iphone 14"),
     *          ),
     *      ),
     *  security={{"bearerAuth":{}}},
     *  @OA\Response(response=200, description="Created successfully"),
     *  @OA\Response(response=422, description="Bad request"),
     *  @OA\Response(response=500, description="Internal server error"),
     * )
     * @param  Request  $request
     * @return JsonResponse
     */

    public function create(Request $request)
    {
        $collection = $request->all();

        $validator = Validator::make($collection, $this->repository->getCreateRules());

        if ($validator->fails()) {
            return response()->json(Response::prepareResponse(false, [], trans('messages.validations.fail', ['action' => 'Create', 'var' => 'Product']), Response::FORM_VALIDATION_ERROR, $validator->getMessageBag()->all()), Response::FORM_VALIDATION_ERROR);
        }

        $product = $this->repository->create($request->all());
        return response()->json($product, $product['status']);
    }

    /**
     * @OA\Get(
     *  path="/api/products/{id}",
     *  summary="Get a product",
     *  tags={"Products"},
     *  @OA\Parameter(name="id", description="id, eg; 2", required=true, in="path", @OA\Schema(type="integer")),
     *  security={{"bearerAuth":{}}},
     *  @OA\Response(response=200, description="Retrieved successfully"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     * @param $id
     * @return JsonResponse
     */

    public function show($id)
    {
        $product = $this->repository->findById($id);
        if (!$product) {
            return response()->json(Response::prepareResponse(false, [], trans('messages.validations.fail', ['action' => 'Retrieve', 'var' => 'Product']), Response::FORM_VALIDATION_ERROR), Response::FORM_VALIDATION_ERROR);
        }

        return response()->json(Response::prepareResponse(true, [$product], trans('messages.validations.success', ['action' => 'Retrieved', 'var' => 'Product']), Response::SUCCESS), Response::SUCCESS);
    }

    /**
     * @OA\Put (
     *  path="/api/products/update/{id}",
     *  summary="Update Product",
     *  tags={"Products"},
     *      @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", example="Apple Iphone 14 Pro Max"),
     *             )
     *      ),
     *  security={{"bearerAuth":{}}},
     *  @OA\Response(response=200, description="Updated successfully"),
     *  @OA\Response(response=422, description="Bad request"),
     *  @OA\Response(response=500, description="Internal server error"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     * @param  \Illuminate\Http\Request  $request
     * @param $id
     * @return JsonResponse
     */

    public function update(Request $request, $id)
    {
        $product = $this->repository->findById($id);
        if (!$product) {
            return response()->json(Response::prepareResponse(false, [], trans('messages.validations.fail', ['action' => 'Retrieve', 'var' => 'Product']), Response::FORM_VALIDATION_ERROR), Response::FORM_VALIDATION_ERROR);
        }

        $collection = $request->all();
        $validator = Validator::make($collection, $this->repository->getUpdateRules());

        if ($validator->fails()) {
            return response()->json(Response::prepareResponse(false, [], trans('messages.validations.fail', ['action' => 'Update', 'var' => 'Product']), Response::FORM_VALIDATION_ERROR, $validator->getMessageBag()->all()), Response::FORM_VALIDATION_ERROR);
        }

        $update_product = $this->repository->update($collection, $id);
        return response()->json($update_product, $update_product['status']);
    }

    /**
     * @OA\Delete (
     *  path="/api/products/{id}",
     *  summary="Delete Product",
     *  tags={"Products"},
     *  @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *  security={{"bearerAuth":{}}},
     *  @OA\Response(response=200, description="Deleted successfully"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     *  @OA\Response(response=500, description="Internal server error"),
     * )
     * @param $id
     * @return JsonResponse
     */

    public function delete($id)
    {
        $product = $this->repository->findById($id);
        if (!$product) {
            return response()->json(Response::prepareResponse(false, [], trans('messages.validations.fail', ['action' => 'Retrieve', 'var' => 'Product']), Response::FORM_VALIDATION_ERROR), Response::FORM_VALIDATION_ERROR);
        }

        $delete_product = $this->repository->delete($id);
        return response()->json($delete_product, $delete_product['status']);
    }
}
