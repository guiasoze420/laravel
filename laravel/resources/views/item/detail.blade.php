<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
</head>
<body>
<h1>商品詳細</h1>
<p>・商品名</p>
<p>{{$item->name}}</p>
<p>・商品説明</p>
<p>{{$item->description}}</p>
<p>・値段</p>
<p>{{$item->price}}</p>
<p>・在庫</p>
<p>
@if ($item->quantity == 0)
在庫なし
@else
在庫あり
@endif
</p>
</body>
</html>
