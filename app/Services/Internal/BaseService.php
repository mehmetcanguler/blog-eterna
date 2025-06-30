<?php

namespace App\Services\Internal;

use App\Contracts\Internal\ServiceInterface;
use App\Dtos\BaseDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 * @template TDTO of BaseDTO
 * @template TUpdateDTO of BaseDTO
 * @template TListDTO of BaseDTO
 *
 * @implements ServiceInterface<TModel, TDTO, TUpdateDTO, TListDTO>
 */
class BaseService implements ServiceInterface
{
    /**
     * @var TModel
     */
    protected $model;

    /**
     * @param  TModel  $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param  TListDTO  $data
     * @return LengthAwarePaginator<TModel>
     */
    public function all(BaseDTO $data): LengthAwarePaginator
    {
        $query = $this->model->query();

        if ($data->search) {
            $query->where('name', 'like', '%'.$data->search.'%');
        }

        return $query->paginate($data->per_page);
    }

    /**
     * @param  TDTO  $data
     * @return TModel
     */
    public function create(BaseDTO $data): Model
    {
        return $this->model::create($data->toArray());
    }

    /**
     * @param  TModel  $model
     * @return TModel
     */
    public function show(Model $model): Model
    {
        return $this->model->find($model->id);
    }

    /**
     * @param  TModel  $model
     * @param  TUpdateDTO  $data
     * @return TModel
     */
    public function update(Model $model, BaseDTO $data): Model
    {
        $this->model->find($model->id)->update($data->toArray());

        return $this->model;
    }

    /**
     * @param  TModel  $model
     */
    public function delete(Model $model): bool
    {
        return $this->model->find($model->id)->delete();
    }
}
