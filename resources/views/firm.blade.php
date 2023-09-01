@section('title', $firm->name)
@section('meta_description', $firm->name)

@extends('layouts.front')
@section('content')
    <div class="page product-page firm-page">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-7">
                    
                    @if($firm->gallery)
                        <div class="main-carousel" data-flickity='{ "cellAlign": "left", "contain": true, "pageDots": false }'>
                            @foreach($firm->gallery as $galleryItem)
                                <div class="carousel-cell">
                                    <img src="{{ $galleryItem }}" alt="{{ $firm->name }}">
                                </div>
                            @endforeach
                        </div>

                        <div class="subcarousel">
                            <div class="nav-carousel" data-flickity='{ "asNavFor": ".main-carousel", "cellAlign": "left", "contain": true, "pageDots": false }'>
                                @foreach($firm->gallery as $galleryItem)
                                    <div class="carousel-cell">
                                        <img src="{{ $galleryItem }}" alt="{{ $firm->name }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
                <div class="col-12 col-lg-5">
                    <h1 class="title-head">{{ $firm->name }}</h1>

                    <span class="firm-price">от {{ $firm->price }} руб.</span>

                    <ul class="firm-ul">
                        <li><strong>Адрес:</strong> г. {{ $firm->city->name }}, {{ $firm->address }}</li>
                        <li><strong>Телефон:</strong> {{ $firm->tel }}</li>

                        @if($firm->whatsapp)
                            <li><strong>WhatsApp:</strong> {{ $firm->whatsapp }}</li>
                        @endif
                    </ul>
                </div>
            </div>

            <hr>

            @if($firm->description)
                {!! $firm->description !!}
            @endif
        </div>
    </div>
@endsection