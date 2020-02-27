<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use App\Post;
use App\Like;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Comment;
use App\Tag;
use JWTAuth;
// use Tymon\JWTAuth\Facades\JWTAuth;
class PostController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('jwt.auth', ['except' => '']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        // if ($allPost = Redis::get('posts')) {
        //     return json_decode($allPost);
        // }
        $postToSend = $post->orderBy('id', 'DESC')->with('user')->with('userLikes')->with('comments')->get();
        Redis::set('posts', $postToSend);
            return response()->json($postToSend, 200);
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
        $user = JWTAuth::parseToken()->authenticate();
        // return ($user);
        // $request->userId = $request->userId ? $request->userId : 1;
        
        $data = [
            'tags' => $request->input('tags'),
            'body' => $request->body,
            'userId' => $user->id
        ];
        $post = Post::create($data);
        dump($post);
        if($request->tags) Tag::create(['postId' => $post->id, 'value' => $request->tags]);
        $post->user = $post->user;
        $tag = $post->tags()->get(['value']);
        $post->tags = $tag[0]['value'];
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
      $postId->user;
      $postId->tags;
        return response()->json(['data' => $postId], 201);
    }

    public function comment(Post $postId)
    {
        Comment::create(['postId' => $postId->id, 'body' => request()->body, 'userId' => 2]);
        $postId->comments = $postId->comments;
        return response()->json(['message' => 'comment has been added!', 'data' => $postId]);
    }
    public function like(Post $postId)
    {
        // dd(Auth::user())
        $existingLike = Like::where('postId', '=', $postId->id)
        ->where('userId', 3);
        if($existingLike->get()->isEmpty()) {
            dump($postId->id);
            Like::create(['postId' => $postId->id, 'userId' => 3]);
            /* Mail::send('email', ['name' => $postId->user->name, 'likes' => $postId->likes], function ($message) use($postId) {
                $message->to($postId->user->email, $postId->user->name)->subject('Post2Me - You got new likes');
                $message->from('no-reply@post2me.com', 'Post2Me');
            }); */
        }
        else $existingLike->delete();
        // if(Like::where('postId', '=', $postId))
        // $newLike = Like::firstOrCreate(['postId' => $postId->id, 'userId' => 1]);
        // $postWith = Post::find($postId->id)->with('likes')->get();
        $postId->likes = $postId->likes()->count();
        $postId->userLikes = $postId->userLikes()->get(['name', 'email']);
        return response()->json(['message' => 'article liked!', 'data' => $postId]);
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
