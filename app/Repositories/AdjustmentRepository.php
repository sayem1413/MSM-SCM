<?php

namespace App\Repositories;

use App\Models\Adjustment;
use App\Services\ODataService;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class AdjustmentRepository extends BaseRepository
{
    /**
    * @var Adjustment
    */
    protected $model;

    protected $request;

    protected $oDataService;

    protected $fieldSearchable = [];

    public function __construct()
    {
       $this->model         = new Adjustment();
       $this->request       = request();
       $this->oDataService  = new ODataService();
    }

    public function adjustmentValue(array $filters = [])
    {
        $dealerId = Arr::get($filters, 'dealer_id', null);
        $startDate = Arr::get($filters, 'start_date', null);
        $betweenTwoDate = Arr::get($filters, 'betweenTwoDate', null);
        $aboveDays = Arr::get($filters, 'aboveDays', null);
        $betweenAboveTwoDays = Arr::get($filters, 'betweenAboveTwoDays', null);

        $query = $this->newQuery();

        $query->where('status', 1);

        if(!empty ($dealerId)) {
            $query->where('dealer_id', $dealerId);
        }

        if(!empty ($startDate)) {
            $query->whereDate('created_at','<=', $startDate);
        }

        if(!empty ($betweenTwoDate)) {
            $betweenStartDate = $betweenTwoDate['start_date'];
            $betweenEndDate = $betweenTwoDate['end_date'];
            $query->whereBetween('created_at', [$betweenStartDate . " 00:00:00", $betweenEndDate . " 23:59:59"]);
        }

        if(!empty ($aboveDays)) {
            $query->whereDate('created_at','<', Carbon::now()->subDays($aboveDays));
        }

        if(!empty ($betweenAboveTwoDays)) {
            $betweenStartDate = Carbon::now()->subDays($betweenAboveTwoDays['start_days']);
            $betweenEndDate = Carbon::now()->subDays($betweenAboveTwoDays['end_days']);
            $query->whereBetween('created_at', [$betweenStartDate . " 00:00:00", $betweenEndDate . " 23:59:59"]);
        }

        $result = $query->sum('amount');

        return !empty($result) ? $result : 0;
    }
}
