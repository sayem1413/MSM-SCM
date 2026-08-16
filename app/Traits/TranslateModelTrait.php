<?php
namespace App\Traits;

use DB;
use Illuminate\Database\Eloquent\Model;

trait TranslateModelTrait 
{
    private $actualTableName;

    private function setTableName()
    {
        if(!$this->actualTableName){
            $this->actualTableName = $this->getTable();
        }
    }

    //handle insert

    private function resetTableName()
    {
        $this->setTable($this->actualTableName);
    }

    //we don't need to overwrite save, we can write a static function called savetranslation
    public function saveTranslation($id, $data, $language)
    {
        $this->setTableName();
        $this->setTable($this->translationTableName);

        $item = $this->where($this->translationForeighnKey, $id)->where('locale', $language )->first();
        if(!$item){
            $item = new self();
            $item->setTable($this->translationTableName);
        }

        foreach($data as $column=>$value){
            $item->{$column} = $value;
        }
        $item->locale = $language;
        $item->{$this->translationForeighnKey} = $id;
        $item->save();
        $this->resetTableName();
        return $item;
    }

    //need to overwrite get
    public function getTranslate($language = null, $condition = false, $conditionArr = [], $conditionInColumn = false,
            $conditionInArr = [], $orderByColumn = false, $orderByAD = false, $inRandomOrder = false, $limit = false, $withTrashed = false){
        if($language==null){
            $language = app()->getLocale();
        }
        $this->setTableName();

        if($language=='lt'){
            if( $condition ){
                $collection = $this->whereNull('deleted_at');
                if( count($conditionArr) > 0 ){
                    $collection = $collection->where($conditionArr);
                }
                if( $conditionInColumn && count($conditionInArr) > 0 ){
                    $collection = $collection->whereIn($conditionInColumn, $conditionInArr);
                }
                if($orderByColumn && $orderByAD){
                    $collection = $collection->orderBy($orderByColumn , $orderByAD);
                }
                if( $inRandomOrder ){
                    $collection = $collection->inRandomOrder();
                }
                if( $limit ){
                    $collection = $collection->limit($limit);
                }
                if( $withTrashed ){
                    $collection = $collection->withTrashed();
                }
                return $collection->get();
            } else {
                return $this->get();
            }
        }
        if( $condition ){
            $query = $this->whereNull('deleted_at');
            if( count($conditionArr) > 0 ){
                $query = $query->where($conditionArr);
            }
            if( $conditionInColumn && count($conditionInArr) > 0 ){
                $query = $query->whereIn($conditionInColumn, $conditionInArr);
            }
            if($orderByColumn && $orderByAD){
                $query = $query->orderBy($orderByColumn , $orderByAD);
            }
            if( $inRandomOrder ){
                $query = $query->inRandomOrder();
            }
            if( $limit ){
                $query = $query->limit($limit);
            }
            if( $withTrashed ){
                $query = $query->withTrashed();
            }
            $collection = $query->get();
        } else {
            $collection = $this->get();
        }
        
        if($collection->count()<=0){
            return $collection;
        }
        $collectionIdArr = [];
        foreach( $collection as $anItem ){
            $collectionIdArr[] = $anItem->id;
        }
        $translationCollection = DB::table($this->translationTableName)
                                    ->whereIn($this->translationForeighnKey, $collectionIdArr )
                                    ->where('locale', $language )
                                    ->get();
        $translationForeighnKey = $this->translationForeighnKey;
        foreach( $collection as $anItem ){
            $anItemId = $anItem->id;
            $translationItem = $translationCollection->filter(function($aTranslationItem) use($translationForeighnKey, $anItem){
                return ($aTranslationItem->$translationForeighnKey == $anItem->id);
            })->first();

            if($translationItem){
                foreach( $translationItem as $anAttribute=>$value ){
                    if($anAttribute!='id' && $anAttribute!=$this->translationForeighnKey ){
                        $anItem->$anAttribute = $value;
                    }
                }
            }
            $anItem->id = $anItemId;
        }
        return $collection;
    }

    //need to overwrite first
    public function firstTranslate($id, $language=null)
    {
        if($language==null){
            $language = app()->getLocale();
        }
        
        $this->setTableName();
        if($language=='lt'){
            return $this->where('id', $id)->first();
        }
        $item = $this->where('id', $id)->first();
        if(!$item){
            return;
        }
        $translationItem = DB::table($this->translationTableName)
                                ->where($this->translationForeighnKey, $item->id )
                                ->where('locale', $language )
                                ->first();
                                // dd($item);
        if($translationItem){
            foreach( $translationItem as $anAttribute=>$value ){
                $item->$anAttribute = $value;
            }
            $item->id = $id;
            return $item;
        }
        return $item;
    }

    public function getCategoryTreeTranslated($language)
    {
        if($language==null){
            $language = app()->getLocale();
        }
        
        $this->setTableName();
        if($language=='lt'){
            return $this->where('active', '=', 1)->orderBy('_rgt', 'asc')->orderBy('_lft', 'asc')->get()->toTree();
        }
        //put condition here
        $categoryList = $this->where('active', '=', 1)->orderBy('_rgt', 'asc')->orderBy('_lft', 'asc')->get();

        $categoryIdArr = [];
        foreach( $categoryList as $anItem ){
            $categoryIdArr[] = $anItem->id;
        }
        $translationCollection = DB::table($this->translationTableName)
                                    ->whereIn($this->translationForeighnKey, $categoryIdArr )
                                    // ->where('locale', 'like', '%' . $language . '%' )
                                    ->where('locale', $language )
                                    ->get();
        $translationForeighnKey = $this->translationForeighnKey;
        foreach( $categoryList as $anItem ){
            $translationItem = $translationCollection->filter(function($aTranslationItem) use($translationForeighnKey, $anItem){
                return ($aTranslationItem->$translationForeighnKey==$anItem->id);
            })->first();

            if($translationItem){
                foreach( $translationItem as $anAttribute=>$value ){
                    if($anAttribute!='id' && $anAttribute!=$this->translationForeighnKey ){
                        $anItem->$anAttribute = $value;
                    }
                }
            }
        }
        return $categoryList->toTree();
    }
}

?>