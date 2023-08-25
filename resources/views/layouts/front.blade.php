<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@yield('title') - AeroDver.ru</title>
    <meta name="description" content="@yield('meta_description')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/flickity.css">
    <link rel="stylesheet" href="/css/flickity-fade.css">
    @vite('resources/css/front.css')

    @if($settings->header)
        {!! $settings->header !!}
    @endif
</head>
<body>
    <div id="front">
        <!-- <div class="alert alert-danger" role="alert">
            Мы обновляем сайт. Возможны перебои в работе. Пожалуйста, уточняйте цены по Telegram или WhatsApp.
        </div> -->

        <header>
            <div class="header-top">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col header-top-logo">
                            <a href="/">
                                <img src="/img/logo.png" alt="AeroDver.ru">
                            </a>
                        </div>
                        <div class="col header-top-lang">
                            <ul>
                                <li>
                                    <a href="{{ url()->current() }}/?lang=ru">RUS</a>
                                </li>
                                <li>
                                    <a href="{{ url()->current() }}/?lang=en">ENG</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col header-top-cart">
                            <minicart
                                lang="{{ app()->getLocale() }}"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col header-bottom-menu">
                            <nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded">
                                <div class="navbar-collapse collapse" id="navbarsExample10" style="">
                                    <ul class="navbar-nav">
                                        @foreach($categories->take(5) as $category)
                                            <li class="nav-item">
                                                <a href="/catalog/{{ $category->slug ? $category->slug : $category->id }}" class="nav-link">
                                                    @if(app()->getLocale() == 'en')
                                                        {{ $category->name_eng }}
                                                    @else
                                                        {{ $category->name }}
                                                    @endif
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <div class="col header-bottom-nav-button">
                            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                            </button>
                        </div>

                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasNavbarLabel"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="/">Главная</a>
                                    </li>
                                    @foreach($categories->take(5) as $category)
                                        <li class="nav-item">
                                            <a href="/catalog/{{ $category->slug ? $category->slug : $category->id }}" class="nav-link">
                                                @if(app()->getLocale() == 'en')
                                                    {{ $category->name_eng }}
                                                @else
                                                    {{ $category->name }}
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                    <li class="nav-item">
                                        <a class="nav-link" href="/videos">VHS</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/delivery-payment">
                                            @if(app()->getLocale() == 'en')
                                                Delivery and Payment
                                            @else
                                                Доставка и оплата
                                            @endif
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/partnership">
                                            @if(app()->getLocale() == 'en')
                                                Partnership
                                            @else
                                                Сотрудничество
                                            @endif
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/about">
                                            @if(app()->getLocale() == 'en')
                                                About
                                            @else
                                                О компании
                                            @endif
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/contacts">
                                            @if(app()->getLocale() == 'en')
                                                Contacts
                                            @else
                                                Контакты
                                            @endif
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        @yield('content')

        <footer>
            <div class="container">
                <div class="socials">
                    @if($settings->telegram)
                        <a href="{{ $settings->telegram }}">
                            <img src="/img/telegram.svg" alt="telegram">
                            <span>Telegram</span>
                        </a>
                    @endif

                    @if($settings->whatsapp)
                        <a href="{{ $settings->whatsapp }}">
                            <img src="/img/whatsapp.svg" alt="whatsapp">
                            <span>WhatsApp</span>
                        </a>
                    @endif

                    @if($settings->vk)
                        <a href="{{ $settings->vk }}">
                            <img src="/img/vk.svg" alt="vk">
                            <span>VK</span>
                        </a>
                    @endif

                    @if($settings->youtube)
                        <a href="{{ $settings->youtube }}">
                            <img src="/img/youtube.svg" alt="youtube">
                            <span>YouTube</span>
                        </a>
                    @endif

                    @if($settings->tiktok)
                        <a href="{{ $settings->tiktok }}">
                            <img src="/img/tiktok.svg" alt="tiktok">
                            <span>TikTok</span>
                        </a>
                    @endif
                </div>

                <p>aerodver.ru © 2020-{{ date('Y') }}</p>

                <a href="/policy">
                    @if(app()->getLocale() == 'en')
                        Privacy Policy (RU)
                    @else
                        Политика конфиденциальности
                    @endif
                </a>
            </div>
        </footer>

        <div class="modal fade" id="leadModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Оставить заявку</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <create-lead></create-lead>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Yandex.Metrika counter --> 
    <script type="text/javascript" > 
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; 
    m[i].l=1*new Date(); 
    for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }} 
    k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) 
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); 
    
    ym(87114138, "init", { 
            clickmap:true, 
            trackLinks:true, 
            accurateTrackBounce:true 
    }); 
    </script> 
    <noscript><div><img src="https://mc.yandex.ru/watch/87114138" style="position:absolute; left:-9999px;" alt="" /></div></noscript> 
    <!-- /Yandex.Metrika counter -->

    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/flickity.pkgd.min.js"></script>
    <script src="/js/flickity-fade.js"></script>
    @vite('resources/js/front.js')
    
    @yield('scripts')

    @if($settings->footer)
        {!! $settings->footer !!}
    @endif
</body>
</html>