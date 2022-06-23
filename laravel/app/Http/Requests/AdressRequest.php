<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PostalCodeRule;

class AdressRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
	public function authorize() {
			return true;
	}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
	public function rules() {
		return [
			'name' => 'required',
			'postal_code' => ['required', new PostalCodeRule()],
			'prefecture' => 'required',
			'city' => 'required',
			'adress_line' => 'required',
			'phone_number' => 'required|numeric|digits_between:10,11',
		];
	}
	public function massages() {
		return [
			'name.required' => '名前を入力して下さい',
			'postal_code.required' => '郵便番号を入力して下さい',
			'prefecture.required' => '都道府県を入力して下さい',
			'city.required' => '市町村区を入力して下さい',
			'adress_line.required' => '番地を入力して下さい',
			'phone_number.required' => '電話番号を入力して下さい',
			'phone_number.numeric' => '整数を入力して下さい',
			'phone_number.digits_between' => '10桁または11桁で入力して下さい',
		];
	}
}
