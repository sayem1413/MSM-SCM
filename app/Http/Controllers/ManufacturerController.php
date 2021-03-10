<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manufacturer;
use App\Http\Requests\ManufacturerStore;
use App\Http\Requests\ManufacturerUpdate;
use App\Http\Resources\ManufacturerResource;
use App\Http\Resources\ManufacturerCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\StoresImage;
use DB;

class ManufacturerController extends Controller
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
                $all_manufacturers = Manufacturer::all();
            }
            else {
                $query = Manufacturer::whereNull('deleted_at');
                if( $request->has('order_by') ){
                    if( $request->order_by == 1 ){
                        $query = $query->orderBy('name', 'asc');
                    } else if( $request->order_by == 2 ){
                        $query = $query->orderBy('name', 'desc');
                    } else {
                        $query = $query->orderBy('created_at', 'desc');
                    }
                }
                $manufacturers = $query->paginate($pageLength);
                $all_manufacturers = (new ManufacturerCollection( $manufacturers ))->additional(['success' => true]);
            }
            $response = [
                'all_manufacturers' => $all_manufacturers,
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

    public function Search(ManufacturerSearch $request){
        $response = [];
        $status = 200;
        try {
            $searchedText = $request->search_text;
            // $manufacturers = Manufacturer::where('company_id', Auth::user()->company_id)->where('name', 'LIKE', '%'.$searchedText.'%')->get();
            $manufacturers = Manufacturer::where('name', 'LIKE', '%'.$searchedText.'%')->get();
            $response = [
                'data' => $manufacturers,
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
    public function store(ManufacturerStore $request)
    {
        $response = [];
        $status = 200;
        try {
            $manufacturer = Manufacturer::create([
                "name"          => $request->name,
                "description"   => $request->description,
                "active"        => $request->active,
            ]);
            $logo = $this->verifyAndStoreImage($request, 'logo_path', $request->name, "manufacturer");
            Manufacturer::where('id', $manufacturer->id)->update([
                "logo_path" => $logo,
            ]);
            $response = [
                'data' => $manufacturer,
                'success' => true
            ];
        } catch(\Exception $e){
            if(config('app.env') != 'production')
                $response['getTrace'] = $e->getTrace();
            $response['errors'] = $e->getMessage();
            $status = 500;
        }
        return response()->json($response, $status);
        // return $this->show($manufacturer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Manufacturer $manufacturer, Request $request)
    {
        $response = [];
        $status = 200;
        try {
            $response["manufacturer"] = (new ManufacturerResource($manufacturer))->additional(['success' => true]);
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
    public function update(ManufacturerUpdate $request, Manufacturer $manufacturer)
    {
        $response = [];
        $status = 200;
        try {
            $logo = $this->verifyAndStoreImage($request, 'logo_path', $request->name, "manufacturer", $manufacturer, $manufacturer->logo_path);
            $manufacturer->update([
                "name"          => $request->name,
                "logo_path"     => $logo,
                "description"   => $request->description,
                "active"        => $request->active,
            ]);
            $response["manufacturer"] = $manufacturer;
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
    public function destroy(Manufacturer $manufacturer)
    {
        $response = [];
        $status = 200;
        try {
            $manufacturerLogo = public_path( $manufacturer->logo_path );
            if( file_exists($manufacturerLogo) && $manufacturer->logo_path != '' ){
                unlink($manufacturerLogo);
            }
            $manufacturer->delete();
            $response['message'] = "Manufacturer Deleted";
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
