<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Storage;
use App\Models\File;
use Str;

class FileController extends Controller
{
    protected $dropbox;

    public function __construct(){
        $this->dropbox = Storage::disk("dropbox")->getDriver()->getAdapter()->getClient();
    }

    public function index(){
        return File::all();
    }

    public function create(){
        return view('files.create');
    }

    public function store(Request $request){
        $nameArchivo = Str::random(50).".{$request->archivo->extension()}";
        $rutaArchivo = "archivos/{$nameArchivo}";
        $upload = Storage::put($rutaArchivo,fopen($request->file("archivo"),"r"));
        File::create(array(
            "name" => $nameArchivo,
            "public_url" => $rutaArchivo,
            "extension" => $request->archivo->extension(),
        ));
        return redirect()->route("files.index");
    }

    public function destroy($id){

    }

}
