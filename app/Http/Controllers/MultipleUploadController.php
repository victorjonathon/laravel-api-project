<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class MultipleUploadController extends Controller
{
    /**
     * multiple file upload
     * @param \illuminate\Http\Request
     * @return \illuminate\Http\Response
     */

     public function store(Request $request)
     {
        if(!$request->hasFile('fileName')) {
            return response()->json(['Upload file not found'], 400);
        }

        $allowedfileExtension=['jpg','png'];
        $files = $request->file('fileName');
        $errors = [];
 
        foreach ($request->fileName as $file) {      
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension,$allowedfileExtension);
        }  
       
        if($check) {
            foreach($request->fileName as $imageFile) {
    
                $path = $imageFile->store('public/images');
                
                //store image file into directory and db
                $image = new Image();
                $image->title = $imageFile->getClientOriginalName();
                $image->path = $path;
                $image->save();
            }
        } else {
            return response()->json(['Isnvalid file format'], 422);
        }

        return response()->json(['File uploaded'], 200);
        
    }
}
