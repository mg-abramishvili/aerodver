@section('title', 'Аренда АэроДвери')
@section('meta_description', 'Аренда АэроДвери')

@extends('layouts.front')
@section('content')
    <div class="page policy">
        <div class="container">
            <h1 class="title-head">Аренда АэроДвери</h1>

            @if($settings->energoarenda_gallery)
                <div class="energoaudit-gallery" data-flickity='{ "cellAlign": "left", "contain": true, "pageDots": false }'>
                    @foreach($settings->energoarenda_gallery as $gal)
                        <div class="carousel-cell">
                            <img src="{{ $gal }}" alt="Аренда АэроДвери">
                        </div>
                    @endforeach
                </div>
            @endif
            
            <p class="cities-list-header">Выберите город:</p>

            <ul class="cities-list">
                @foreach($cities as $city)
                    <li>
                        <a href="/arenda-aerodveri/{{ $city->slug }}/firms">
                            @if(app()->getLocale() == 'en')
                                {{ $city->name_eng }}
                            @else
                                {{ $city->name }}
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>

            @if($settings->energoarenda_text)
                {!! $settings->energoarenda_text !!}
            @endif
        </div>
    </div>
@endsection