<?php

namespace App\Models\Presenters;

use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

trait UserPresenter
{
    public function verifyEmailLink()
    {
        return clientUrl("email-verify?email={$this->email}&token={$this->email_verify_token}");
    }

    public function generateVerificationToken()
    {
        return $this->update(['email_verify_token' => (string) Uuid::uuid4()]);
    }

    public function avatarUrl()
    {
        return $this->avatar
            ? Storage::disk(config('filesystems.default'))->url($this->avatar)
            : null;
    }
}
