@section('title', 'Энергоаудит')
@section('meta_description', 'Энергоаудит')

@extends('layouts.front')
@section('content')
    <div class="page policy">
        <div class="container">
            <h1 class="title-head">Энергоаудит г. {{ $city->name }}</h1>
            
            @foreach($city->firms as $firm)
                <div class="firm-card">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-3">
                            @foreach($firm->gallery as $galleryItem)
                                @if($loop->first)
                                    <div class="firm-pic" style="background-image: url({{ $galleryItem }});"></div>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="firm-card-desc">
                                <h3>
                                    @if(app()->getLocale() == 'en')
                                        {{ $firm->name_eng }}
                                    @else
                                        {{ $firm->name }}
                                    @endif
                                </h3>
    
                                <span class="firm-price">от {{ $firm->price }} руб.</span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="firm-card-button">
                                <a href="/firm/{{ $firm->id }}" class="btn btn-standard">Подробнее</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection