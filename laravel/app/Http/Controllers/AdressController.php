<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth; //ユーザー情報取得するため記述
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cart;
use App\Item;
use App\User;
use DB;

class CartController extends Controller {

	public function add(Request $request) {

		if ($request->quantity === null || $request->quantity <= 0 ) {
			return back();
		}
		$item_id = Item::where('id', $request->item_id)->first();
		$cart_id = Cart::where([['item_id', $request->item_id], ['user_id', Auth::id()]])->first();
		if ($item_id['quantity'] - $request->quantity >= 0) {
			DB::transaction(function() use($item_id, $cart_id, $request) {
				if ($cart_id) {
					Cart::where([['item_id', $request->item_id], ['user_id', Auth::id()]])->update([
						'quantity' => $cart_id['quantity'] + $request->quantity,
					]);
				} else {
					$cart = new Cart();
					$cart['user_id'] = Auth::id();
					$cart['item_id'] = $request->item_id;
					$cart['quantity'] = $request->quantity;
					$cart->save();
				};
				Item::where('id', $request->item_id)->update([
					'quantity' =>  $item_id['quantity'] - $request->quantity,
				]);
			});
		} else {
			return redirect(route('item.index'))->with('success', '希望数量より在庫が少ないです');
		}
		return redirect(route('cart.index'))->with('success', 'カートに追加しました');
	}

	public function index(Request $request) {

		$carts = Cart::where([['user_id', Auth::id()], ['delete_flag', 'off']])
			->select('carts.id', 'carts.quantity', 'items.id as item_id')
			->join('items', 'carts.item_id', '=', 'items.id')
			->get();

		$total_price = 0;
		foreach ($carts as $cart) {
			$cart['item_price'] = $cart['item']['price'] * $cart['quantity'];
			$total_price += $cart['item']['price'] * $cart['quantity'];
			$judge = $cart['item_id'];
		}
		return view('cart.index', compact('carts', 'total_price', 'judge'));
	}

	public function remove(Request $request) {

		DB::transaction(function() use($request) {
			Cart::where([['item_id', $request->item_id], ['user_id', Auth::id()]])->update([
				'delete_flag' => 'on',
			]);
			$cart = Cart::where([['item_id', $request->item_id], ['user_id', Auth::id()]])->first();
			$item = Item::find($request->item_id);
			$item['quantity'] += $cart['quantity'];
			$item->save();
		});
		return redirect(route('cart.index'))->with('success', '削除しました');
	}
}
