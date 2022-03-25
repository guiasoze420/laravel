<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ItemController extends Controller {

	public function index() {

		$items = Item::all();

		return view('item.index', ['items' => $items]);
	}

	public function detail($id) {

		$item = Item::find($id);

		if (!isset($item)) {
			return redirect('/');
		}
		return view('item.detail', ['item' => $item]);
	}
}
