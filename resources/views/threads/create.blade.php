@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create a New Thread</div>

                    <div class="panel-body">
                        @if(count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif 
                        <form method="post" action="{{ $app->make('url')->to('/threads') }}">
                            {{ csrf_field() }}
                            <!-- channel_id Form Input -->
                                <div class="form-group">
                                    <label for="channel_id">Choose a Channel:</label>
                                    <select name="channel_id" class="form-control" id="channel_id">
                                        <option>Choose One</option>
                                        @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected': '' }}>{{ $channel->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            <!-- title Form Input -->
                            <div class="form-group">
                            <label for="title">Title:</label>
                                <input type="text" name="title" class="form-control" id="title" placeholder="title" value="{{ old('title') }}"/>
                            </div>
                            <!-- body Form Input -->
                            <div class="form-group">
                                <label for="body">Body:</label>
                                <textarea type="text" name="body" class="form-control" id="body" placeholder="body" rows="8">{{ old('body') }}</textarea>
                            </div>
                                <div class="form-group">
                            <button type="submit" class="btn btn-primary">Publish</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
