<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of blogs
     * @return \illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $blogs
        ];
    }

    /**
     * show the form for creating a new resource
     * @return \illuminate\Http\Reponse
     */
    public function create(){
        //
    }

    /**
     * add a new resource to blogs table
     * @param \illuminate\Http\Request
     * @return \illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //echo $request; die;
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $blog = Blog::create($request->all());
       
        return [
            "status" => 1,
            "data" => $blog
        ];
    }

    /**
    * Display the specified resource.
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json($blog);
    }

    /**
    * Update the specified resource in storage.
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
        'title' => 'required|max:255',
        'body' => 'required'
        ]);

        $blog->title = $request->get('title');
        $blog->body = $request->get('body');

        $blog->save();

        return response()->json($blog);
    }
 

}
