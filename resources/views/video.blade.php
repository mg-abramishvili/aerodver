@section('title', 'VHS')

@extends('layouts.front')
@section('content')
    <div class="page vhs vhs-item">
        <div class="container">
            <h1 class="title-head">
                @if(app()->getLocale() == 'en')
                    {{ $video->name_eng }}
                @else
                    {{ $video->name }}
                @endif
            </h1>

            <video src="{{ $video->video }}" controls controlsList="nodownload noplaybackrate" disablePictureInPicture ></video>
            
            <div class="vhs-prev-next">
                @if($prevVideo)
                    <a href="/video/{{ $prevVideo->id }}">Предыдущее видео</a>
                @endif

                @if($nextVideo)
                    <a href="/video/{{ $nextVideo->id }}">Следующее видео</a>
                @endif
            </div>

            @if($video->description)
                <hr>

                @if(app()->getLocale() == 'en')
                    {!! $video->description_eng !!}
                @else
                    {!! $video->description !!}
                @endif
            @endif
        </div>
    </div>
@endsection