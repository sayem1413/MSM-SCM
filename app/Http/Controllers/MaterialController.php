<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Http\Requests\MaterialStore;
use App\Http\Requests\MaterialUpdate;
use App\Http\Resources\MaterialResource;
use App\Http\Resources\MaterialCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\StoresImage;
use DB;

class MaterialController extends Controller
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
                $materials = Material::all();
            }
            else {
                $query = Material::whereNull('deleted_at');
                if( $request->has('order_by') ){
                    if( $request->order_by == 1 ){
                        $query = $query->orderBy('name', 'asc');
                    } else if( $request->order_by == 2 ){
                        $query = $query->orderBy('name', 'desc');
                    } else {
                        $query = $query->orderBy('created_at', 'desc');
                    }
                }
                $materials_all = $query->paginate($pageLength);
                $materials = (new MaterialCollection( $materials_all ))->additional(['success' => true]);
            }
            $response = [
                'materials' => $materials,
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
    public function store(MaterialStore $request)
    {
        $response = [];
        $status = 200;
        try {
            $material = Material::create([
                "name"          => $request->name,
                "description"   => $request->description
            ]);
            $response = [
                'data' => $material,
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
    public function show(Material $material, Request $request )
    {
        $response = [];
        $status = 200;
        try {
            $response["material"] = (new MaterialResource($material))->additional(['success' => true]);
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
    public function update(MaterialUpdate $request, Material $material)
    {
        $response = [];
        $status = 200;
        try {
            $material->update([
                "name"          => $request->name,
                "description"   => $request->description
            ]);
            $response["material"] = $material;
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
    public function destroy(Material $material)
    {
        $response = [];
        $status = 200;
        try {
            $material->delete();
            $response['message'] = "Material Deleted";
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
