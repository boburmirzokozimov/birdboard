<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between flex-row items-center">
            <div class="items-center flex">
                <p class="font-semibold text-gray-400 dark:text-gray-200 leading-tight mr-6">
                    <a href="{{ route('projects') }}">Projects</a> / {{$project->title}}
                </p>

                <!-- Modal HTML embedded directly into document -->
                <div id="ex1" class="modal">
                    @include('projects.create_task')
                    <a href="" rel="modal:close"></a>
                </div>

                <!-- Link to open the modal -->
                <a href="#ex1" class="custom-link" rel="modal:open">Create a new task</a>
            </div>


            <div class="items-center flex">


                <!-- Link to open the modal -->
                @foreach($project->members as $member)
                    <div id="ex2" class="modal ">
                        <form action="{{ route('projects.invitations.destroy',['project'=>$project->id]) }}"
                              method="POST"
                              class="flex justify-center justify-items-center flex-col text-center">
                            Are you sure you want to remove the member?
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{$member->id}}">
                            <button type="submit" class="mx-auto mt-2 custom-link w-1/4" style="background-color: red">
                                Remove
                            </button>
                        </form>
                    </div>
                    <a href="" rel="modal:close"></a>

                    <a href="#ex2" class="" rel="modal:open">
                        <img
                            src="{{gravatar_url($member->email)}}"
                            alt="{{$member->name}}'s avatar"
                            class="rounded-full w-8 mr-2">
                    </a>

                @endforeach
                <img
                    src="{{gravatar_url($project->owner->email)}}"
                    alt="{{$project->owner->email}}'s avatar"
                    class="rounded-full w-8 mr-2">
                <a class="custom-link ml-4" href="{{ route('projects.edit',['project'=>$project->id]) }}">
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <main class="container mx-auto flex justify-between mt-6 max-w-7xl">
        <div class="w-full mr-6">
            <div class="flex flex-col ">
                <div>
                    <h3 class="text-gray-400">Tasks</h3>
                    <div class="card mb-6">
                        @foreach($project->tasks as $task)

                            <form method="POST" class="flex"
                                  action="{{$task->path()}}">
                                @method('PATCH')
                                @csrf
                                <div class="flex w-full align-middle items-center mb-2">
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

                        @endforeach
                    </div>

                </div>
                <div class="">
                    <label for="notes" class="text-gray-400 mb-6">General Notes</label>
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

            @can('manage',$project)
                @include('projects.invite')
            @endcan
        </div>
    </main>

</x-app-layout>
