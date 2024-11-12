@extends('layouts.app')
@section('title', 'User Profile')
@section('content')
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <div class="flex flex-col sm:flex-row items-center mb-4">
                    <img src="{{asset('/storage' . '/' . $user->image->path)}}" alt="User Avatar" class="w-20 h-20 rounded-full mr-4 mb-4 sm:mb-0">
                    <div class="text-center sm:text-left">
                        <h1 class="text-2xl font-bold">{{$user->name}}</h1>
                        <p class="text-gray-600">{{$user->username}}</p>
                    </div>

                    <!-- Follow/Unfollow Button and Edit Profile -->
                    @if(Auth::id() != $user->id)
                    <div class="mt-4 sm:mt-0 sm:ml-auto">
                        <!-- Conditional Follow/Unfollow -->
                        <!-- Assuming you have some backend logic to check if the user is already followed -->
                        @if (Auth::check() && !Auth::user()->isFollowing($user))
                        <form action="{{route('follow', $user->id)}}" method="POST">
                            @csrf

                            <button id="followButton"
                                class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Follow
                            </button>
                        </form>
                        @else
                        <form action="{{route('unfollow', $user->id)}}" method="POST">
                            @csrf
                        <button id="followButton"
                            class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Unfollow
                        </button>
                        </form>
                        @endif
                    </div>
                    @else
                    <div class="mt-4 sm:mt-0 sm:ml-auto">
                        <!-- Edit Profile button for current user's profile -->
                        <!-- Assuming you will check if this is the current user's profile -->
                        <a href="{{route('auth.edit')}}"
                            class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                            Edit Profile
                        </a>
                    </div>
                    @endif
                </div>

                <div class="flex flex-wrap justify-center sm:justify-start space-x-4">
                    <span class="font-semibold">{{'Followers ' . $user->followers()->count()}}</span>
                    <span class="font-semibold">{{'Following ' . $user->following()->count()}}</span>
                    <span class="font-semibold">{{'Posts ' . $user->posts()->count()}}</span>
                </div>
            </div>


            <h2 class="text-2xl font-bold mb-4">User's Posts</h2>
            @foreach ($user->posts as $post)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <img src="{{asset('/storage' . '/' . $post->image->path)}}" alt="Post Image"
                            class="w-full h-48 object-cover rounded-lg mb-4">
                        <h3 class="text-xl font-bold mb-2">{{$post->title}}</h3>
                        <p class="text-gray-700 mb-4">{{$post->description}}</p>
                        <a href="{{route('posts.show', $post->id)}}" class="text-indigo-600 hover:text-indigo-800">Read More</a>
                    </div>

                </div>
            @endforeach
        </div>
    </main>
@endsection
