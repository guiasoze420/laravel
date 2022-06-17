@extends('layouts.app')

@section('content')
@if (session('success'))
{{session('success')}}
@endif
<h1>カート</h1>
@if (empty($judge))
<p>カートは空です</p>
@else
<table border="1">
<tr>
<th>商品名</th>
<th>価格</th>
<th>購入数</th>
<th>小計</th>
</tr>
<tr>
@foreach ($carts as $cart)
<td>{{$cart['item']['name']}}</td>
<td>{{$cart['item']['price']}}</td>
<td>{{$cart['quantity']}}</td>
<td>{{$cart['item_price']}}</td>
<td>
{!! Form::open(['route' => 'cart.remove']) !!}
{!! Form::hidden('item_id', $cart['item_id']) !!}
{!! Form::submit('削除') !!}
{!! Form::close() !!}
</td>
</tr>
@endforeach
</table>
<p>合計金額：{{$total_price}}円</p>
@endif
<a href="{{route('item.index')}}">商品一覧へ</a>
<a href="{{route('adress.index')}}">お届け先選択</a>
@endsection
