<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    
    public function storeTmpFile(Request $request){
        $path = storage_path('app/tmp/uploads');
        

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        
        $file = $request->file('files')[0];
        $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
            'src' => "/storage/tmp/uploads/" . $name,
        ]);
    }

    public function removeTmpFile(Request $request){
        Storage::delete('/tmp/uploads/' . $request->name);
        return response()->json("Le fichier " . $request->name . " a bien ete supprime.");
    }
}
