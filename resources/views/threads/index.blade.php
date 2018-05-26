@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Forum Threads</div>

                    <div class="panel-body">
                        @forelse($threads as $thread)
                            <article>
                                <a href="{{ $app->make('url')->to($thread->path()) }}">
                                    <h4>{{ $thread->title }}</h4>
                                </a>
                                <div class="body">{{ $thread->body }} </div>
                            </article>
                            <hr/>
                            @empty
                            <p>There is no threads right here yet</p>
                            @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
