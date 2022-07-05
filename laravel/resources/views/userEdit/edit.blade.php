@extends('layouts.app')

@section('content')
@if (session('success'))
{{session('success')}}
@endif

@if (session('error'))
{{session('error')}}
@endif

<h1>アカウント編集</h1>
<form action="{{route('userEdit.update')}}" method="post">
{{csrf_field()}}
<table>
<tr><th>お名前</th><td><input type="text" name="name" value="{{old('name', $user->name)}}"></td></tr>

@if($errors->has('name'))
<tr><th></th><td><p>{{$errors->first('name')}}</p></td></tr>
@endif
<tr><th>メールアドレス</th><td><input type="email" name="email" value="{{old('email', $user->email)}}"></td></tr>
@if($errors->has('email'))
<tr><th></th><td><p>{{$errors->first('email')}}</p></td></tr>
@endif
<tr><th>新しいパスワード</th><td><input type="password" name="password1"></td></tr>
@if($errors->has('password1'))
<tr><th></th><td><p>{{$errors->first('password1')}}</p></td></tr>
@endif
<tr><th>新しいパスワード（確認用）</th><td><input type="password" name="password2"></td></tr>
@if($errors->has('password2'))
<tr><th></th><td><p>{{$errors->first('password2')}}</p></td></tr>
@endif
<tr><th>現在のパスワード</th><td><input type="password" name="now_password"></td></tr>
@if($errors->has('now_password'))
<tr><th></th><td><p>{{$errors->first('now_password')}}</p></td></tr>
@endif

<tr><th></th><td><input type="submit" value="編集"></td></tr>
</table>
</form>

<a href="{{route('home')}}">ホームへ</a>
@endsection
