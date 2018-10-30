<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
            return $post->orderBy('id', 'DESC')->with('user')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'body' => ['required', 'min:5'],
        ]);
        $request->userId = $request->userId ? $request->userId : 1;
        // return $request->userId;
        $post = Post::create($request->all());
        $post->user = $post->user;
        return response()->json(['message'=>'successful', 'data' => $post], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $postId)
    {
        // return $postId;
        // $postToSend = Post::find($postId->id)->user;
        $postId->user = $postId->user;
        return response()->json(['data' => $postId], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $postId)
    {
        request()->validate(
            [
                'body' => ['required', 'min:5'],
            ]
            );
        // $this->validate($request,
        //     [
        //         'body' => ['required']
        // ]);
        $postId->update($request->all());

        // $singlePost->body = ($request->body) ? $request->body: '44444';
    //    $singlePost2 = Post::find($singlePost);
    return response()->json(['message'=>'Post updated successfully', 'data' => $postId], 200);

        //  return  $singlePost->fill(['body' => $request->body]);
        // dd($singlePost->all()[0]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $postId)
    {
        $postId->delete();
        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}
