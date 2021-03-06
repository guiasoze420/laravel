@extends('layouts.app')

@section('content')
<div class="container">
@if (session('success'))
{{session('success')}}
@endif
@if (session('error'))
{{session('error')}}
@endif


	<div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
						<a href="{{route('item.index')}}">商品一覧へ</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
