@extends('layouts.app')

@section('content')
<h1>お届け先登録</h1>
<form action="{{route('admin.add')}}" method="post">
{{csrf_field()}} <!-- フォーム作成時CSRF対策を施さなければエラーになる -->
<table>
<tr><th>お名前:</th><td><input type="text" name="name"></td></tr>
<tr><th>郵便番号:</th><td><input type="text" name="postal_code"></td></tr>
<tr><th>都道府県:</th><td><input type="text" name="prefecture"></td></tr    >
<tr><th>市町村区:</th><td><input type="text" name="city"></td></tr>
<tr><th>番地:</th><td><input type="text" name="adress_line"></td></tr>
<tr><th>電話番号:</th><td><input type="text" name="phone_number"></td></tr>
<tr><th></th><td><input type="submit" value="登録"></td></tr>
</table>
</form>
@endsection
