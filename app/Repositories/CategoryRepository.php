<?php

namespace App\Repositories;

use App\Models\Category;
use App\Services\ODataService;

class CategoryRepository extends BaseRepository
{
    /**
    * @var Category
    */
    protected $model;

    protected $request;

    protected $oDataService;

    protected $fieldSearchable = [];

    public function __construct()
    {
       $this->model         = new Category();
       $this->request       = request();
       $this->oDataService  = new ODataService();
    }
}
