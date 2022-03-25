<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller {

	public function index() {
		$var = ['name' => 'やさい'];
		return view('test.index', $var); //item.indexは、views下のitemディレクトリ下のindex.blade.phpを表示させるという意味
	}
}

