<?php

namespace App\Repository;

use App\Repository\interfaces\IRepository;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;

abstract class BaseRepository implements IRepository
{
    /**
     * The repository associated main model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * The repository associated main UserModel.
     *
     * @var \App\Models\User
     */
    protected $userModel;

    /**
     * Set model class.
     *
     * @return Model
     */
    public function setModel()
    {
        return app()->make($this->model);
    }

    /**
     * Set user model class.
     *
     * @return UserModel
     */
    public function setUserModel()
    {
        return app()->make($this->userModel);
    }

    /**
     * Generate new Query.
     *
     * @return QueryBuilder
     */
    public function newQuery()
    {
        return $this->setModel()->newQuery();
    }

    /**
     * Return array response
     *
     * @param array $messages
     * @param mixed $message
     * @return mixed
     */
    public function getResponseMessage(bool $success, $message, int $status_code, bool $translate = false)
    {
        $messages = $translate ? $this->getTranslateMessage($message) : $message;
        if (Str::contains($messages, 'Integrity constraint violation: 1451 Cannot delete or update a parent row')) {
            $messages = $this->getTranslateMessage('Record Have Relationship Rows');
        }
        if (Str::contains($messages, 'Integrity constraint violation')) {
            $messages = $this->getTranslateMessage('Record Already Exists');
        }

        return [
            'success'     => $success,
            'message'     => $messages,
            'status_code' => $status_code,
        ];
    }

    /**
     * Return array response result
     *
     * @param array $data
     * @return mixed
     */
    public function getResponseResult(bool $success, $data, int $status_code)
    {
        return [
            'success'     => $success,
            'data'        => $data,
            'status_code' => $status_code,
        ];
    }

    public function getTranslateMessage($message)
    {
        return Lang::get($message);
    }

    /**
     * Find model by id
     *
     * @param string $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->newQuery()->find($id);
    }

    /**
     * Find model by id
     *
     * @throws ModelNotFoundException
     * @return mixed
     */
    public function findOneOrFail(int $id)
    {
        return $this->newQuery()->findOrFail($id);
    }

    /**
     * Find max id
     *
     * @return mixed
     */
    public function findMax(string $id)
    {
        return $this->newQuery()->max($id);
    }

    /**
     * Find element by parameters
     *
     * @return mixed
     */
    public function where(string $column, string $value, string $operator = '=', array $includes)
    {
        return count($includes) > 0 ?
            $this->newQuery()->with($includes)->where($column, $operator, $value) :
            $this->newQuery()->where($column, $operator, $value);
    }

    /**
     * Find list model by parameters
     *
     * @param array $data
     * @return mixed
     */
    public function findAllBy(string $column, string $value, string $operator = '=', array $includes = [])
    {
        return $this->where($column, $operator, $value, $includes)->all();
    }

    /**
     *  Find first element in model by parameters
     * @param array $data
     * @return mixed
     */
    public function findOneBy(string $column, string $value, string $operator = '=', array $includes = [])
    {
        return $this->where($column, $operator, $value, $includes)->first();
    }

    /**
     * Find first element in model by parameters
     * @param array $data
     * @throws ModelNotFoundException
     * @return mixed
     */
    public function findOneByOrFail(string $column, string $value, string $operator = '=', array $includes = [])
    {
        return $this->where($column, $operator, $value, $includes)->firstOrFail();
    }

    /**
     * Find model by id
     *
     * @param string $id
     * @return mixed
     */
    public function findWithIncludes($id, array $includes = [])
    {
        try {
            $data   = count($includes) > 0 ? $this->newQuery()->with($includes)->get() : $this->newQuery()->get();
            $result = $data->find($id);
            if (false == $result) {
                return $this->getResponseMessage(false, 'Register Not Found', 404, true);
            }
            if ($result['created_by']) {
                $created_by           = $this->setUserModel()->newQuery()->findOrFail($result['created_by'])->email;
                $updated_by           = null != $result['updated_by'] ? $this->setUserModel()->newQuery()->findOrFail($result['updated_by'])->email : '';
                $closed_by            = null != $result['closed_by'] ? $this->setUserModel()->newQuery()->findOrFail($result['closed_by'])->email : '';
                $result['created_by'] = $created_by;
                $result['updated_by'] = $updated_by;
                $result['closed_by']  = $closed_by;
            }

            return $this->getResponseResult(true, $result, 200);
        } catch (\Exception $ex) {
            return $this->getResponseMessage(false, $ex->getMessage(), 500);
        }
    }

