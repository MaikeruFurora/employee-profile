<?php

namespace App\Http\Controllers;

use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImagesController extends Controller
{
    public function store(Request $request){
        $files=$request->file('image');
        foreach ($files as $key => $file) {
            $imageName = time().'_'.$file->getClientOriginalName();
            $file->move(\public_path("/img"),$imageName);
            Images::create([
                'employee_id'=>$request->employee_id,
                'images'=>$imageName,
            ]);
        }
    }

    public function list($id){
        return response()->json(
            Images::where('employee_id',$id)->get()
        );
    }

    public function destroy(Images $images){
        if (File::exists("img/".$images->images)) {
            File::delete("img/".$images->images);
        }
        return $images->delete();
    }
}
