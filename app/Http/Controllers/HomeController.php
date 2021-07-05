<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['upload', 'download']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function upload()
    {
        return view('upload_form');
    }

    public function download($fileName)
    {
        return response()->download(public_path("uploads/$fileName"));

        //if (!\Storage::disk('local')->exists("uploads/images/$fileName"))
        //{
         //   return response()->json(['message' => 'File not found']);
       // }
        //eğer dosya yoksa hata mesajı için kullanilblr

        //return \Storage::download("uploads/images/$fileName");
        //return \Storage::disk('local')->download("uploads/images/$fileName");
        //ikiside aynı. storage klasörü içindeki app altındaki uploads/images altındaki dosyları indirmk için

        //return \Storage::disk('public')->download($fileName);
        //storage klasörü içindeki app altındaki public altındaki dosyları indirmk için
    }
}
