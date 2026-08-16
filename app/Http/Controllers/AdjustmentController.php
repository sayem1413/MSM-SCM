<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdjustmentResource;
use App\Repositories\AdjustmentRepository;
use App\Traits\Controller\RestControllerTrait;
use App\Validators\AdjustmentValidator;
use Illuminate\Support\Facades\Cache;

class AdjustmentController extends Controller
{
    private $repository;

    private $validator;

    private $resource;

    private $updateFields = ['adjustment_type', 'amount', 'note'];

    use RestControllerTrait;

    public function __construct(AdjustmentRepository $repository, AdjustmentValidator $validator)
    {
        Cache::set('language', 'bangladesh');

        $this->repository = $repository;
        $this->validator = $validator;
        $this->resource = AdjustmentResource::class;
    }

}