    /**
     * Return all records
     *
     * @param mixed $queryValue
     * @return mixed
     */
    public function all(array $includes = [], $queryValue = '', string $orderByColumn = '', string $direction = 'asc')
    {
        try {
            $data       = count($includes) > 0 ? $this->newQuery()->with($includes) : $this->newQuery();
            $datafilter = $this->search($data, $queryValue);
            $list       = mb_strlen($orderByColumn) > 0 ? $datafilter->orderBy($orderByColumn, $direction)->get() : $datafilter->get();

            return $this->getResponseResult(true, $list, 200);
        } catch (\Exception $ex) {
            return $this->getResponseMessage(false, $ex->getMessage(), 500);
        }
    }

    /**
     * Create a new model
     *
     * @return mixed
     */
    public function create(array $model)
    {
        try {
            $this->setModel()->create($model);

            return $this->getResponseMessage(true, 'Register Created Success', 200, true);
        } catch (\Exception $ex) {
            return $this->getResponseMessage(false, $ex->getMessage(), 500);
        }
    }

    /**
     * Update model with id
     *
     * @param string $id
     * @return mixed
     */
    public function update($id, array $model)
    {
        try {
            $itemToEdit = $this->find($id);
            if (false == $itemToEdit) {
                return $this->getResponseMessage(false, 'Register Not Found', 404, true);
            }
            $itemToEdit->update($model);

            return $this->getResponseMessage(true, 'Register Updated Success', 200, true);
        } catch (\Exception $ex) {
            return $this->getResponseMessage(false, $ex->getMessage(), 500);
        }
    }

    /**
     * Delete model with id
     *
     * @param string $id
     * @return mixed
     */
    public function delete($id)
    {
        try {
            $itemToDelete = $this->find($id);
            if (false == $itemToDelete) {
                return $this->getResponseMessage(false, 'Register Not Found', 404, true);
            }
            $itemToDelete->delete();

            return $this->getResponseMessage(true, 'Register Deleted Success', 200, true);
        } catch (\Exception $ex) {
            return $this->getResponseMessage(false, $ex->getMessage(), 500);
        }
    }

    /**
     * Active model with id
     *
     * @param string $id
     * @return mixed
     */
    public function active($id)
    {
        try {
            $itemToActive = $this->find($id);
            if (false == $itemToActive) {
                return $this->getResponseMessage(false, 'Register Not Found', 404, true);
            }
            $itemToActive->update([
                'active' => !$itemToActive->active,
            ]);
            $message = $itemToActive->active ?
                $this->getTranslateMessage('Register Actived Success') : $this->getTranslateMessage('Register Inactived Success');

            return $this->getResponseMessage(true, $message, 200);
        } catch (\Exception $ex) {
            return $this->getResponseMessage(false, $ex->getMessage(), 500);
        }
    }

    public function collectionPaginate($items, $per_page = 5, $page = null)
    {
        $page   = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $offset = ($page * $per_page) - $per_page;

        return new LengthAwarePaginator(
            $items->forPage($page, $per_page)->values(),
            $items->count(),
            $per_page,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );
    }

    public function search($query, $value)
    {
        $fillables = $this->setModel()->getFillable();
        foreach ($fillables as $key => $valueFillable) {
            if (false == mb_strpos($valueFillable, '_id')) {
                foreach ($this->relationships() as $keyr => $relationship) {
                    $query->whereHas($relationship, function ($selfQuery) use ($value) {
                        $selfQuery->Where($selfQuery->getModel()->getFillable()[0], 'LIKE', '%'.$value.'%');
                    });
                }
                $query = $query->orWhere($valueFillable, 'LIKE', '%'.$value.'%');
            }
        }

        return $query;
    }

    protected function relationships()
    {
        $reflector     = new ReflectionClass($this->model);
        $model         = $this->setModel();
        $relationships = [];
        foreach ($reflector->getMethods(ReflectionMethod::IS_PUBLIC) as $reflectionMethod) {
            if ($reflectionMethod->class != get_class($model) || !empty($reflectionMethod->getParameters()) ||
            __FUNCTION__ == $reflectionMethod->getName()) {
                continue;
            }
            $return = $reflectionMethod->invoke($model);
            if ($return instanceof Relation) {
                if (in_array(class_basename((new ReflectionClass($return))->getShortName()), ['HasOne', 'HasMany', 'BelongsTo', 'BelongsToMany', 'MorphToMany', 'MorphTo'])) {
                    array_push($relationships, $reflectionMethod->name);
                }
            }
        }

        return $relationships;
    }
}