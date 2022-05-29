<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;

class ItemController extends Controller {

	public function item() {

		$items = Item::all();
		return view('admin.item', ['items' => $items]);
	}

	public function detail($id) {

		$item = Item::find($id);
		if (!isset($item)) {
			return redirect('/');
		}
		return view('admin.detail', ['item' => $item]);
	}

	public function add() {

		return view('admin.add');
	}

	public function create(Request $request) {

		$request->validate([
			'name' => 'required',
			'price' => 'required|integer|min:0',
			'quantity' => 'required|integer|min:0',
		],
		[
			'name.required' => '商品名を入力して下さい',
			'price.required' => '値段を入力して下さい',
			'price.integer' => '値段は整数で入力して下さい',
			'price.min' => '値段は0以上で入力して下さい',
			'quantity.required' => '数量を入力して下さい',
			'quantity.integer' => '数量は整数で入力して下さい',
			'quantity.min' => '数量は0以上で入力して下さい',
		]);

		$item = new Item();
		$item->name = $request->input('name');
		$item->description = $request->input('description');
		if (empty($item->description)) {
			$item->description = '';
		}
		$item->price = $request->input('price');
		$item->quantity = $request->input('quantity');
		$item->save();

		return redirect(route('admin.item'))->with('success', '追加しました');
	}

	public function edit($id) {

		$item = Item::find($id);

		if (!isset($item)) {
			return redirect('/');
		}
		return view('admin.edit', ['item' => $item]);
	}

	public function update(Request $request, $id) {

		$request->validate([
			'name' => 'required',
			'quantity' => 'required|integer|min:0',
		],
		[
			'name.required' => '商品名を入力して下さい',
			'quantity.required' => '数量を入力して下さい',
			'quantity.integer' => '数量は整数で入力して下さい',
			'quantity.min' => '数量は0以上で入力して下さい',
		]);

		$item = Item::findOrFail($id);
		$item->name = $request->input('name');
		$item->description = $request->input('description');
		if (empty($item->description)) {
			$item->description = '';
		}
		$item->quantity = $request->input('quantity');
		$item->save();

		return redirect(route('admin.item'))->with('success', '編集しました');
	}
}
