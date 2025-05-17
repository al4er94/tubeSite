<?php
use App\Models\VideoContents;
use App\Http\Controllers\HomePageController;
use Illuminate\Support\Facades\Config;
?>

@if(isset($title))
    @section('page_title'){{$title}}@endsection
@endif

@if(isset($description))
    @section('page_description'){{$description}}@endsection
@endif
<x-public-layout>
    @include('public.search')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(isset($header))
                        <h1 class="text-3xl text-gray-900 mt-3 mb-3 mr-3 ml-3">
                            {{$header}}
                        </h1>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4">
                        @if(isset($content['data']))
                            @foreach ($content['data'] as $item)
                                <div class="mt-3 mb-3 mr-3 ml-3 max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-col gap-5">
                                    <a class="flex justify-center items-center h-64 relative" href="{{ route('getVideoById', ['locale' => app()->getLocale(), 'id' => $item[VideoContents::FIELD_ID]])}}">
                                        <img class="rounded-t-lg object-cover min-w-full min-h-full max-w-full max-h-full" src="{{HomePageController::getEmbedDomen() . $item[VideoContents::FIELD_PREVIEW_URL]}}" alt="">
                                    </a>
                                    <div class="px-5 grow">
                                        <a href="{{ route('getVideoById', ['id' => $item[VideoContents::FIELD_ID], 'locale' => app()->getLocale()])}}">
                                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{$item[VideoContents::getNameByLocale()]}}</p>
                                        </a>
                                    </div>
                                    <div class="px-5 pb-5 flex justify-between">
                                        <div class="flex items-start text-blue-500 gap-2">
                                            <svg class="h-5 w-5 text-blue-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                            </svg>
                                            {{$item[VideoContents::FIELD_LIKES]}}
                                        </div>
                                        <div class="flex items-start text-blue-500 gap-2">
                                            <svg class="h-5 w-5 text-blue-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            {{$item[VideoContents::FIELD_VIEWS]}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>
                    <div class="h-auto max-w-lg mx-auto ">
                        <nav aria-label="Page navigation example">
                            <ul class="flex items-center -space-x-px h-10 text-base">
                                @foreach($content['links'] as $i => $link)
                                    <li>
                                        @if($i > 1 &&
                                            $i < count($content['links']) - 2 &&
                                            !$link['active'] && $link['label'] != "..." &&
                                            !$content['links'][$i+1]['active'] &&
                                            !$content['links'][$i-1]['active'])
                                          @continue;
                                        @endif
                                        @if($i == 0 )
                                            <a href="{{$link['url']}}" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                                <span class="sr-only">Previous</span>
                                                <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                                </svg>
                                            </a>
                                        @elseif($i == count($content['links']) - 1)
                                            <a href="{{$link['url']}}" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                                <span class="sr-only">Next</span>
                                                <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                                </svg>
                                            </a>
                                        @else
                                            @if($link['active'])
                                                <a href="{{$link['url']}}" aria-current="page" class="z-10 flex items-center justify-center px-4 h-10 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{$link['label']}}</a>
                                            @else
                                                <a href="{{$link['url']}}" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{$link['label']}}</a>
                                            @endif
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>
                    @if(isset($article))
                    <article class = "text-center">
                        <h3 class="text-balance">{{$title}}</h3>
                        <p>{{$article}}</p>
                    </article>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
