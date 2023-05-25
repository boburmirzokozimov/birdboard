<div class="card flex flex-col mt-6">
    <h3 class="text-xl py-4 -ml-4 mb-3 border-l-4  border-blue-300  pl-4">
        <a href="{{$project->path()}}">
            Invite a user
        </a>
    </h3>
    <footer>
        <form method="post" class=""
              action="{{ route('projects.invitations.store',['project'=>$project->id]) }}">
            @csrf
            @method('POST')
            <label for="id">Choose Member</label>
            <select
                class="block mb-2 block mb-2 p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                name="id" id="id">
                <option value="">Choose the user to invite</option>
                @foreach($users as $user)
                    @if(auth()->user()->isNot($user) && !$project->members->contains($user))
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endif
                @endforeach
            </select>
            <button type="submit" class="custom-link text-xs">Invite</button>
        </form>
    </footer>
</div>
