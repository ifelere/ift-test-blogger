<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('screens.blogs.index');
    }

   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (preg_match('/^\d+$/', $id)) {
            $blog = Blog::with(['publisher'])->findOrFail($id);
            return view('screens.blogs.show', ['blog' => $blog]);    
        }
        $blog = Blog::with(['publisher'])->where('slug', 'like', $id)->firstOrFail();
        return view('screens.blogs.show', ['blog' => $blog]);
    }

   
}
