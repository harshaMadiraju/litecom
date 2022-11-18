<?php

namespace App\Repositories;

use App\Helpers\Response;
use App\Repositories\BaseRepository;
use App\Models\Products;
use App\Models\Variants;
use App\Repositories\RepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductsRepository.
 */
class VariantsRepository extends BaseRepository implements RepositoryInterface
{
    public $model;

    public function __construct()
    {
        $this->model = new Variants;
    }

    public function all($collection = [])
    {
        try {

            $data = $this->model->getAllData($collection, $this->model->getSearchable());

            $data = $data->toArray();


            if ($data) {
                return Response::prepareResponse(true, $data, trans('messages.validations.success', ['action' => 'Retrieved', 'var' => 'Products']), Response::SUCCESS, []);
            }

            return Response::prepareResponse(false, [], trans('messages.validations.fail', ['action' => 'Retrieve', 'var' => 'Products']), Response::INTERNAL_SERVER_ERROR, []);
        } catch (Exception $e) {
            return Response::prepareResponse(false, [], trans('messages.validations.fail', ['action' => 'Retrieve', 'var' => 'Products']), Response::INTERNAL_SERVER_ERROR, ['error' => $e->getMessage()]);
        }
    }

    public function create($collection = [])
    {
        try {
            $product = $this->model->create($collection);

            if ($product) {
                return Response::prepareResponse(true, [$product], trans('messages.validations.success', ['action' => 'Created', 'var' => 'Product']), Response::SUCCESS, []);
            }
            return Response::prepareResponse(false, [], trans('messages.validations.fail', ['action' => 'Create', 'var' => 'Product']), Response::INTERNAL_SERVER_ERROR, []);
        } catch (Exception $e) {
            return Response::prepareResponse(false, [], trans('messages.validations.fail', ['action' => 'Create', 'var' => 'Product']), Response::INTERNAL_SERVER_ERROR, ['error' => $e->getMessage()]);
        }
    }

    public function update($collection = [], $id)
    {
        try {
            $product = $this->model->where('id', $id)->update($collection);

            if ($product) {
                return Response::prepareResponse(true, $product, trans('messages.validations.success', ['action' => 'Updated', 'var' => 'Product']), Response::SUCCESS, []);
            }
            return Response::prepareResponse(false, [], trans('messages.validations.fail', ['action' => 'Update', 'var' => 'Product']), Response::INTERNAL_SERVER_ERROR, [$product]);
        } catch (Exception $e) {
            return Response::prepareResponse(false, [], trans('messages.validations.fail', ['action' => 'Update', 'var' => 'Product']), Response::INTERNAL_SERVER_ERROR, ['error' => $e->getMessage()]);
        }
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function delete($id)
    {
        try {
            $product = $this->model->where('id', $id)->delete();

            if ($product) {
                return Response::prepareResponse(true, [], trans('messages.validations.success', ['action' => 'Deleted', 'var' => 'Product']), Response::SUCCESS, []);
            }
            return Response::prepareResponse(false, [], trans('messages.validations.fail', ['action' => 'Delete', 'var' => 'Product']), Response::INTERNAL_SERVER_ERROR, []);
        } catch (Exception $e) {
            return Response::prepareResponse(false, [], trans('messages.validations.fail', ['action' => 'Delete', 'var' => 'Product']), Response::INTERNAL_SERVER_ERROR, ['error' => $e->getMessage()]);
        }
    }

    public function getCreateRules()
    {
        return $this->model->getCreateRules();
    }
    public function getUpdateRules()
    {
        return $this->model->getUpdateRules();
    }
}
