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
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Create At
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Update At
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Is admin
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                   {{$user['email']}}
                                </th>
                                <td class="px-6 py-4">
                                    {{$user['name']}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$user['created_at']}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$user['updated_at']}}
                                </td>
                                <td class="px-6 py-4">
                                    @if($user['admin'])
                                        <p class="font-medium text-rose-600">Yes</p>
                                    @else
                                        <p class="font-medium ">No</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('user', ['id' => $user['id']])}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
