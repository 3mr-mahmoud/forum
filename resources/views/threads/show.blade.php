@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <span class="flex">
                        <a href="{{ route('profile', $thread->creator) }}" >{{ $thread->creator->name  }}</a>
                        posted: {{ $thread->title }}
                            </span>
                            @can('update',$thread)
                            <form action="{{ $app->make('url')->to($thread->path()) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-link">Delete thread</button>
                            </form>
                             @endcan
                        </div>
                    </div>
                    
                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                </div>
                @foreach($replies as $reply)
                <reply :attributes="{{ $reply }}" path="{{ $app->make('url')->to('/replies/'.$reply->id) }}" inline-template v-cloak>
                    <div class="panel panel-default" id="reply-{{ $reply->id }}">
                        <div class="panel-heading">
                            <div class="level">
                                <h5 class="flex">
                                    <a href="{{ route('profile', $reply->owner) }}" >{{  $reply->owner->name }}</a>
                                    said {{ $reply->created_at->diffForHumans() }}...
                                </h5>

                            <div>
                                <favorite :reply="{{ $reply }}" path="{{ $app->make('url')->to('replies/'.$reply->id.'/favorites') }}"></favorite>
                            </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group" v-if="editing">
                        <div><textarea class="form-control" v-model="body"></textarea></div>
                        <button class="btn btn-xs btn-primary" @click="update">Update</button>
                        <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
                        </div>
                        <div v-else v-text="body">
                        </div>  
                        </div>
                        @can('update',$reply)
                        <div class="panel-footer level">
                            <button class="btn btn-xs mr-1" @click="editing = true">Edit</button>
                            <button class="btn btn-xs btn-danger mr-1" @click="destroy">Delete</button>      
                        </div>
                        @endcan
                    </div>
                    </reply>
                @endforeach
                {{ $replies->links() }}
                @if(auth()->check())

                    <form method="POST" action="/forum/public/{{ $thread->path().'\replies' }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" rows="5">Have Something to say ?? </textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Post</button>
                    </form>
                @endif
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        This Thread Was Published {{ $thread->created_at->diffForHumans() }} by
                        <a href="#">{{ $thread->creator->name }}</a>, and currently has {{ $thread->replies_count }} {{ str_plural('comment',$thread->replies_count) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
