<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewFollowerNotification;

class FollowController extends Controller
{
    public function follow($id)
    {
        $userToFollow = User::findOrFail($id);
        Auth::user()->following()->attach($userToFollow->id);
        $userToFollow->notify(new NewFollowerNotification($userToFollow));
        return redirect()->back();
    }
    public function unfollow($id)
    {
        $userToUnfollow = User::findOrFail($id);
        Auth::user()->following()->detach($userToUnfollow->id);
        return redirect()->back();
    }
}
