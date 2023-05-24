<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between flex-row">
            <p class="font-semibold text-gray-400 dark:text-gray-200 leading-tight">
                <a href="{{ route('projects') }}">Projects</a> / {{$project->title}}
            </p>
            <a class="custom-link" href="{{ route('projects.edit',['project'=>$project->id]) }}">
                Edit
            </a>
        </div>
    </x-slot>

    <main class="container mx-auto flex justify-between mt-6 max-w-7xl">
        <div class="w-full mr-6">
            <div class="flex flex-col ">
                <div>
                    <h3 class="text-gray-400">Tasks</h3>

                    @foreach($project->tasks as $task)

                        <div class="card mb-6">
                            <form method="POST" class="flex"
                                  action="{{$task->path()}}">
                                @method('PATCH')
                                @csrf
                                <div class="flex w-full align-middle items-center">
                                    <input id="task"
                                           class="block p-2.5 w-full text-sm  bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 {{$task->completed  ? 'text-gray-400 line-through' : ''}} "
                                           type="text"
                                           value="{{$task->body}}"
                                           name="body">
                                    <input type="checkbox"
                                           onChange="this.form.submit()"
                                           value="{{$task->completed ? 'false' : 'true'}}"
                                           {{$task->completed  ? 'checked' : ''}}
                                           class="ml-4 w-8 h-8 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                           name="completed" id="completed">
                                </div>
                            </form>
                        </div>

                    @endforeach

                </div>
                <div class="">
                    <label for="notes" class="border-gray-400">General Notes</label>
                    <div class="card">
                        <form action="{{$project->path()}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <textarea id="notes"
                                      name="notes"
                                      rows="4"
                                      class="block mb-2 p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      placeholder="Write your thoughts here...">
                            {{ $project->notes }}
                        </textarea>
                            <button type="submit" class="custom-link">Save</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-xl">
            @include('projects.card')

            @include('projects.activity.card')
        </div>
    </main>

</x-app-layout>
