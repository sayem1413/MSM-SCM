<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ColorStore;
use App\Http\Requests\ColorUpdate;
use App\Http\Resources\ColorCollection;
use App\Http\Resources\ColorResource;
use App\Models\Color;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\StoresImage;
use DB;

class ColorController extends Controller
{
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
                $colors = Color::orderBy('name', 'asc')->orderBy('updated_at', 'desc')->get();
            }
            else {
                $query = Color::whereNull('deleted_at');
                if( $request->has('order_by') ){
                    if( $request->order_by == 1 ){
                        $query = $query->orderBy('name', 'asc');
                    } else if( $request->order_by == 2 ){
                        $query = $query->orderBy('name', 'desc');
                    } else {
                        $query = $query->orderBy('created_at', 'desc');
                    }
                }
                $colors_all = $query->paginate($pageLength);
                $colors = (new ColorCollection( $colors_all ))->additional(['success' => true]);
            }
            $response = [
                'colors' => $colors,
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
    public function store(ColorStore $request)
    {
        $response = [];
        $status = 200;
        try {
            $color = Color::create([
                "name"       => $request->name,
                "hex_code"   => $request->hex_code
            ]);
            $response = [
                'data' => $color,
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
    public function show(Color $color, Request $request)
    {
        $response = [];
        $status = 200;
        try {
            $response["color"] = (new ColorResource($color))->additional(['success' => true]);
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
    public function update(ColorUpdate $request, Color $color)
    {
        $response = [];
        $status = 200;
        try {
            $color->update([
                "name"       => $request->name,
                "hex_code"   => $request->hex_code
            ]);
            $response["color"] = $color;
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
    public function destroy(Color $color)
    {
        $response = [];
        $status = 200;
        try {
            $color->delete();
            $response['message'] = "Color Deleted";
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
