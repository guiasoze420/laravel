<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth; //ユーザー情報取得するため記述
use Illuminate\Http\Request;
use App\Http\Requests\MailRequest; //FormRequest使用
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Hash;
use Illuminate\Notifications\Notifiable;
use App\EmailReset;
use Carbon\Carbon;

class UserEditController extends Controller {

	public function edit() {

		$user = User::where('id', Auth::id())->first();

		return view('userEdit.edit', compact('user'));
	}

	public function update(MailRequest $request) {

		$user = User::where('id', Auth::id())->first();

		if (Hash::check($request->now_password, $user->password)) {

			if ($user->email !== $request->email) {
				$new_email = $request->email;
				return redirect()->route('userEdit.sendEmail')->with(compact('new_email'));
			}

			if ($request->password1 !== $request->password2) {
				return redirect(route('userEdit.edit'))->with('error', '新しいパスワードが一致しません');
			}

			if ($request->password1) {
				if (mb_strlen($request->password1, 'UTF-8') < 6) {
					return redirect(route('userEdit.edit'))->with('error', 'パスワードは6文字以上で入力して下さい');
				}
			}

			if ($request->password1 === $request->password2 && $request->password2 === $request->now_password) {
				return redirect(route('userEdit.edit'))->with('error', '現在のパスワードと同じなので登録できません');
			}

			if ($request->password1) {
				User::where('id', Auth::id())->update([
					'name' => $request->name,
					'password' => password_hash($request->password1, PASSWORD_BCRYPT),
				]);
				Auth::logout();
				return redirect(route('login'))->with('success', '編集しました');
			}
		} else {
			return redirect(route('userEdit.edit'))->with('error', '現在のパスワードが正しくありません');
		}
	}

	public function sendChangeEmailLink() {

		$new_email = session('new_email');

		//トークン生成
		$token = hash_hmac(
			'sha256',
			rand() . $new_email,
			config('app.key')
		);

		//トークンをDBに保存
		DB::beginTransaction();
		try {
			$email_reset = new EmailReset;
			$email_reset->user_id = Auth::id();
			$email_reset->new_email = $new_email;
			$email_reset->token = $token;
			$email_reset->save();

			DB::commit();

			$email_reset->sendEmailResetNotification($token);

			return redirect(route('home'))->with('success', '確認メールを送信しました');
		} catch (\Exception $e) {
			DB::rollback();
			return redirect(route('home'))->with('error', 'メール更新に失敗しました');
		}
	}

	public function reset(Request $request, $token) {

		$email_resets = EmailReset::where('token', $token)->first();

		$email_check = User::where('email', $email_resets->new_email)->first();

		if ($email_check) {
			return redirect(route('home'))->with('error', 'このメールアドレスは既に使用されているので登録できません');
		}
		//トークンが存在しているか、かつ有効期限がきれていないかチェック
		if ($email_resets && !$this->tokenExpired($email_resets->created_at)) {

			$user = User::find($email_resets->user_id);
			$user->email = $email_resets->new_email;
			$user->save();

			EmailReset::where('token', $token)->delete();

			return redirect(route('home'))->with('success', 'メールアドレスを更新しました');

		} else {
			if ($email_resets) {
				EmailReset::where('token', $token)->delete();
			}
			return redirect(route('home'))->with('error', 'メールアドレスの更新に失敗しました');
		}
	}

	protected function tokenExpired($createdAt) {

		$expires = 60 * 30;

		return Carbon::parse($createdAt)->addSeconds($expires)->isPast();
	}
}
