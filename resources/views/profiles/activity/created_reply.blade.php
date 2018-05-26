@component('profiles.activity.activity')
    @slot('heading')
        {{ $ProfileUser->name }} replied to
        <a href="{{ $app->make('url')->to($activity->subject->thread->path()) }}">"{{ $activity->subject->thread->title }}"</a>
    @endslot
    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent