<?php

namespace App\Repository\interfaces;

use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    /**
     * The repository associated main model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    public function setModel();

    /**
     * Set user model class.
     *
     * @return UserModel
     */
    public function setUserModel();

    /**
     * Generate new Query.
     *
     * @return QueryBuilder
     */
    public function newQuery();

    /**
     * Return array response
     *
     * @param array $messages
     * @param mixed $message
     * @return mixed
     */
    public function getResponseMessage(bool $success, $message, int $status_code, bool $translate = false);

    /**
     * Return array response result
     *
     * @param array $data
     * @return mixed
     */
    public function getResponseResult(bool $success, $data, int $status_code);

    public function getTranslateMessage($message);

    /**
     * Find model by id
     *
     * @param string $id
     * @return mixed
     */
    public function find($id);

    /**
     * Find model by id
     *
     * @throws ModelNotFoundException
     * @return mixed
     */
    public function findOneOrFail(int $id);

    /**
     * Find element by parameters
     *
     * @return mixed
     */
    public function where(string $column, string $value, string $operator = '=', array $includes);

    /**
     * Find list model by parameters
     *
     * @param array $data
     * @return mixed
     */
    public function findAllBy(string $column, string $value, string $operator = '=', array $includes = []);

    /**
     *  Find first element in model by parameters
     * @param array $data
     * @return mixed
     */
    public function findOneBy(string $column, string $value, string $operator = '=', array $includes = []);

    /**
     * Find first element in model by parameters
     * @param array $data
     * @throws ModelNotFoundException
     * @return mixed
     */
    public function findOneByOrFail(string $column, string $value, string $operator = '=', array $includes = []);

    /**
     * Find max id
     *
     * @return mixed
     */
    public function findMax(string $id);

    /**
     * Find model by id
     *
     * @param string $id
     * @return mixed
     */
    public function findWithIncludes($id, array $includes = []);

    /**
     * Return all records
     * @param mixed $queryValue
     * @return mixed
     */
    public function all(array $includes = [], $queryValue = '', string $orderByColumn = '', string $direction = 'asc');

    /**
     * Create a new model
     *
     * @return mixed
     */
    public function create(array $model);

    /**
     * Update model with id
     *
     * @param string $id
     * @return mixed
     */
    public function update($id, array $model);

    /**
     * Delete model with id
     *
     * @param string $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Active model with id
     *
     * @param string $id
     * @return mixed
     */
    public function active($id);

    /**
     * Paginate Model
     * @param mixed $items
     * @param mixed $per_page
     * @param mixed|null $page
     */
    public function collectionPaginate($items, $per_page = 5, $page = null);

    /**
     * Paginate Model
     *
     * @param mixed|null $query
     * @param mixed $values
     */
    public function search($query, $values);
}