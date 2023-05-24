<div class="card">
    <h3 class="text-xl py-4 -ml-4 mb-3 border-l-4  border-blue-300  pl-4">
        <a href="{{$project->path()}}">
            {{$project->title}}
        </a>
    </h3>
    <div class="mt-4 mb-6">
        <p class="text-gray-400">{{Str::limit($project->description,150)}}</p>
    </div>

    <footer>
        <form method="post" class="text-right" action="{{ route('projects.destroy',['project'=>$project->id]) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-xs ">Delete</button>
        </form>
    </footer>
</div>
