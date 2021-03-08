<?php

namespace App\Http\Resources;

use App\Repositories\DeliveryOrderRepository;
use App\Repositories\RetailerRepository;
use App\Repositories\SalesOrderRepository;
use GuzzleHttp\Promise;
use App\Repositories\DealerRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\DesignationRepository;
use App\Repositories\EmployeeRepository;
use App\Services\Microservice\UserService;
use App\Services\Microservice\LocationService;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    private static $isCollection;

    private static $user;

    private static $location;

    public function toArray($request)
    {
        $data = parent::toArray($request);
        $includesData = [];

        try {

            if (isset($data['employee_id'])) {
                $employeeRepository = new EmployeeRepository();

                $employeeInfo = $employeeRepository->getEmployeeInfoById($data['employee_id']);
                $includesData['employee_name'] = isset($employeeInfo->first_name) ? $employeeInfo->first_name . ' ' .  $employeeInfo->last_name : '';
                $includesData['employee_code'] = isset($employeeInfo->code) ? $employeeInfo->code : '';
                $includesData['employee_image'] = isset($employeeInfo->image) ? $employeeInfo->image : '';
                $includesData['employee_contact_number'] = isset($employeeInfo->personal_contact_number) ? $employeeInfo->personal_contact_number : '';
            }

            if (isset($data['dealer_id'])) {
                $dealerRepository = new DealerRepository();

                $dealerInfo = $dealerRepository->getDealerInfoById($data['dealer_id']);
                $includesData['dealer_name'] = isset($dealerInfo->org_name) ? $dealerInfo->org_name : '';
                $includesData['dealer_org_name'] = isset($dealerInfo->org_name) ? $dealerInfo->org_name : '';
                $includesData['dealer_code'] = isset($dealerInfo->code) ? $dealerInfo->code : '';
                $includesData['dealer_image'] = isset($dealerInfo->image) ? $dealerInfo->image : '';
                $includesData['dealer_contact_person'] = isset($dealerInfo->first_name) ? $dealerInfo->first_name . ' ' . $dealerInfo->last_name : '';
                $includesData['dealer_contact_number'] = isset($dealerInfo->contact_number) ? $dealerInfo->contact_number : '';
                $includesData['dealer_address'] = isset($dealerInfo->address) ? $dealerInfo->address : '';
            }

            if (isset($data['retailer_id'])) {
                $retailerRepository = new RetailerRepository();

                $retailerInfo = $retailerRepository->getRetailerInfoById($data['retailer_id']);
                $includesData['retailer_name'] = isset($retailerInfo->first_name) ? $retailerInfo->first_name . ' ' . $retailerInfo->last_name : '';
                $includesData['retailer_org_name'] = isset($retailerInfo->org_name) ? $retailerInfo->org_name : '';
                $includesData['retailer_image'] = isset($retailerInfo->image) ? $retailerInfo->image : '';
                $includesData['retailer_contact_number'] = isset($retailerInfo->contact_number) ? $retailerInfo->contact_number : '';
                $includesData['retailer_address'] = isset($retailerInfo->address) ? $retailerInfo->address : '';
            }

            if (isset($data['department_id'])) {
                $departmentRepository = new DepartmentRepository();
                $includesData['department_name'] = $departmentRepository->getDepartmentNameById($data['department_id']);
            }

            if (isset($data['designation_id'])) {
                $designationRepository = new DesignationRepository();
                $includesData['designation_name'] = $designationRepository->getDesignationNameById($data['designation_id']);
            }

            if (isset($data['sales_order_id'])) {
                $salesOrderRepository = new SalesOrderRepository();

                $salesOrderInfo = $salesOrderRepository->getSalesOrderInfoById($data['sales_order_id']);
                $includesData['sales_order_no'] = isset($salesOrderInfo->sales_order_no) ? $salesOrderInfo->sales_order_no : '';
                $includesData['so_billed_qty'] = isset($salesOrderInfo->so_billed_qty) ? $salesOrderInfo->so_billed_qty : 0;
            }

            if (isset($data['delivery_oder_id'])) {
                $deliveryOrderRepository = new DeliveryOrderRepository();

                $deliveryOrderInfo = $deliveryOrderRepository->getDeliveryOrderInfoById($data['delivery_oder_id']);
                $includesData['delivery_order_no'] = isset($deliveryOrderInfo->delivery_order_no) ? $deliveryOrderInfo->delivery_order_no : '';
                $includesData['delivery_billed_qty'] = isset($deliveryOrderInfo->delivery_billed_qty) ? $deliveryOrderInfo->delivery_billed_qty : 0;
                $includesData['delivery_actual_qty'] = isset($deliveryOrderInfo->delivery_actual_qty) ? $deliveryOrderInfo->delivery_actual_qty : 0;
            }

            return array_merge($data, $includesData);
        }
        catch (\Exception $e) {
            return array_merge($data, $includesData);
        }
    }

    public static function withMicroServiceRelationalData($resource)
    {
        try {
            self::loadMicroServiceAsyncData($resource);

            if (self::$isCollection) {
                $result = [];
                foreach ($resource as $key => $item) {
                    $result[$key] = self::appendMicroServiceRelationalItemData($item);
                }
                return $result;
            }
            else {
                $result = self::appendMicroServiceRelationalItemData($resource);
                return $result;
            }
        }
        catch (\Exception $e) {
            return $resource;
        }
        catch (\Throwable $e) {
            return $resource;
        }
    }

    public static function loadMicroServiceAsyncData($resource)
    {
        $promises = [];
        $isCollection = isset($resource[0]) && is_array($resource[0]) ? true : false;
        self::$isCollection = $isCollection;

        // User
        $userService = new UserService();
        if ($isCollection) {
            $userIds = array_column($resource, 'user_id');
            $createdByIds = array_column($resource, 'created_by');
            $updatedByIds = array_column($resource, 'updated_by');
        }
        else {
            $userIds = isset($resource['user_id']) ? [$resource['user_id']] : [];
            $createdByIds = isset($resource['created_by']) ? [$resource['created_by']] : [];
            $updatedByIds = isset($resource['updated_by']) ? [$resource['updated_by']] : [];
        }
        $allUserIds = array_merge($userIds, $createdByIds, $updatedByIds);
        $allUserIds = array_unique($allUserIds);
        if (is_array($allUserIds) && count($allUserIds) > 0) {
            $promises['user'] = $userService->requestAsync('GET', [
                'query' => [
                    '$select' => "id,first_name,last_name,email,profile_image",
                    '$filter' => "id IN(".implode(',', $allUserIds).")",
                ]
            ]);
        }

        // Location
        $locationService = new LocationService();
        if ($isCollection) {
            $divisionIds = array_column($resource, 'division_id');
            $districtIds = array_column($resource, 'district_id');
            $thanaIds    = array_column($resource, 'thana_id');
        }
        else {
            $divisionIds = isset($resource['division_id']) ? [$resource['division_id']] : [];
            $districtIds = isset($resource['district_id']) ? [$resource['district_id']] : [];
            $thanaIds    = isset($resource['thana_id']) ? [$resource['thana_id']] : [];
        }
        $locationIds = array_merge($divisionIds, $districtIds, $thanaIds);
        $locationIds = array_unique($locationIds);
        if (is_array($locationIds) && count($locationIds) > 0) {
            $promises['location'] = $locationService->requestAsync('GET', [
                'query' => [
                    '$select' => "id,code,name",
                    '$filter' => "id IN(".implode(',', $locationIds).")",
                ]
            ]);
        }

        $responses = Promise\unwrap($promises);
        $responses = Promise\settle($promises)->wait();

        if (isset($responses['location']) && array_key_exists('value', $responses['location'])) {
            $responseData = json_decode($responses['location']['value']->getBody()->getContents(), true);
            self::$location = array_key_exists('results', $responseData) ? $responseData['results'] : [];
        }

        if (isset($responses['user']) && array_key_exists('value', $responses['user'])) {
            $responseData = json_decode($responses['user']['value']->getBody()->getContents(), true);
            self::$user = array_key_exists('results', $responseData) ? $responseData['results'] : [];
        }
    }

    public static function appendMicroServiceRelationalItemData($data)
    {
        if (empty($data)) {
            return $data;
        }

        // User
        $user = self::$user;
        $data['user_name'] = '';
        $data['created_by_name'] = '';
        $data['updated_by_name'] = '';
        if (is_array($user) && count($user)) {
            if (array_key_exists('user_id', $data)) {
                $userKey = array_search($data['user_id'], array_column($user, 'id'));
                $data['user_name'] = isset($user[$userKey]['first_name']) ? $user[$userKey]['first_name'] . ' ' . $user[$userKey]['last_name'] : '';
            }

            if (array_key_exists('created_by', $data)) {
                $createdByKey = array_search($data['created_by'], array_column($user, 'id'));
                $data['created_by_name'] = isset($user[$createdByKey]['first_name']) ?  $user[$createdByKey]['first_name'] . ' ' . $user[$createdByKey]['last_name'] : '';
            }

            if (array_key_exists('updated_by', $data)) {
                $updatedByKey = array_search($data['updated_by'], array_column($user, 'id'));
                $data['updated_by_name'] = isset($user[$updatedByKey]['first_name']) ? $user[$updatedByKey]['first_name'] . ' ' . $user[$updatedByKey]['last_name'] : '';
            }
        }

        // Location
        $location = self::$location;
        $data['division_name'] = '';
        $data['district_name'] = '';
        $data['thana_name'] = '';
        if (is_array($location) && count($location)) {
            if (array_key_exists('division_id', $data)) {
                $divisionKey = array_search($data['division_id'], array_column($location, 'id'));
                $data['division_name'] = isset($location[$divisionKey]['name']) ? $location[$divisionKey]['name'] : '';
            }

            if (array_key_exists('district_id', $data)) {
                $districtKey = array_search($data['district_id'], array_column($location, 'id'));
                $data['district_name'] = isset($location[$districtKey]['name']) ? $location[$districtKey]['name'] : '';
            }

            if (array_key_exists('thana_id', $data)) {
                $thanaKey = array_search($data['thana_id'], array_column($location, 'id'));
                $data['thana_name'] = isset($location[$thanaKey]['name']) ? $location[$thanaKey]['name'] : '';
            }
        }

        return $data;
    }
}
