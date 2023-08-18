@section('title', $category->name)
@section('meta_description', $category->name)

@extends('layouts.front')
@section('content')
    <div class="page category-page">
        <div class="container">
            <h1 class="title-head">
                @if(app()->getLocale() == 'en')
                    {{ $category->name_eng }}
                @else
                    {{ $category->name }}
                @endif
            </h1>

            @if($category->children->count())
                <div class="main-catalog">
                    <div class="row">
                        @foreach($category->children as $child)
                            <div class="col-6 col-lg-4">
                                <div class="main-catalog-item">
                                    <a href="/catalog/{{ $child->slug ? $child->slug : $child->id }}">
                                        <div class="main-catalog-item-image">
                                            <div class="main-catalog-item-image-inner" style="background-image: url({{ $child->image }})"></div>
                                        </div>
                                        <h2 class="main-catalog-item-name">
                                            @if(app()->getLocale() == 'en')
                                                {{ $child->name_eng }}
                                            @else
                                                {{ $child->name }}
                                            @endif
                                        </h2>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="category-page-list">
                <div class="row">
                    @if($category->products->count())
                        @foreach($category->products as $product)
                            <div class="col-6 col-lg-4">
                                <a href="/product/{{ $product->slug ? $product->slug : $product->id }}" class="category-page-list-item">
                                    <div class="category-page-list-item-image">
                                        <img src="{{ $product->gallery[0] }}" alt="{{ $product->name }}">
                                    </div>

                                    <!-- <span>
                                        @if(app()->getLocale() == 'en')
                                            ${{ $product->price_usd }}
                                        @else
                                            {{ $product->price_rub }} ₽
                                        @endif
                                    </span> -->

                                    <h3>
                                        @if(app()->getLocale() == 'en')
                                            {{ $product->name_eng }}
                                        @else
                                            {{ $product->name }}
                                        @endif
                                    </h3>
                                </a>
                            </div>
                        @endforeach
                    @elseif(!$category->products->count() && !$category->children->count())
                        <p>Категория пуста.</p>
                    @endif
                </div>
            </div>

            @if($category->description)
                <hr>
                {!! $category->description !!}
            @endif
        </div>
    </div>
@endsection