<?php
use App\Models\Categories;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\HomePageController;
?>
@if(isset($title))
    @section('page_title'){{$title}}@endsection
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
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        @if(isset($categories))
                            @foreach ($categories as $item)
                                <div class="mt-3 mb-3 mr-3 ml-3 max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                    <a href="{{ route('getVideosByCategories', ['id' => $item[Categories::FIELD_ID], 'locale' => app()->getLocale()])}}">
                                        <img class="rounded-t-lg" src="{{HomePageController::getEmbedDomen() . $item[Categories::FIELD_IMG_URL]}}" alt="">
                                    </a>
                                    <div class="p-5">
                                        <a href="{{ route('getVideosByCategories', ['id' => $item[Categories::FIELD_ID], 'locale' => app()->getLocale()])}}">
                                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{$item[Categories::getNameByLocale()]}}</p>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
