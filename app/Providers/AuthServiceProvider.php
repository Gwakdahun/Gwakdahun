<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */

    public function boot(): void
    {
        VerifyEmail::toMailUsing(function ($notifiable, $url) {

            // 메일 URL 제한시간
            // temporarySignedRoute : 서명된 임시 url이며 laravel 헬퍼함수이다.
            $url = URL::temporarySignedRoute(
                'verification.verify', Carbon::now()->addMinutes(10), ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
            );

            // 메일 내용
            return (new MailMessage)
                ->subject('인증 메일이 도착했습니다.')
                ->line('인증 버튼을 클릭 시 로그인이 가능합니다.')
                ->action('인증버튼', $url);
        });
    }
}
