@extends('layouts.app')

@section('content')
<h1>商品詳細</h1>
<p>・商品名</p>
<p>{{$item->name}}</p>
<p>・商品説明</p>
<p>{{$item->description}}</p>
<p>・値段</p>
<p>{{$item->price}}</p>
<p>・在庫</p>
<p>
@if (Auth::check())
@if ($item->quantity > 0)
<p>在庫あり</p>
{!! Form::open(['route' => 'cart.add']) !!}
{!! Form::hidden('item_id', $item->id) !!}
{!! Form::select('quantity', ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10'], '',  ['placeholder' => '数量']) !!}
{!! Form::submit('カートに入れる') !!}
{!! Form::close() !!}
@else
<p>在庫なし</p>
@endif
@elseif ($item->quantity > 0)
<p>在庫あり</p>
<a href="{{route('home')}}">ログインして下さい</a>
@else
<p>在庫なし</p>
@endif
<a href="{{route('item.index')}}">商品一覧へ</a>
<a href="{{route('cart.index')}}">カートへ</a>
@endsection
