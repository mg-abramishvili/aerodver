@section('title', $product->name)
@section('meta_description', $product->name)

@extends('layouts.front')
@section('content')
    <div class="page product-page">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-7">
                    <div class="main-carousel" data-flickity='{ "cellAlign": "left", "contain": true, "pageDots": false }'>
                        @foreach($product->gallery as $galleryItem)
                            <div class="carousel-cell">
                                <img src="{{ $galleryItem }}" alt="{{ $product->name }}">
                            </div>
                        @endforeach
                    </div>

                    <div class="subcarousel">
                        <div class="nav-carousel" data-flickity='{ "asNavFor": ".main-carousel", "cellAlign": "left", "contain": true, "pageDots": false }'>
                            @foreach($product->gallery as $galleryItem)
                                <div class="carousel-cell">
                                    <img src="{{ $galleryItem }}" alt="{{ $product->name }}">
                                </div>
                            @endforeach
                        </div>
                        @if($product->video)
                            <button data-bs-toggle="modal" data-bs-target="#product-video" class="video-icon" id="video-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16">
                                    <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
                                </svg>
                            </button>
                        @endif
                    </div>

                    <div class="modal" id="product-video" tabindex="-1">
                        <div class="modal-dialog modal-fullscreen">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fs-5" id="exampleModalLabel">{{ $product->name }}</h5>
                                    <button type="button" class="btn-close btn-close-white btn-video-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <video src="{{ $product->video }}" controls controlsList="nodownload noplaybackrate" disablePictureInPicture ></video>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="product-info">
                        <h1 class="title-head">
                            @if(app()->getLocale() == 'en')
                                {{ $product->name_eng }}
                            @else
                                {{ $product->name }}
                            @endif
                        </h1>

                        @if($product->subname)
                            <h2>
                                @if(app()->getLocale() == 'en')
                                    {{ $product->subname_eng }}
                                @else
                                    {{ $product->subname }}
                                @endif
                            </h2>
                        @endif

                        <div class="price">
                            @if(app()->getLocale() == 'en')
                                $
                                @php
                                    echo number_format($product->price_usd,0,",",".");
                                @endphp
                            @else
                                @php
                                    echo number_format($product->price_rub,0,","," ");
                                @endphp
                                ₽
                            @endif
                            <span>В наличии</span>
                        </div>

                        <div class="addtocart">
                            <add-to-cart
                                lang="{{ app()->getLocale() }}"
                                
                                @if($product)
                                    :product="{{ $product->id }}"
                                @endif
                            />
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- @if($product->video)
                <div class="video">
                    <video src="{{ $product->video }}" controls controlsList="nodownload noplaybackrate" disablePictureInPicture ></video>
                </div>
            @endif -->

            <div class="description">
                @if(app()->getLocale() == 'en')
                    {!! $product->description_eng !!}
                @else
                    {!! $product->description !!}
                @endif
            </div>

            @if($random->count())
                <div class="random">
                    <h5 class="title-head">Похожие товары</h5>
                    <div class="random-carousel" data-flickity='{ "cellAlign": "left", "contain": true, "wrapAround": true, "pageDots": false }'>
                        @foreach($random as $randomProduct)
                            <div class="carousel-cell">
                                <a href="/product/{{ $randomProduct->id }}" class="category-page-list-item">
                                    <div class="category-page-list-item-image">
                                        <img src="{{ $randomProduct->gallery[0] }}" alt="{{ $randomProduct->name }}">
                                    </div>

                                    <!-- <span>
                                        @if(app()->getLocale() == 'en')
                                            ${{ $randomProduct->price_usd }}
                                        @else
                                            {{ $randomProduct->price_rub }} ₽
                                        @endif
                                    </span> -->

                                    <h3>
                                        @if(app()->getLocale() == 'en')
                                            {{ $randomProduct->name_eng }}
                                        @else
                                            {{ $randomProduct->name }}
                                        @endif
                                    </h3>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            let videoModalBtn = document.getElementById("video-icon")
            let videoModalBtnClose = document.querySelector(".btn-video-close")
            let video = document.querySelector("#product-video video")
            
            if(videoModalBtn) {
                videoModalBtn.addEventListener("click", function() {
                    setTimeout(() => {
                        video.pause()
                        video.load()
                        video.play()
                    }, 500)
                })
            }
            
            if(videoModalBtnClose) {
                videoModalBtnClose.addEventListener("click", function() {
                    video.pause()
                })
            }
        })
    </script>
@endsection