<?php
use App\Models\VideoContents;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\HomePageController;
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin panel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 relative overflow-x-auto shadow-md sm:rounded-lg">
                    <form method="POST" action="{{ route('updateVideoContent', ['id' => $content['id']]) }}">
                        @csrf
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <video class="w-full"  muted controls>
                                <source src="{{Config::get('app.url') . "/" . $content[VideoContents::FIELD_URL]}}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <img class="rounded-t-lg object-cover min-w-full min-h-full max-w-full max-h-full" src="{{HomePageController::getEmbedDomen() . $content[VideoContents::FIELD_PREVIEW_URL]}}" alt="">
                        </div>
                        <div class="mb-6">
                            <label for="url" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">URL</label>
                            <a href = "{{$content[VideoContents::FIELD_URL]}}" target="_blank">{{$content[VideoContents::FIELD_URL]}}</a>
                        </div>
                        <div class="mb-6">
                            <label for="name_ru" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name RU</label>
                            <textarea id="name_ru" name = "name_ru" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">{{$content[VideoContents::FIELD_NAME_RU]}}</textarea>
                        </div>
                        <div class="mb-6">
                            <label for="description_ru" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description RU</label>
                            <textarea id="description_ru" name = "description_ru" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">{{$content[VideoContents::FIELD_DESCRIPTION_RU]}}</textarea>
                        </div>
                        <div class="mb-6">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name EN</label>
                            <textarea id="name" name = "name" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">{{$content[VideoContents::FIELD_NAME]}}</textarea>
                        </div>
                        <div class="mb-6">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description EN</label>
                            <textarea id="description" name = "description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">{{$content[VideoContents::FIELD_DESCRIPTION]}}</textarea>
                        </div>
                        <div class="mb-6">
                            <label for="name_de" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name DE</label>
                            <textarea id="name_de" name = "name_de" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">{{$content[VideoContents::FIELD_NAME_DE]}}</textarea>
                        </div>
                        <div class="mb-6">
                            <label for="description_de" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description DE</label>
                            <textarea id="description_de" name = "description_de" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">{{$content[VideoContents::FIELD_DESCRIPTION_DE]}}</textarea>
                        </div>
                        <div class="mb-6">
                            <label for="views" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Views</label>
                            <input name = "views" id="views" value="{{$content[VideoContents::FIELD_VIEWS]}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                        </div>
                        <div class="mb-6">
                            <label for="likes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Likes</label>
                            <input name = "likes" id="likes" value="{{$content[VideoContents::FIELD_LIKES]}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                        </div>
                        <div class="mb-6">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categories</label>
                            <ul class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @foreach($categories as $category)
                                    <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                                        <div class="flex items-center ps-3">
                                            <input id="{{$category['name_ru']}}" name ="category[]" type="checkbox" value="{{$category['id']}}" @if (in_array($category['id'], $categoriesLinking)) checked @endif class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="category[]" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{$category['name_ru']}}</label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
