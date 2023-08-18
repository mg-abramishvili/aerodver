@section('title', 'АэроДверь')
@section('meta_description', $settings->meta_description ? $settings->meta_description : 'aerodver.ru.')

@extends('layouts.front')
@section('content')
    <div id="main-carousel" class="carousel slide" data-bs-ride="carousel">
        <!-- <div class="carousel-indicators">
            <button type="button" data-bs-target="#main-carousel" data-bs-slide-to="0"  class="active" aria-current="true"  aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#main-carousel" data-bs-slide-to="1"  aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#main-carousel" data-bs-slide-to="2"  aria-label="Slide 3"></button>
        </div> -->

        <div class="carousel-inner">
            <div data-bs-interval="5000" class="carousel-item active">
                <div class="carousel-item-video">
                    <video autoplay nocontrols muted loop>
                        <source src="{{ $settings->video_bg }}" type="video/mp4">
                    </video>
                </div>
                <div class="carousel-caption mainbanners-slider" data-flickity='{ "autoPlay": 5000, "pauseAutoPlayOnHover": false, "fade": true, "draggable": false, "prevNextButtons": false, "pageDots": false }'>
                    @foreach($mainbanners as $mainbanner)
                        <div class="carousel-cell">
                            <h1>
                                @if(app()->getLocale() == 'en')
                                    {{ $mainbanner->title_eng }}
                                @else
                                {{ $mainbanner->title }}
                                @endif
                            </h1>

                            @if($mainbanner->subtitle && $mainbanner->subtitle_eng)
                                <p>
                                    @if(app()->getLocale() == 'en')
                                        {{ $mainbanner->subtitle_eng }}
                                    @else
                                        {{ $mainbanner->subtitle }}
                                    @endif
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- <div data-bs-interval="5000" class="carousel-item">
                <div class="carousel-item-image" style="background-image: url(/img/slide02.jpg);"></div>
                <div class="carousel-caption">
                    <h5>hhh</h5>
                    <p>ppp</p>
                    <a href="123" class="btn btn-standard">Подробнее</a>
                </div>
            </div> -->
        </div>

        <!-- <button class="carousel-control-prev" type="button" data-bs-target="#main-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Назад</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#main-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Вперед</span>
        </button> -->
    </div>

    <div class="main-catalog p11">
        <div class="container">
            <div class="row justify-content-center">
                @foreach($categories->take(5) as $category)
                    <div class="col-12 col-lg-4">
                        <div class="main-catalog-item">
                            <a href="/catalog/{{ $category->slug ? $category->slug : $category->id }}">
                                <div class="main-catalog-item-image">
                                    <div class="main-catalog-item-image-inner" style="background-image: url({{ $category->image }})"></div>
                                </div>
                                <h2 class="main-catalog-item-name">
                                    @if(app()->getLocale() == 'en')
                                        {{ $category->name_eng }}
                                    @else
                                        {{ $category->name }}
                                    @endif
                                </h2>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="main-history p01">
        <div class="container">
            @if(app()->getLocale() == 'en')
                {!! $settings->about_text_eng !!}
            @else
                {!! $settings->about_text !!}
            @endif
        </div>
    </div>
@endsection