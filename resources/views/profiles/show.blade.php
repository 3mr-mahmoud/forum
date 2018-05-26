@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel-heading">
            <h1> {{ $ProfileUser->name }} </h1> Since <small> {{ $ProfileUser->created_at->diffForHumans() }} </small>
        </div>

                @foreach($activities as $date => $activity)
                    <h3 class="page-heading">
                        {{ $date }}
                    </h3>
                    @foreach($activity as $record)
                    @include('profiles.activity.'.$record->type,['activity'=> $record])
                    @endforeach
                @endforeach

    </div>
@endsection