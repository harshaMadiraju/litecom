<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Repositories\VariantsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VariantsController extends Controller
{
    public $repository;

    public function __construct(VariantsRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @OA\Get(
     *  path="/api/variants/all",
     *  summary="Get All variants",
     *  tags={"variants"},
     *  security={{"bearerAuth":{}}},
     *  @OA\Response(response=200, description="Return a list of resources"),
     * )
     * @param  Request  $request
     * @return JsonResponse
     */

    public function index(Request $request)
    {
        $collection = $request->all();
        $variants = $this->repository->all($collection);
        return response()->json($variants, $variants['status']);
    }

    /**
     * @OA\Post(
     *  path="/api/variants/create",
     *  summary="Create a variant",
     *  tags={"variants"},
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
            return response()->json(Response::prepareResponse(false, [], trans('messages.validations.fail', ['action' => 'Create', 'var' => 'variant']), Response::FORM_VALIDATION_ERROR, $validator->getMessageBag()->all()), Response::FORM_VALIDATION_ERROR);
        }

        $variant = $this->repository->create($request->all());
        return response()->json($variant, $variant['status']);
    }

    /**
     * @OA\Get(
     *  path="/api/variants/{id}",
     *  summary="Get a variant",
     *  tags={"variants"},
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
        $variant = $this->repository->findById($id);
        if (!$variant) {
            return response()->json(Response::prepareResponse(false, [], trans('messages.validations.fail', ['action' => 'Retrieve', 'var' => 'variant']), Response::FORM_VALIDATION_ERROR), Response::FORM_VALIDATION_ERROR);
        }

        return response()->json(Response::prepareResponse(true, [$variant], trans('messages.validations.success', ['action' => 'Retrieved', 'var' => 'variant']), Response::SUCCESS), Response::SUCCESS);
    }

    /**
     * @OA\Put (
     *  path="/api/variants/update/{id}",
     *  summary="Update variant",
     *  tags={"variants"},
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
        $variant = $this->repository->findById($id);
        if (!$variant) {
            return response()->json(Response::prepareResponse(false, [], trans('messages.validations.fail', ['action' => 'Retrieve', 'var' => 'variant']), Response::FORM_VALIDATION_ERROR), Response::FORM_VALIDATION_ERROR);
        }

        $collection = $request->all();
        $validator = Validator::make($collection, $this->repository->getUpdateRules());

        if ($validator->fails()) {
            return response()->json(Response::prepareResponse(false, [], trans('messages.validations.fail', ['action' => 'Update', 'var' => 'variant']), Response::FORM_VALIDATION_ERROR, $validator->getMessageBag()->all()), Response::FORM_VALIDATION_ERROR);
        }

        $update_variant = $this->repository->update($collection, $id);
        return response()->json($update_variant, $update_variant['status']);
    }

    /**
     * @OA\Delete (
     *  path="/api/variants/{id}",
     *  summary="Delete variant",
     *  tags={"variants"},
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
        $variant = $this->repository->findById($id);
        if (!$variant) {
            return response()->json(Response::prepareResponse(false, [], trans('messages.validations.fail', ['action' => 'Retrieve', 'var' => 'variant']), Response::FORM_VALIDATION_ERROR), Response::FORM_VALIDATION_ERROR);
        }

        $delete_variant = $this->repository->delete($id);
        return response()->json($delete_variant, $delete_variant['status']);
    }
}
