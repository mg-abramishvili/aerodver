@section('title', 'Энергоаудит')
@section('meta_description', 'Энергоаудит')

@extends('layouts.front')
@section('content')
    <div class="page policy">
        <div class="container">
            <h1 class="title-head">Энергоаудит</h1>
            
            <ul>
                @foreach($city->firms as $firm)
                    <li>
                        <a>
                            @if(app()->getLocale() == 'en')
                                {{ $firm->name_eng }}
                            @else
                                {{ $firm->name }}
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection