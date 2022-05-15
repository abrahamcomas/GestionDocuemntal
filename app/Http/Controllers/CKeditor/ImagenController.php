<?php

namespace App\Http\Controllers\CKeditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagenController extends Controller
{
    public function upload(Request $request){ 


    //$url = Storage::put('CKeditorImagenes', $request->file('upload'));
    $url = Storage::disk('CKeditorImagenes')->put('', $request->file('upload'));

    return response()->json([
        'url' => "CKeditorImagenes/".$url
        
    ]);



    }
}
 