<?php

namespace App\Http\Controllers;

use App\Models\DiscordWebhookMessage;
use Illuminate\Http\Request;

class DashboardRecruitersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','recruiters']);
    }

    public function __invoke(){
        return view('recruiters.dashboard.index');
    }

    public function SendWebhook() {
        $Message = new DiscordWebhookMessage(env('APP_WEB_HOOK_SESSION_URL'));
        $Message->SendWebhookRecruitementSession();
    }
}
