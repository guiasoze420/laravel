<?php

namespace App;

use App\Notifications\ChangeEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EmailReset extends Model {
	use Notifiable;

	protected $fillable = [

		'user_id',
		'new_email',
		'token',
	];

	//メールアドレス確定メール送信
	public function sendEmailResetNotification($token) {
		$this->notify(new ChangeEmail($token));
	}

	//新しいメールアドレス宛にメール送信
	public function routeNotificationForMail() {
		return $this->new_email;
	}
}
