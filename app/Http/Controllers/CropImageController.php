<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
class CropImageController extends Controller
{

    public function index()
    {
        return view('crop-image-upload');
    }

    public function uploadCropImage(Request $request)
    {
        $folderPath = public_path('upload/');

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $imageName = uniqid() . '.png';

        $imageFullPath = $folderPath.$imageName;

        file_put_contents($imageFullPath, $image_base64);

         $saveFile = User::find(auth()->user()->id);
         $saveFile->img = $imageName;
         $saveFile->save();
   
        return response()->json(['success'=>'Crop Image Uploaded Successfully']);
    }
}