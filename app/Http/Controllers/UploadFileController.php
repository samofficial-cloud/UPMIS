<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\File;

class UploadFileController extends Controller {
   public function index() {
      return view('uploadfile');
   }
   public function showUploadFile(Request $request) {
      $file = $request->file('image');
   
      //Display File Name
      echo 'File Name: '.$file->getClientOriginalName();
      echo '<br>';
   
      //Display File Extension
      echo 'File Extension: '.$file->getClientOriginalExtension();
      echo '<br>';
   
      //Display File Real Path
      echo 'File Real Path: '.$file->getRealPath();
      echo '<br>';
   
      //Display File Size
      echo 'File Size: '.$file->getSize();
      echo '<br>';
   
      //Display File Mime Type
      echo 'File Mime Type: '.$file->getMimeType();
   
      //Move Uploaded File
      $destinationPath = 'uploads';
      $file->move($destinationPath,$file->getClientOriginalName());
   }

   public function create()
    {
        return view('create');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $this->validate($request, [
                'filenames' => 'required',
                'filenames.*' => 'mimes:doc,pdf,docx,zip'
        ]);


        if($request->hasfile('filenames'))
         {
            foreach($request->file('filenames') as $file)
            {
                $name = $file->getClientOriginalName().'.'.$file->extension();
                $file->move(public_path().'/uploads/', $name);  
                $data[] = $name;  
            }
         }


         $file= new File();
         $file->filenames=json_encode($data);
         $file->save();


        return back()->with('success', 'Data Your files has been successfully added');
    }
}