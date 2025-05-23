<?php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetLocale;
?>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="{{ route('home.public', app()->getLocale())}}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="/assets/img/logo/logo_2_2.png" class="h-8" alt="Flowbite Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Leaked girls</span>
        </a>
        <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <a href="{{ route('home.public', ['locale' => app()->getLocale()])}}"
                       @if (Route::currentRouteName() == 'home.public')
                       class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500" aria-current="page"
                       @else
                       class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
                       @endif
                    >{{__('public.home')}}</a>
                </li>
                <li>
                    <a href="{{ route('getAllCategories', ['locale' => app()->getLocale()])}}"
                       @if (Route::currentRouteName() == 'getAllCategories' || Route::currentRouteName() == 'getVideosByCategories')
                           class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500" aria-current="page"
                       @else
                           class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
                        @endif
                    >{{__('public.categories')}}</a>
                </li>
                <li>
                    <a href="{{ route('getTopRatedVideos', ['locale' => app()->getLocale()])}}"
                       @if (Route::currentRouteName() == 'getTopRatedVideos')
                           class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500" aria-current="page"
                       @else
                           class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
                       @endif
                    >{{__('public.topRated')}}</a>
                </li>
                <li>
                    <a href="{{ route('getMostViewVideos', ['locale' => app()->getLocale()])}}"
                       @if (Route::currentRouteName() == 'getMostViewVideos')
                           class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500" aria-current="page"
                       @else
                           class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
                       @endif
                    >{{__('public.mostView')}}</a>
                </li>
                <li>
                    <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent"> {{__('public.language')}} <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg></button>
                    <!-- Dropdown menu -->
                    <div id="dropdownNavbar" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                            <li>
                                <a class="flex items-start mb-3" href="{{ route('changeLanguage', ['locale' => app()->getLocale(), 'lang' => SetLocale::LANG_EN])}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <img class="max-w-5 ml-2" src="/assets/img/flags/us.svg" alt="{{SetLocale::LANG_EN}}">
                                    <span class="ml-3">English</span>
                                </a>
                            </li>
                            <li>
                                <a class="flex items-start mb-3" href="{{ route('changeLanguage', ['locale' => app()->getLocale(), 'lang' => SetLocale::LANG_RU])}} " class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <img class="max-w-5 ml-2" src="/assets/img/flags/ru.svg" alt="{{SetLocale::LANG_RU}}">
                                    <span class="ml-3">Русский</span>
                                </a>
                            </li>
                            <li>
                                <a class="flex items-start mb-3" href="{{ route('changeLanguage', ['locale' => app()->getLocale(), 'lang' => SetLocale::LANG_DE])}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <img class="max-w-5 ml-2" src="/assets/img/flags/de.svg" alt="{{SetLocale::LANG_DE}}">
                                    <span class="ml-3">Deutsch</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

