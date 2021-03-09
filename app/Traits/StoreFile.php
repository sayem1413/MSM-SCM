<?php

namespace App\Traits;

use Illuminate\Http\Request;


trait StoreFile{

    use GeneratesCodes;
    /**
     * Does very basic file validity checking and stores it. Redirects back if somethings wrong.
     * @Notice: This is not an alternative to the model validation for this field.
     *
     * @param Request $request
     * @return $this|false|string
     */
    public function verifyAndStoreFile( Request $request, $fieldname = 'file', $modifier='' , $directory = 'unknown' , $model = null, $filename = null )
    {
        if( $request->hasFile( $fieldname)) {
            if (!$request->file($fieldname)->isValid()) {
                return redirect()->back()->withInput();
            }

            if($model != null && $filename != null){
                $existence_file = public_path($filename);
                if(file_exists($existence_file)) {
                    unlink($existence_file);
                }
            }

            $file_name = $modifier."_".$this->generateRandomUniqueId($modifier);
            $file_name = $this->slug($file_name,'');
            $file_name = $file_name.".".$request->file($fieldname)->getClientOriginalExtension();
            $file = $request->file($fieldname)->move('file/' . $directory. '/', $file_name);
            
            return $file->getPathName();
        }
        return $model ? $model->$fieldname : null;
    }
}