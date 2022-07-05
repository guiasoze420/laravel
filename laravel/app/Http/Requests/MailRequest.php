<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PostalCodeRule;

class MailRequest extends FormRequest {
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
			'email' => 'required',
			'now_password' => 'required',
		];
	}

	public function messages() {
		return [
			'name.required' => '名前を入力して下さい',
			'email.required' => 'メールアドレスを入力してください',
			'now_password.required' => '現在のパスワードを入力して下さい',
		];
	}
}
