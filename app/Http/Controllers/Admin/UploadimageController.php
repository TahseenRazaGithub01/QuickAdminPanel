<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UploadimageController extends Controller
{
    public function upload(Request $request){

        try{

            if($request->hasFile('upload')) {
                $filenamewithextension = $request->file('upload')->getClientOriginalName();
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $extension = $request->file('upload')->getClientOriginalExtension();
                $filenametostore = $filename.'_'.uniqid().'.'.$extension;

                if (\App::environment('production')) {

                    //Get Uploaded File
                    $file = $request->file('upload');
                    $filePath = 'uploads/' . $filenametostore;

                    //Set Directory
                    Storage::disk('s3')->put($filePath, file_get_contents($file),[
                        'visibility' => 'public'
                    ]);
                    $url = 'https://' . env('AWS_BUCKET') . '.s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/';
                    $url = $url  . $filePath;

                } else {
                    $request->file('upload')->storeAs('public/uploads', $filenametostore);
                    $url = asset('storage/uploads/'.$filenametostore);
                }

                $CKEditorFuncNum = $request->input('CKEditorFuncNum');
                $msg = 'Image successfully uploaded';
                $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                @header('Content-type: text/html; charset=utf-8');
                //echo $re;
                return $re;
            }

        }catch(\Exception $e){
            dd($e);
        }

    }
}
