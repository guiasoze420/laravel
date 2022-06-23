<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>Item</title>
</head>
<body>
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
<li>{{$error}}</li>
@endforeach
</ul>
@endif
<h1>商品編集</h1>
<form action="{{route('admin.update', ['id' => $item->id])}}" method="post">
{{csrf_field()}} <!-- フォーム作成時CSRF対策を施さなければエラーになる -->
<table>
<tr><th>商品名:</th><td><input type="text" name="name" value="{{old('name', $item->name)}}"></td></tr>
<tr><th>説明:</th><td><input type="text" name="description" value="{{old('description', $item->description)}}"></td></tr>
<tr><th>在庫数:</th><td><input type="text" name="quantity" value="{{old('quantity', $item->quantity)}}"></td></tr>
<tr><th></th><td><input type="submit" value="編集"></td></tr>
</table>
</form>
</body>
</html>
