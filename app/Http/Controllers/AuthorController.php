<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\sendMessage;
use App\Author;
use App\User;
use Illuminate\Notifications\Notifiable;
use Mail;

class AuthorController extends Controller
{
    use Notifiable;
    public $email_address = 'sinmiloluwasunday@yahoo.com';

    public function index()
    {
        return User::all();
    }
    public function show($id)
    {
        $user = User::find($id);

        // Mail::send('welcome', [], function($message){
        //     $message->to('sinmiloluwasunday@yahoo.com', 'Main')->subject('hello there');
        //     $message->from('hello@yahoo.com', 'mailinator');
        // });

       return $this->notify(new sendMessage());
        // find where user has 2 likes

        // $user = User::find($id)->posts->where('like', '>', 1)->values();
        // $user = User::has('posts','>=', 2)->get();
        return response()->json($user);
    }
    public function routeNotificationForMail($notification)
    {
        return $this->email_address;
    }
}
