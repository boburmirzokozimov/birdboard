@if(count($activity->changes['after']) == 1)
    Project {{key($activity->changes['after'])}} was updated,by {{$activity->user->name}}
@else
    Project was updated,by {{$activity->user->name}}
@endif
