@section('title', 'Корзина')

@extends('layouts.front')
@section('content')
    <div class="page cart">
        <div class="container">
            <h1 class="title-head">Корзина</h1>
            
            @if(session('cart'))
                <cart
                    lang="{{ app()->getLocale() }}"
                />
            @else
                <p>Корзина пуста.</p>
            @endif
        </div>
    </div>
@endsection