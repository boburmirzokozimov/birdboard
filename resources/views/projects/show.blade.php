<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between flex-row">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{$project->title}}
            </h2>
            <a class="custom-link" href="/projects">
                Go Back
            </a>
        </div>
    </x-slot>

    <div class="container mx-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{$project->description}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
