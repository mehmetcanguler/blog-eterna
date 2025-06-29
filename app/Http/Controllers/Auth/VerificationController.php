<?php

namespace App\Http\Controllers\Auth;

use App\Enums\ErrorMessages;
use App\Enums\LoginType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyCodeRequest;
use App\Services\External\EmailVerificationService;
use App\Services\External\SmsVerificationService;
use App\Services\External\VerificationService;
use App\Support\Helpers\ApiResponse;
use Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function __construct(
        protected EmailVerificationService $emailVerificationService,
        protected SmsVerificationService $smsVerificationService
    ) {
    }

    public function verifyCode(VerifyCodeRequest $request)
    {
        $user = Auth::user();

        $this->smsVerificationService->verifyContact($user, $request->code);

        return ApiResponse::success();
    }

    public function send(Request $request)
    {
        $user = Auth::user();

        match ($user->login_type) {
            LoginType::EMAIL => $this->emailVerificationService->sendVerification($user),
            LoginType::PHONE => $this->smsVerificationService->sendVerification($user)
        };


        return ApiResponse::success();
    }

    public function verificationVerify(string $id, string $hash)
    {
        $this->emailVerificationService->verify($id, $hash);

        return redirect(env('FRONT_URL'));
    }

}
