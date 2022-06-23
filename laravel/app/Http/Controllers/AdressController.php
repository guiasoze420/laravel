<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth; //ユーザー情報取得するため記述
use Illuminate\Http\Request;
use App\Http\Requests\AdressRequest; //FormRequest使用
use App\Http\Controllers\Controller;
use App\Adress;
use App\User;
use DB;

class AdressController extends Controller {

	public function index(Request $request) {

		$adresses = Adress::where([['user_id', Auth::id()], ['delete_flag', 'off']])->get();
		return view('adress.index', compact('adresses'));
	}

	public function add() {

		return view('adress.add');
	}

	public function create(AdressRequest $request) {

		$adress_info = Adress::where([
			['user_id', Auth::id()],
			['name', $request->name],
			['postal_code', $request->postal_code],
			['prefecture', $request->prefecture],
			['city', $request->city],
			['adress_line', $request->adress_line],
			['phone_number', $request->phone_number],
			['delete_flag', 'off'],
		])->first();

		if (isset($adress_info)) {
			return redirect(route('adress.index'))->with('error', '内容が全て同じ為、登録できません');
		}

		$adress = new Adress();
		$adress['user_id'] = Auth::id();
		$adress['name'] = $request->name;
		$adress['postal_code'] = $request->postal_code;
		$adress['prefecture'] = $request->prefecture;
		$adress['city'] = $request->city;
		$adress['adress_line'] = $request->adress_line;
		$adress['phone_number'] = $request->phone_number;
		$adress->save();

		return redirect(route('adress.index'))->with('success', 'お届け先追加しました');
	}

	public function edit($id) {

		$adress = Adress::where([['id', $id], ['user_id', Auth::id()], ['delete_flag', 'off']])->first();

		if (!isset($adress)) {
			return redirect(route('adress.index'));
		}
		return view('adress.edit', compact('adress'));
	}

	public function update(AdressRequest $request) {

		Adress::where([['id', $request->id], ['user_id', Auth::id()]])->update([
		 'name' => $request->name,
		 'postal_code' => $request->postal_code,
		 'prefecture' => $request->prefecture,
		 'city' => $request->city,
		 'adress_line' => $request->adress_line,
		 'phone_number' => $request->phone_number,
		]);
		return redirect(route('adress.index'))->with('success', '編集しました');
	}

	public function remove($id) {

		Adress::where([['id', $id], ['user_id', Auth::id()]])->update([
			'delete_flag' => 'on',
		]);
		return redirect(route('adress.index'))->with('success', '削除しました');
	}
}
