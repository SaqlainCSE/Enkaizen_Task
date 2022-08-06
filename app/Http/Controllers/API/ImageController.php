<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller 
{
    public function images($id)
    {

        $Images = Image::where('user_id',$id)->get();

        if($Images)
        {
            return response()->json([
                'success' => true,
                'message' => 'Image found',
                'data' => $Images
            ],200);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Image not found',
                'data' => $Images
            ],404);
        }
    }

    public function create(Request $request)
    {
        $Image = new Image();

        $image=$request->file('photo');
        if($image)
        {
            $image_name=time();
            $ext=strtolower($image->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='photo/';
            $image_url=$upload_path.$image_full_name;
            $success=$image->move($upload_path,$image_full_name);
            if($success)
            {
                $Image->photo=$image_url;
            }
        }

        $Image->save();

        return response()->json([
            'success' => true,
            'message' => 'Image Add Successfully',
            'data' => $Image
        ],201);
    }

    public function delete($id)
    {
        $Image_delete = Image::where('id',$id)->first();

        if (!$Image_delete)
        {
            return response()->json([
                'success' => false,
                'message' => 'Image not found',
                'data' => $Image_delete
            ],404);
        }

        @unlink($Image_delete->photo);

        $Image_delete->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image Successfully Deleted',
            'data' => $Image_delete
        ],200);
    }

    function getFile($filename)
    {
        $path = storage_path('app/public/'.$filename);
        return response()->download($path);
    }

}
