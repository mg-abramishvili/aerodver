@section('title', 'Энергоаудит')
@section('meta_description', 'Энергоаудит')

@extends('layouts.front')
@section('content')
    <div class="page policy">
        <div class="container">
            <h1 class="title-head">Энергоаудит</h1>

            @if($settings->energoaudit_gallery)
                <div class="energoaudit-gallery" data-flickity='{ "cellAlign": "left", "contain": true, "pageDots": false }'>
                    @foreach($settings->energoaudit_gallery as $gal)
                        <div class="carousel-cell">
                            <img src="{{ $gal }}" alt="Энергоаудит">
                        </div>
                    @endforeach
                </div>
            @endif
            
            <p class="cities-list-header">Выберите город:</p>

            <ul class="cities-list">
                @foreach($cities as $city)
                    <li>
                        <a href="/energoaudit/{{ $city->slug }}/firms">
                            @if(app()->getLocale() == 'en')
                                {{ $city->name_eng }}
                            @else
                                {{ $city->name }}
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>

            @if($settings->energoaudit_text)
                {!! $settings->energoaudit_text !!}
            @endif
        </div>
    </div>
@endsection