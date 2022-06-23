@extends('layouts.app')

@section('content')

@if (session('success'))
{{session('success')}}
@endif
@if (session('error'))
{{session('error')}}
@endif

<h1>お届け先一覧</h1>
<table border="1">
<tr>
<th>選択</th>
<th>お名前</th>
<th>郵便番号</th>
<th>住所</th>
<th>電話番号</th>
</tr>
<tr>
@foreach ($adresses as $adress)
<td><input type="radio" name="id" value="{{$adress['id']}}"></td>
<td>{{$adress['name']}}</td>
<td>{{$adress['postal_code']}}</td>
<td>{{$adress['prefecture'] . $adress['city'] . $adress['adress_line']}}</td>
<td>{{$adress['phone_number']}}</td>
<td>
<form action="{{route('adress.edit', ['id' => $adress->id])}}" method="get">
{{csrf_field()}}
<button type="submit">編集</button>
</form>
</td>
<td>
<form action="{{route('adress.remove', ['id' => $adress->id])}}" method="get">
{{csrf_field()}}
<button type="submit">削除</button>
</form>
</td>
</tr>
@endforeach
</table>
<a href="{{route('adress.add')}}">お届け先追加</a>
<a href="{{route('cart.index')}}">カートへ</a>
@endsection
