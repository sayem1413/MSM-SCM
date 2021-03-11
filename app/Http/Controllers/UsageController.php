<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usage;
use App\Http\Requests\UsageStore;
use App\Http\Requests\UsageUpdate;
use App\Http\Resources\UsageResource;
use App\Http\Resources\UsageCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\StoresImage;
use DB;

class UsageController extends Controller
{
    use StoresImage;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = [];
        $status = 200;
        try {
            $pageLength = isset($request->page_length) ? (int) $request->page_length : 10;
            if($pageLength==0) {
                $usages = Usage::all();
            }
            else {
                $query = Usage::whereNull('deleted_at');
                if( $request->has('order_by') ){
                    if( $request->order_by == 1 ){
                        $query = $query->orderBy('name', 'asc');
                    } else if( $request->order_by == 2 ){
                        $query = $query->orderBy('name', 'desc');
                    } else {
                        $query = $query->orderBy('created_at', 'desc');
                    }
                }
                $usages_all = $query->paginate($pageLength);
                $usages = (new UsageCollection( $usages_all ))->additional(['success' => true]);
            }
            $response = [
                'usages' => $usages,
                'success' => true
            ];
        } catch(\Exception $e){
            if(config('app.env') != 'production')
                $response['getTrace'] = $e->getTrace();
            $response['errors'] = $e->getMessage();
            $status = 500;
        }
        return response()->json($response, $status);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsageStore $request)
    {
        $response = [];
        $status = 200;
        try {
            $usage = Usage::create([
                "name"          => $request->name,
                "description"   => $request->description
            ]);
            $response = [
                'data' => $usage,
                'success' => true
            ];
        } catch(\Exception $e){
            if(config('app.env') != 'production')
                $response['getTrace'] = $e->getTrace();
            $response['errors'] = $e->getMessage();
            $status = 500;
        }
        return response()->json($response, $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Usage $usage, Request $request )
    {
        $response = [];
        $status = 200;
        try {
            $response["usage"] = (new UsageResource($usage))->additional(['success' => true]);
        } catch(\Exception $e){
            if(config('app.env') != 'production')
                $response['getTrace'] = $e->getTrace();
            $response['errors'] = $e->getMessage();
            $status = 500;
        }
        return response()->json($response, $status);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsageUpdate $request, Usage $usage)
    {
        $response = [];
        $status = 200;
        try {
            $usage->update([
                "name"          => $request->name,
                "description"   => $request->description
            ]);
            $response["usage"] = $usage;
        } catch(\Exception $e){
            if(config('app.env') != 'production')
                $response['getTrace'] = $e->getTrace();
            $response['errors'] = $e->getMessage();
            $status = 500;
        } catch(ModelNotFoundException $e){
            $response['errors'] = 'Not found!';
            $status = 404;
        }

        return response()->json($response, $status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usage $usage)
    {
        $response = [];
        $status = 200;
        try {
            $usage->delete();
            $response['message'] = "Usage Deleted";
            $response['success'] = true;
        } catch (\Exception $e) {
            if(config('app.env') != 'production')
                $response['getTrace'] = $e->getTrace();
            $response['errors'] = $e->getMessage();
            $status = 500;
        } catch(ModelNotFoundException $e){
            $response['errors'] = 'Not found!';
            $status = 404;
        }
        
        return response()->json($response, $status);
    }
}
