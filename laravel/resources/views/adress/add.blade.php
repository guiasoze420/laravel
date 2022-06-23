@extends('layouts.app')

@section('content')
@if (session('success'))
{{session('success')}}
@endif

@if($errors->any())
<ul>
@foreach($errors->all() as $error)
<li>{{$error}}</li>
@endforeach
</ul>
@endif

<h1>お届け先登録</h1>
<form action="{{route('adress.create')}}" method="post">
{{csrf_field()}}
<table>
<tr><th>お名前</th><td><input type="text" name="name" value="{{old('name')}}"></td></tr>
<tr><th>郵便番号</th><td><input type="text" name="postal_code" value="{{old('postal_code')}}">ハイフン無しで入力して下さい（例：9302004）</td></tr>
<tr><th>都道府県</th><td><input type="text" name="prefecture" value="{{old('prefecture')}}"></td></tr>
<tr><th>市町村区</th><td><input type="text" name="city" value="{{old('city')}}"></td></tr>
<tr><th>番地</th><td><input type="text" name="adress_line" value="{{old('adress_line')}}"></td></tr>
<tr><th>電話番号</th><td><input type="text" name="phone_number" value="{{old('phone_number')}}">ハイフン無しで入力して下さい（例；09012345678）</td></tr>
<tr><th></th><td><input type="submit" value="登録"></td></tr>
</table>
</form>
<a href="{{route('cart.index')}}">カートへ</a>
@endsection
