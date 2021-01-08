<?php

namespace Lockminds\Teams\Http\Controllers;

use App\Http\Controllers\Controller as MyAnonymousController;
use Illuminate\Http\Request;

class MessagingController extends MyAnonymousController
{

    public function sendFile(Request $request){
            $file = $request->file('file');
            $file_name = 'worknasi_file_'.time() . '.' .$file->extension();

            //here you can define any directory name whatever you want, if dir is not exist it will created automatically.
            $pathLine =  $file->storeAs('chats', $file_name, 'public');

            $path = "https://nasi.lockminds.com/storage/$pathLine";

            return response()->json(['filePath' => $path, 'fileName' => $file_name, 'fileExt' =>$file->extension()]);
    }

}
