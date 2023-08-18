@section('title', 'VHS')

@extends('layouts.front')
@section('content')
    <div class="page vhs">
        <div class="container">
            <h1 class="title-head">VHS</h1>

            <div class="row">
                @forelse($videos as $video)
                    <div class="col-12 col-lg-4">
                        <a href="/video/{{ $video->id }}" class="vhs-list-item">
                            @if($video->image)
                                <div class="vhs-list-item-image" style="background-image: url({{ $video->image }})"></div>
                            @else
                                <div class="vhs-list-item-image" style="background-image: url(/img/video-placeholder.svg)"></div>
                            @endif
                            <p>
                                @if(app()->getLocale() == 'en')
                                    {{ $video->name_eng }}
                                @else
                                    {{ $video->name }}
                                @endif
                            </p>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <p>Раздел пуст.</p>
                    </div>
                @endforelse
            </div>
            
        </div>
    </div>
@endsection