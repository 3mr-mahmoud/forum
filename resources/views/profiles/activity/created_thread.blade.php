@component('profiles.activity.activity')
    @slot('heading')
        {{ $ProfileUser->name }} created
        <a href="{{ $app->make('url')->to($activity->subject->path()) }}">"{{ $activity->subject->title }}"</a>
    @endslot
    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent