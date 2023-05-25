<div class="card w-1/4 h-[200px]">
    <form action="{{ route('projects.tasks.store',['project'=>$project]) }}" method="post">
        @csrf
        <label for="task">Task</label>
        <input
            type="text"
            name="body"
            id="task"
            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        >
        <button class="custom-link mt-2">
            Submit
        </button>
    </form>

</div>
