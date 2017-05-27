<?php

namespace app\Jobs;

use App\Jobs\Job;
use App\Models\User;
use Request;
use Illuminate\Contracts\Mail\Mailer;

class SendMail extends Job
{

    /**
     * User Model.
     *
     * @var App\Models\User
     */
    protected $user;

    /**
     * Create a new SendMailCommand instance.
     *
     * @param  App\Models\User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param  Mailer  $mailer
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $data = [
            'title'  => trans('site/verify.email-title'),
            'intro'  => trans('site/verify.email-intro'),
            'link'   => trans('site/verify.email-link'),
            'confirmation_code' => $this->user->confirmation_code
        ];

        $mailer->send('emails.auth.verify', $data, function($message) {
            $message->to($this->user->email, $this->user->username)
                    ->subject(trans('site/verify.email-title'));
        });
    }
}
