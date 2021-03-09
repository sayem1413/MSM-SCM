<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enumerations\CategoryPosition;
use App\Http\Requests\CategoryStore;
use App\Http\Requests\CategoryUpdate;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\StoresImage;
use DB;
use App\Libraries\MultilevelCategory;

class CategoryController extends Controller
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
            $pageLength = isset($request->page_length) ? $request->page_length : 10;
            $categories = (new CategoryCollection(Category::paginate($pageLength)))->additional(['success' => true]);
            $response = [
                'categories' => $categories,
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

    public function getCategoryList(Request $request)
    {
        $response = [];
        $status = 200;
        try {
            // $all_categories = MultilevelCategory::get(false, isset($request->id) ? $request->id : 0 );
            $categories = Category::whereNull('deleted_at')->orderBy('_lft', 'asc')->orderBy('_rgt', 'asc');
            if ($request->has('id') && isset($request->id) && $request->id != 0) {
                $reduceCategory = Category::findOrFail($request->id);
                $categories = $categories->where('id', '!=', $request->id);
                $categories = $categories->where(function ($query1) use ($reduceCategory) {
                    $query1->Where('_lft', '<', $reduceCategory->_lft)
                           ->orWhere('_lft', '>', $reduceCategory->_rgt);
                });
                
            } 
            
            $categories = $categories->get();
            foreach($categories as $category){
                $category->label = $category->name;
            }
            $all_categories = $categories->toTree();
            $response = [
                'all_categories' => $all_categories,
                'success' => true
            ];
        } catch(\Exception $e){
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
    public function store(CategoryStore $request)
    {
        $response = [];
        $status = 200;
        try {
            $request->parent_id = $request->parent_id ? (int)$request->parent_id : 0;
            $data = [
                "name"              => $request->name,
                "description"       => $request->description,
                "active"            => $request->active,
            ];
            $category = Category::create($data);
            $image = $this->verifyAndStoreImage($request, 'image_path', $request->name, "category");
            Category::where('id', $category->id)->update([
                "image_path" => $image,
            ]);
            if($request->parent_id != 0){
                $parent = Category::findOrFail($request->parent_id);
                $category->appendToNode($parent)->save();
            }
            $response["category"] = $category;
        } catch (\Exception $e) {
            if(config('app.env') != 'production')
                $response['getTrace'] = $e->getTrace();
            $response['error'] = $e->getMessage();
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
    public function show( Category $category, Request $request )
    {
        $response = [];
        $status = 200;
        try {
            $response["category"] = (new CategoryResource($category))->additional(['success' => true]);
        } catch (\Exception $e) {
            if(config('app.env') != 'production')
                $response['getTrace'] = $e->getTrace();
            $response['error'] = $e->getMessage();
            $status = 500;
        } catch(ModelNotFoundException $e){
            $response['errors'] = 'Not found!';
            $status = 404;
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
    public function update(CategoryUpdate $request, Category $category)
    {
        $response = [];
        $status = 200;
        try {
            if ($request->parent_id && is_null(Category::findOrFail($request->parent_id))){
                $response['error'] = "parent id does not exist";
                $response['success'] = false;
                $status = 404;
            } else {
                $image = $this->verifyAndStoreImage($request, 'image_path', $request->name, "category", $category, $category->image_path);
                $category->update([
                    "name"              => $request->name,
                    "description"       => $request->description,
                    "parent_id"         => $request->parent_id,
                    "image_path"        => $image,
                    "active"            => $request->active,
                ]);
                $response["category"] = $category;
            }
        } catch (\Exception $e) {
            if(config('app.env') != 'production')
                $response['getTrace'] = $e->getTrace();
            $response['error'] = $e->getMessage();
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
    public function destroy( Category $category )
    {
        $response = [];
        $status = 200;
        try {
            Category::where('parent_id', $category->id)->update([
                'parent_id' => $category->parent_id
            ]);
            $categoryImage = public_path( $category->image_path );
            if( file_exists($categoryImage) && $category->image_path != '' ){
                unlink($categoryImage);
            }
            $category->delete();
            $response['message'] = "Category Deleted";
            $response['success'] = true;
        } catch (\Exception $e) {
            if(config('app.env') != 'production')
                $response['getTrace'] = $e->getTrace();
            $response['error'] = $e->getMessage();
            $status = 500;
        } catch(ModelNotFoundException $e){
            $response['errors'] = 'Not found!';
            $status = 404;
        }
        
        return response()->json($response, $status);
    }

    public function updatePatentCategory ( Request $request )
    {
        $response = [];
        $status = 200;
        try {
            $parentCategories = $request->parentCategories;
            $neighborCategory = Category::where('id', $parentCategories[0]['id'])->first();
            $initialNeighborCategoryId = $parentCategories[0]['id'];
            foreach( $parentCategories as $parentCategory )
            {
                /* Category::where('id', $parentCategory['id'])->update([
                    'parent_id' => null,
                    // 'position' => $parentCategory['position'],
                ]); */
                $parentCategoryN = Category::where('id', $parentCategory['id'])->first();
                if( $initialNeighborCategoryId != $parentCategoryN->id ){
                    $parentCategoryN->afterNode($neighborCategory)->save();
                }
                $neighborCategory = $parentCategoryN;
            }
            Category::fixTree();
            $response["message"] = 'Parent Category Position Updated Successfully!';
        } catch (\Exception $e) {
            if(config('app.env') != 'production')
                $response['getTrace'] = $e->getTrace();
            $response['error'] = $e->getMessage();
            $status = 500;
        }

        return response()->json($response, $status);
    }

    public function updateChildCategory( Request $request, $id )
    {
        $response = [];
        $status = 200;
        try {
            $parent = Category::findOrFail($id);
            $categories = Category::get();
            foreach($categories as $category){
                $categoryId = $category->id;
                foreach($request->childCategories as $childCategory){
                    if($childCategory['id'] == $categoryId ){
                        /* $category->update([
                            // 'position' => $childCategory['position'],
                            'parent_id' => $id,
                        ]); */
                        $category->appendToNode($parent)->save();
                    }
                }
            }
            Category::fixTree();
            $response["message"] = 'Child Category Position Updated Successfully!';
        } catch (\Exception $e) {
            if(config('app.env') != 'production')
                $response['getTrace'] = $e->getTrace();
            $response['error'] = $e->getMessage();
            $status = 500;
        }

        return response()->json($response, $status);
    }
}
