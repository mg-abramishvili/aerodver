@section('title', 'Энергоаудит')
@section('meta_description', 'Энергоаудит')

@extends('layouts.front')
@section('content')
    <div class="page policy">
        <div class="container">
            <h1 class="title-head">Энергоаудит</h1>
            
            @foreach($city->firms as $firm)
                <div class="firm-card">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-4">
                            <div class="firm-gallery">
                                <div class="main-carousel" data-flickity='{ "cellAlign": "left", "contain": true, "pageDots": false }'>
                                    @foreach($firm->gallery as $galleryItem)
                                        <div class="carousel-cell">
                                            <img src="{{ $galleryItem }}" alt="{{ $firm->name }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8">
                            <h3>
                                @if(app()->getLocale() == 'en')
                                    {{ $firm->name_eng }}
                                @else
                                    {{ $firm->name }}
                                @endif
                            </h3>

                            <span class="firm-price">от {{ $firm->price }} руб.</span>

                            <ul>
                                <li><strong>Адрес:</strong> г. {{ $firm->city->name }}, {{ $firm->address }}</li>
                                <li><strong>Телефон:</strong> {{ $firm->tel }}</li>
                                <li><strong>WhatsApp:</strong> {{ $firm->whatsapp }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection