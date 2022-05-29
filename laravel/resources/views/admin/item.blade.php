<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>Item</title>
</head>
<body>
@if (session('success'))
{{session('success')}}
@endif
<table border="1">
<h1>商品一覧</h1>
<a href="{{route('admin.add')}}">商品追加</a>
<tr>
<th>商品名</th>
<th>値段</th>
<th>在庫</th>
</tr>
@foreach ($items as $item)
<tr>
<td>
<a href="{{route('admin.detail', ['id' => $item->id])}}">{{$item->name}}</a>
</td>
<td>{{$item->price}}</td>
<td>
@if ($item->quantity <= 0)
在庫なし
@else
在庫あり
@endif
</td>
</tr>
@endforeach
</table>
</body>
</html>
