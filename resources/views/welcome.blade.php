@extends('layouts.app')
@section('title','Home')
@section('content')

@if(!auth()->check())
    <!-- Main content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h2 class="text-2xl font-bold mb-4">Welcome to BlogSite!</h2>
            <p class="text-lg text-gray-500 mb-8">Please <a class="text-indigo-500 hover:text-indigo-700 underline"
                    href="{{route('login')}}">Log in</a> or <a class="text-indigo-500 hover:text-indigo-700 underline"
                    href="{{route('register')}}">Sign up</a> to view all posts.</p>
        </div>
    </main>
@else
    <!-- Main content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Followed Posts</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($posts as $post )
            <div class="bg-white p-6 rounded-lg shadow-md">
                <img src="{{asset('/storage' . '/' . $post->image->path)}}" alt="Post Image" class="w-full h-48 object-cover rounded-lg mb-4">
                <h2 class="text-xl font-bold mb-2">{{$post->title}}</h2>
                <p class="text-gray-700 mb-4">{{$post->description}}</p>
                    <p class="text-gray-700 mb-4">By <a href="{{route('user_profile', $post->user->username)}}"
                        class="text-indigo-600 hover:text-indigo-800">{{$post->user->name}}</a>
                    </p>
                    <a href="{{route('posts.show', $post->id)}}" class="text-indigo-600 hover:text-indigo-800">Read More</a>
                </div>
            @endforeach
            {{-- <div class="bg-white p-6 rounded-lg shadow-md">
                <img src="./images/post-image.png" alt="Post Image" class="w-full h-48 object-cover rounded-lg mb-4">
                <h2 class="text-xl font-bold mb-2">Post Title 2</h2>
                <p class="text-gray-700 mb-4">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat.</p>
                <p class="text-gray-700 mb-4">By <a href="./user-profile.html"
                        class="text-indigo-600 hover:text-indigo-800">Azizbek</a>
                </p>
                <a href="show-post.html" class="text-indigo-600 hover:text-indigo-800">Read More</a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <img src="./images/post-image.png" alt="Post Image" class="w-full h-48 object-cover rounded-lg mb-4">
                <h2 class="text-xl font-bold mb-2">Post Title 3</h2>
                <p class="text-gray-700 mb-4">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                    dolore eu fugiat nulla pariatur.</p>
                <p class="text-gray-700 mb-4">By <a href="./user-profile.html"
                        class="text-indigo-600 hover:text-indigo-800">Azizbek</a>
                </p>
                <a href="show-post.html" class="text-indigo-600 hover:text-indigo-800">Read More</a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <img src="./images/post-image.png" alt="Post Image" class="w-full h-48 object-cover rounded-lg mb-4">
                <h2 class="text-xl font-bold mb-2">Post Title 4</h2>
                <p class="text-gray-700 mb-4">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum.</p>
                <p class="text-gray-700 mb-4">By <a href="./user-profile.html"
                        class="text-indigo-600 hover:text-indigo-800">Azizbek</a>
                </p>
                <a href="show-post.html" class="text-indigo-600 hover:text-indigo-800">Read More</a>
            </div> --}}
        </div>
    </main>
     @endif
@endsection
