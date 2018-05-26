@component('profiles.activity.activity')
    @slot('heading')
        {{ $ProfileUser->name }} Favorited a reply
        <a href="{{ $app->make('url')->to($activity->subject->favorited->path()) }}">"{{ $activity->subject->favorited->thread->title }}"</a>
    @endslot
    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot
@endcomponent