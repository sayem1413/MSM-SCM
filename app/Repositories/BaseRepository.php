<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    protected $request;

    protected $oDataService;

    protected $fieldSearchable;

    public function getModel()
    {
        return $this->model;
    }

    public function newQuery(): Builder
    {
        return $this->model->newQuery();
    }

    public function all()
    {
        return $this->model->all();
    }

    public function list()
    {
        $queryParams = $this->oDataService->getQueryParams();
        $oDataParams = $this->oDataService->getODataParams();

        $select     = isset($oDataParams['select'])     ? $oDataParams['select']      : [];
        $compute    = isset($oDataParams['compute'])    ? $oDataParams['compute']     : null;
        $search     = isset($oDataParams['search'])     ? $oDataParams['search']      : '';
        $count      = isset($oDataParams['count'])      ? $oDataParams['count']       : null;
        $expand     = isset($oDataParams['expand'])     ? $oDataParams['expand']      : null;
        $filter     = isset($oDataParams['filter'])     ? $oDataParams['filter']      : [];
        $orderBy    = isset($oDataParams['orderby'])    ? $oDataParams['orderby']     : [];
        $apply      = isset($oDataParams['apply'])      ? $oDataParams['apply']       : [];
        $skip       = isset($oDataParams['skip'])       ? $oDataParams['skip']        : null;
        $top        = isset($oDataParams['top'])        ? $oDataParams['top']         : null;

        $query = $this->newQuery();
        $query = $this->applySelect($query, $select);
        $query = $this->applySearch($query, $search);
        $query = $this->applyFilters($query, $filter);
        $query = $this->applyAggregates($query, $apply);
        $query = $this->applyOrderBy($query, $orderBy);

        $totalCount     = $query->count();
        $perPage        = isset($top)  ? $top : $totalCount;
        $pageCount      = isset($top)  ? ceil($totalCount / $perPage) : 1;
        $currentPage    = isset($skip) ? ceil($skip / $perPage) : 1;

        if(!empty($skip)) {
            $query = $query->skip($skip);
        }
        if(!empty($top)) {
            $query = $query->take($top);
        }

        return [
            'meta' => [
                'totalCount'  => $totalCount,
                'pageCount'   => $pageCount,
                'currentPage' => $currentPage,
                'perPage'     => $perPage,
            ],
            'results' => $query->get(),
        ];
    }

    public function has($relation)
    {
        return $this->model->has($relation);
    }

    public function with(array $tables)
    {
        return $this->model->with($tables);
    }

    public function withShow($relations, $id)
    {
        return $this->model->with($relations)->findOrFail($id);
    }

    public function withCount(array $relationships)
    {
        return $this->model->withCount($relationships);
    }

    public function withTrashed()
    {
        try {
            $this->model = $this->model->withTrashed();
        }
        catch (\Exception $e) {

        }

        return $this;
    }

    public function onlyTrashed()
    {
        try {
            $this->model = $this->model->onlyTrashed();
        }
        catch (\Exception $e) {

        }

        return $this;
    }

    public function count()
    {
        return $this->model->count();
    }

    public function countWhere(array $where)
    {
        return $this->model->where($where)->count();
    }

    public function exists(array $where)
    {
        return $this->model->where($where)->exists();
    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function get(array $columns = ['*'])
    {
        return $this->model->get($columns);
    }

    public function getById($id, array $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    public function find(array $data, $columns = ['*'])
    {
        return $this->model->where($data)->get($columns);
    }

    public function findBy($field, $value)
    {
        return $this->model->where($field, '=', $value)->first();
    }

    public function findById($id, $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    public function findWhere($column, $value, $columns = ['*'])
    {
        return $this->model->where($column, $value)->get($columns);
    }

    public function findWhereFirst($column, $value, $columns = ['*'])
    {
        return $this->model->where($column, $value)->firstOrFail($columns);
    }

    public function findWhereIn($field, array $values, $columns = ['*'])
    {
        return $this->model->whereIn($field, $values)->get($columns);
    }

    public function findWhereNotIn($field, array $values, $columns = ['*'])
    {
        return $this->model->whereNotIn($field, $values)->get($columns);
    }

    public function whereNotNull($field)
    {
        return $this->model->whereNotNull($field);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function insert(array $data)
    {
        return $this->model->insert($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->find($id)->update($data);
    }

    public function updateBy($field, $value, array $data)
    {
        return $this->model->where($field, '=', $value)->update($data);
    }

    public function multiUpdate($column, $value, $input)
    {
        $value = is_array($value) ? $value : [$value];
        return $this->model->whereIn($column, $value)->update($input);
    }

    public function save()
    {
        return $this->model->save();
    }

    public function delete($ids)
    {
        $ids = is_array($ids) ? $ids : [$ids];
        return $this->model->whereIn('id', $ids)->delete();
    }

    public function deleteBy($field, $value)
    {
        return $this->model->where($field, '=', $value)->delete();
    }

    public function deleteByWhere(array $where)
    {
        return $this->model->where($where)->delete();
    }

    public function forceDelete($ids)
    {
        $ids = is_array($ids) ? $ids : [$ids];
        return $this->model->whereIn('id', $ids)->forceDelete();
    }

    public function orderBy($column, $option = 'asc')
    {
        $model = $this->model->orderBy($column, $option);
        $this->makeModel();

        return $model;
    }

    public function join($tableName, $tableColumn, $modelColumn, $option = '')
    {
        switch ($option) {
            case 'leftJoin':
                $this->model = $this->model->leftJoin($tableName, $tableColumn, $modelColumn);
                break;

            case 'rightJoin':
                $this->model = $this->model->rightJoin($tableName, $tableColumn, $modelColumn);
                break;

            default:
                $this->model = $this->model->join($tableName, $tableColumn, $modelColumn);
        }

        return $this;
    }

    public function groupBy($columns)
    {
        $columns = is_array($columns) ? $columns : [$columns];
        return $this->model->groupBy($columns);
    }

    public function getTableColumns()
    {
        return Schema::getColumnListing($this->model->getTable());
    }

    protected function applySelect(Builder $query, array $fields): Builder
    {
        if (empty($fields)) {
            return $query;
        }

        return $this->model->select($fields);
    }

    protected function applyOrderBy(Builder $query, array $orders = []): Builder
    {
        if (empty($orders)) {
            return $query;
        }

        // Default Order By
        if(empty($orders)) {
            $query = $query->orderBy('id', 'asc');
            return $query;
        }

        foreach ($orders AS $item) {
            $itemOrderBy = explode(' ', $item);
            //  $orderBy = $item['property'];
            //  $order = $item['direction'];
            $query = $query->orderBy($itemOrderBy[0], $itemOrderBy[1]);
        }
        return $query;
    }

    protected function applyPaginate(Builder $query, $page, $limit): Builder
    {
        $offset = $limit * ($page - 1);
        return $query->skip($offset)->take($limit);
    }

    protected function applyAggregates(Builder $query, array $aggregates = []): Builder
    {
        if (empty($aggregates)) {
            return $query;
        }

        /*
        switch (strtolower($aggregates['key'])) {
            case 'count':
                $query = $query->count();
                break;
            case 'sum':
                $query = $query->sum($aggregates['value']);
                break;
        }
        */

        return $query;
    }

    protected function applyFilters(Builder $query, array $filters = []): Builder
    {
        if (empty($filters)) {
            return $query;
        }

        $rawQuery = '';
        foreach($filters as $filter) {
            if ($filter == 'and') {
                $rawQuery .= ' AND ';
            }
            else if($filter == 'or') {
                $rawQuery .= ' OR ';
            }
            else {
                $rawQuery .= $filter['var1'] . " " . $filter['op'] . " " . $filter['var2'];
            }
        }

        $query = $query->whereRaw($rawQuery);

        return $query;
    }

    protected function applySearch(Builder $query, string $search): Builder
    {
        if (empty($search)) {
            return $query;
        }

        if (count($this->fieldSearchable)) {
            $query->where(function(Builder $query) use ($search) {
                foreach($this->fieldSearchable as $key) {
                    $query->orWhere($key, 'like', "%{$search}%");
                }
            });
        }

        /*$query->where(function(Builder $query) use ($search) {
            $query->orWhere('description', 'like', "%{$search}%");
            $query->orWhere('ref_no', 'like', "%{$search}%");
        });*/

        return $query;
    }
}
