<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Author;

class AuthorController extends Controller
{
    public function show($id)
    {
        $user = Author::find($id)->posts->where('like', 2);
        // $user = Author::has('posts','>=', 2)->get();
        return $user;
    }
}
