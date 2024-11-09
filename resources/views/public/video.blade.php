<?php
use App\Models\VideoContents;
use App\Models\Categories;
use Illuminate\Support\Facades\Config;
?>

<x-public-layout>
    <x-slot name="header">

        <form class="max-w-md mx-auto">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Mockups, Logos..." required />
                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>
        </form>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="block mt-6 text-xl text-gray-900">{{$video[VideoContents::FIELD_NAME]}}</h1>
                    <div class="flex justify-start items-start">
                        @foreach($categories as $category)
                            <a class="bg-origin-content px-1.5 py-0.5 mt-0 ml-0.25 mr-0 mb-0.25 bg-blue-200 rounded-lg " href="{{ route('getVideosByCategories', ['id' => $category[Categories::FIELD_ID]])}}">{{$category['name']}}</a>
                        @endforeach
                    </div>
                    <div class="mt-8 flex flex-col justify-center center items-center">
                        <video controls class="w-full h-auto max-w-full border border-gray-200 rounded-lg">
                            <source src="{{$video[VideoContents::FIELD_URL]}}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <p class="block mt-2 leading-loose text-gray-600 dark:text-gray-300">
                            {{$video[VideoContents::FIELD_DESCRIPTION]}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
