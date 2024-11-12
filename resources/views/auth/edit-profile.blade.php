@extends('layouts.app')
@section('title', 'Profile Edit')
@section('content')
<main class="flex-grow container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Edit Profile</h1>
        <form action="{{route('update', auth()->user()->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                @error('name')
                    {{$message}}
                @enderror
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{auth()->user()->name}}">
            </div>
            <div class="mb-4">
                @error('username')
                    {{$message}}
                @enderror
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{auth()->user()->username}}">
            </div>
            <div class="mb-4">
                @error('email')
                    {{$message}}
                @enderror
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="text" id="email" name="email" rows="4" value="{{auth()->user()->email}}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="mb-4">
                @error('avatar')
                    {{$message}}
                @enderror
                <label for="avatar" class="block text-sm font-medium text-gray-700">Avatar</label>
                <input type="file" id="avatar" name="avatar" accept="image/*"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <p class="mt-2 text-sm text-gray-500">Current Avatar: {{auth()->user()->image->path}}</p>
            </div>
            <img src="{{asset('/storage' . '/' . auth()->user()->image->path)}}" width="150px" alt="User's avatar">
            <hr class="my-6">
            <div class="flex items-center space-x-4">
                <div class="mb-4 w-1/2">
                    @error('old_password')
                        {{$message}}
                    @enderror
                    <label for="old_password" class="block text-sm font-medium text-gray-700">Old Password</label>
                    <input type="password" id="old_password" name="old_password"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="mb-4 w-1/2">
                    @error('new_password')
                        {{$message}}
                    @enderror
                    <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" id="new_password" name="new_password"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update
                Profile</button>
        </form>
        <a href="{{route('my_profile')}}" class="text-indigo-600 hover:text-indigo-800 block mt-4 text-center">Back to
            Profile</a>
    </div>
</main>
@endsection
