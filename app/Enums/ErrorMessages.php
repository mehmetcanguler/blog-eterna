<?php
namespace App\Enums;

enum ErrorMessages: string
{
    case EmailNotVerified = 'errors.email_not_verified';
    case TokenExpired = 'errors.token_expired';
    case EmailAlreadyVerified = 'errors.email_already_verified';
    case InvalidCredentials = 'errors.invalid_credentials';
    case Unauthenticated = 'errors.unauthenticated';
    case Unauthorized = 'errors.unauthorized';
    case MethodNotAllowed = 'errors.method_not_allowed';
    case ModelNotFound = 'errors.model_not_found';
    case NotFound = 'errors.not_found';
    case InternalServerError = 'errors.internal_server_error';
    case EmailRequired = 'errors.email_required';
    case PhoneRequired = 'errors.phone_required';
    case PhoneNotVerified = 'errors.phone_not_verified';
    case PhoneAlreadyVerified = 'errors.phone_already_verified';
    case InvalidVerificationCode = 'errors.invalid_verification_code';


    public function message(): string
    {
        return trans($this->value);
    }

}
