@extends('layouts.app')

@section('content')
@if (session('success'))
{{session('success')}}
@endif
<h1>お届け先一覧</h1>
<table border="1">
<tr>
<th>郵便番号</th>
<th>住所</th>
</tr>
<tr>
@foreach ($adresses as $adress)
<input type="radio" name="id" value="{{$adress['id']}}">
<td>{{$adress['postal_code']}}</td>
<td>{{$adress['prefecture']. $adress['city']. $adress['adress_line']}}</td>
<td>
{!! Form::open(['route' => 'adress.edit']) !!}
{!! Form::hidden('adress_id', $adress['id']) !!}
{!! Form::submit('編集') !!}
{!! Form::close() !!}
</td>
<td>
{!! Form::open(['route' => 'adress.remove']) !!}
{!! Form::hidden('adress_id', $adress['id']) !!}
{!! Form::submit('削除') !!}
{!! Form::close() !!}
</td>
</tr>
@endforeach
</table>
<a href="{{route('adress.add')}}">お届け先追加</a>
<a href="{{route('cart.index')}}">カートへ</a>
@endsection
