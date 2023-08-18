@component('mail::message')
# Новая заявка с сайта FuckingMachines.ru

{{ $subject }}
<br><br>

Имя:<br>{{ $name }}
<br><br>

Телефон:<br>{{ $tel }}
<br><br>
----------
<br><br>
@foreach($order as $orderItem)
    {{ $orderItem['name'] }} &times; {{ $orderItem['quantity'] }}шт. ({{ $orderItem['price_rub'] }}руб. / ${{ $orderItem['price_usd'] }})<br><br>
@endforeach

@endcomponent