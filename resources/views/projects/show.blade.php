<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between flex-row">
            <p class="font-semibold text-gray-400 dark:text-gray-200 leading-tight">
                <a href="{{ route('projects') }}">Projects</a> / {{$project->title}}
            </p>
            <a class="custom-link" href="/projects">
                Go Back
            </a>
        </div>
    </x-slot>

    <main class="container mx-auto flex justify-between mt-6 max-w-7xl">
        <div class="w-full mr-6">
            <div class="flex flex-col ">
                <div>
                    <h3 class="text-gray-400">Tasks</h3>

                    @forelse($project->tasks as $task)

                        <div class="card mb-6">
                            {{$task->body}}
                        </div>
                    @empty
                        <div class="card mb-6">
                            <form method="POST" class="flex"
                                  action="{{ route('projects.tasks.store',['project'=>$project->id]) }}">
                                @csrf
                                <label for="task"></label><input id="task"
                                                                 class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                 type="text"
                                                                 name="body">
                                <button class="custom-link" type="submit">
                                    Add
                                </button>
                            </form>
                        </div>
                    @endforelse

                </div>
                <div class="">
                    <label for="notes" class="border-gray-400">General Notes</label>
                    <div class="card">
                        <textarea id="notes" rows="4"
                                  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                  placeholder="Write your thoughts here..."></textarea>

                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-xl">
            <div class="card">
                <h3 class="text-xl py-4 -ml-4 mb-3 border-l-4  border-blue-300  pl-4">
                    <a href="{{$project->path()}}">
                        {{$project->title}}
                    </a>
                </h3>
                <div class="mt-4">
                    <p class="text-gray-400">{{Str::limit($project->description,150)}}</p>
                </div>
            </div>

        </div>
    </main>

</x-app-layout>
