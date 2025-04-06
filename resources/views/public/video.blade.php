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
                    <div class="mt-8 flex flex-col justify-center center items-center" id = "frame" data-tkn = "{{$tkn}}" data-id="{{$video[VideoContents::FIELD_ID]}}" data-testurl = "{{ base64_encode($video[VideoContents::FIELD_URL]) }}">
                    </div>
                    <div class="p-5 flex justify-between">
                        <div class="flex items-start text-blue-500 gap-x-2">
                            <svg class="h-5 w-5 text-blue-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                            </svg>
                            {{$video[VideoContents::FIELD_LIKES]}}
                        </div>
                        <div class="flex items-start text-blue-500 gap-x-2">
                            <svg class="h-5 w-5 text-blue-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{$video[VideoContents::FIELD_VIEWS]}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @vite(['resources/js/video.js'])
</x-public-layout>
