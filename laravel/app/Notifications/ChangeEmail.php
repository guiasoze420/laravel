<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ChangeEmail extends Notification {
	use Queueable;
	public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
	//通知内容を生成する情報源を受け取る
    public function __construct($token) {
		$this->token = $token;
	}
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
	//通知方法選択
    public function via($notifiable) {
		return ['mail'];
	}
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
		return (new MailMessage)
			->subject('メールアドレス変更') //件名
			->view('userEdit.send_mail') //メールテンプレートの指定
			->action(
			'メールアドレス変更',
			url('userEdit/reset', $this->token) //アクセスするURL
			);
	}
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
		return [
		];
	}
}
