@section('title', 'Энергоаудит')
@section('meta_description', 'Энергоаудит')

@extends('layouts.front')
@section('content')
    <div class="page policy">
        <div class="container">
            <h1 class="title-head">Энергоаудит</h1>
            
            <ul>
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
        </div>
    </div>
@endsection