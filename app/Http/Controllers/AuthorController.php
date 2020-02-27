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
    
    // public function addFriend(User $user, $friendId)
    // {
    // //    return $friend = $user->friends()->get();
    //     $friend = $user->friends()->where('friendId', $friendId)->where('isConfirmed', false)->get();
    //     if (! $friend->isEmpty()) {
    //         return response()->json(['message' => 'This person is already your friend', 'data' => $friend]);
    //     }
    //     $user->friends()->attach($friendId, ['isConfirmed' => true]);
    //     return ['message' => 'Friend added', 'fri' => $friendId];
    // }

    public function sendFriendRequest(User $user, $friendId)
    {
        $friend = $user->friends()->where('friendId', $friendId)->where('isConfirmed', false)->get();
        if (! $friend->isEmpty()) {
            return response()->json(['message' => 'This person is already your friend', 'data' => $friend]);
        }
        $user->friends()->attach($friendId, ['isConfirmed' => false]);
        return ['message' => 'Friend request sent', 'fri' => $friendId];
    }

    public function listFriends(User $user)
    {
        if (request()->query('filter') === 'unconfirmed') {
           return $friendsUserAccepted = $user->myfriends()->where('isConfirmed', false)->get();
        }
       $friendsUserRequested = $user->friends()->where('isConfirmed', true)->get();
       $friendsUserAccepted = $user->myfriends()->where('isConfirmed', true)->get();
       return $friendsUserAccepted->merge($friendsUserRequested);
    }


    public function acceptFriendRequest(User $user, $friendId)
    {
       $friend = $user->myfriends()->where('friendId', $user->id)->where('userId', $friendId)->updateExistingPivot($friendId, ['isConfirmed' => true]);

       if ($friend) return response()->json(['message' => 'Friend request accepted']);
        return response()->json(['message' => 'No friend request from this user']);
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
