@php use Illuminate\Support\Str; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between flex-row">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Projects
            </h2>
            <a class="custom-link" href="/projects/create">
                Create
            </a>
        </div>
    </x-slot>

    <div class="container mx-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" dark:bg-gray-800 overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="grid grid-cols-3 gap-4">
                        @forelse($projects as $project)
                            @include('projects.card')
                        @empty
                            <div>
                                No projects yet
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
