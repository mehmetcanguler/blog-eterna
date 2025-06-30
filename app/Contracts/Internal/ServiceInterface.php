<?php

namespace App\Contracts\Internal;

use App\Dtos\BaseDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 * @template TDTO of BaseDTO
 * @template TUpdateDTO of BaseDTO
 * @template TListDTO of BaseDTO
 */
interface ServiceInterface
{
    /**
     * @param  TListDTO  $data
     * @return LengthAwarePaginator<TModel>
     */
    public function all(BaseDTO $data): LengthAwarePaginator;

    /**
     * @param  TDTO  $data
     * @return TModel
     */
    public function create(BaseDTO $data): Model;

    /**
     * @param  TModel  $model
     * @return TModel
     */
    public function show(Model $model): Model;

    /**
     * @param  TModel  $model
     * @param  TUpdateDTO  $data
     * @return TModel
     */
    public function update(Model $model, BaseDTO $data): Model;

    /**
     * @param  TModel  $model
     */
    public function delete(Model $model): bool;
}
