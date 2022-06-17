@extends('layouts.app')

@section('content')
@if (session('success'))
{{session('success')}}
@endif
<table border="1">
<h1>商品一覧</h1>
<tr>
<th>商品名</th>
<th>値段</th>
<th>在庫</th>
</tr>
@foreach ($items as $item)
<tr>
<td>
<a href="{{route('item.detail', ['id' => $item->id])}}">{{$item->name}}</a>
</td>
<td>{{$item->price}}</td>
<td>
@if ($item->quantity == 0)
在庫なし
@else
在庫あり
@endif
</td>
</tr>
@endforeach
</table>
<a href="{{route('cart.index')}}">カートへ</a>
@endsection
