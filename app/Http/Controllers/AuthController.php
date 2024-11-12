<?php

namespace App\Http\Controllers;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Post;
use App\Models\User;
use App\Mail\SendSmsToMail;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function index(){
        if (auth()->check()) {
            $followingId = auth()->user()->following()->pluck('users.id');
            $posts = Post::whereIn('user_id', $followingId)->latest()->get();
        } else {
            $posts = Post::latest()->get();
        }
        return view('welcome', compact('posts'));
    }
    public function registerForm()
    {
        return view('auth.register');
    }
    public function register(RegisterRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->verification_token = uniqid();
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $image = $request->file('image');
        $imagePath = time() . '.' . $image->getClientOriginalExtension();
        $uploadedImage = $image->storeAs('uploads/' , $imagePath , 'public');
        $user->image()->create([
            'path' => $uploadedImage
        ]);
        Mail::to($user->email)->send(new SendSmsToMail($user));
        return redirect()->route('loginForm');
    }
    public function loginForm(){
        return view('auth.login');
    }
    public function login(LoginRequest $request){
        $user = User::where('email', $request->email)->first();
        if($user && Hash::check($request->password,$user->password)){
            if($user->email_verified_at !== null){
                Auth::attempt([
                   'email' => $request->email,
                   'password' => $request->password
                ]);
                return redirect()->route('home');
            }
            else{
                return back();
            }
        }
    }
    public function verify(Request $request){
        $user = User::where('verification_token', $request->token)->first();

        if(!$user){
            abort(404);
        }
        $user->email_verified_at = now();
        $user->save();
        return redirect()->route('loginForm');
    }
    public function editProfile()
    {
        return view('auth.edit-profile');
    }
    public function update(UpdateProfileRequest  $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->new_password && Hash::check($request->old_password,$user->password))){
            $user->password = bcrypt($request->new_password);
        }
        $user->save();

        if($request->hasFile('image')){
            if($user->image && $user->image->path){
                @unlink(storage_path('app/public/' . $user->image->path));
                $user->image()->delete();
            }

            $image = $request->file('image');
            $imagePath = time() . '.' . $image->getClientOriginalExtension();
            $uploadedImage = $image->storeAs('uploads/' , $imagePath, 'public');
            $user->image()->create([
                'path' => $uploadedImage
            ]);
        }
        return redirect()->route('home');
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('loginForm');
    }
    public function my_profile(){
        $posts = Auth::user()->posts()->paginate(4);
        return view('auth.my-profile', compact('posts'));
    }
}
