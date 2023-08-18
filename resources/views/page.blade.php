@section('title', $page->name)
@section('meta_description', $page->name)

@extends('layouts.front')
@section('content')
    <div class="page policy">
        <div class="container">
            <h1 class="title-head">{{ $page->name }}</h1>
            
            {!! $page->content !!}

            @if($page->gallery)
                @foreach($page->gallery as $galleryItem)
                    <img src="{{ $galleryItem }}" alt="" style="width: auto; height: auto; max-width: 100%; max-height: 500px; display: block; margin: 0 auto; margin-top: 20px; margin-bottom: 20px;">
                @endforeach
            @endif
        </div>
    </div>
@endsection