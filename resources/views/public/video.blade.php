<?php
use App\Models\VideoContents;
use App\Models\Categories;
use Illuminate\Support\Facades\Config;
?>

<x-public-layout>
    @include('public.search')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="block mt-6 text-xl text-gray-900">{{$video[VideoContents::getNameByLocale()]}}</h1>
                    <div class="flex justify-start items-start">
                        @foreach($categories as $category)
                            <a class="bg-origin-content px-2 py-0.5 mt-0 ml-0.25 mr-0 mb-0.25 bg-blue-200 rounded-lg " href="{{ route('getVideosByCategories', ['locale' => app()->getLocale(), 'id' => $category[Categories::FIELD_ID]])}}">{{$category['name']}}</a>
                        @endforeach
                    </div>
                    <div class="mt-8 flex flex-col justify-center center items-center">
                        <video controls class="w-full h-auto max-w-full border border-gray-200 rounded-lg">
                            <source src="{{$video[VideoContents::FIELD_URL]}}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <p class="block mt-2 leading-loose text-gray-600 dark:text-gray-300">
                            {{$video[VideoContents::getDescriptionByLocale()]}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
