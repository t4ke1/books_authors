<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailService
{
    public function __construct(
        private MailerInterface $mailer,
        private string $emailSender
    ) {
    }

    public const SUBJECT_VERIFY_CODE = 'You verify code: ';
    public const SUBJECT_RESET_CODE = 'You reset password code: ';

    /**
     * @throws TransportExceptionInterface
     */
    public function sendCode(string $subject, string $email, int $code): void
    {
        $message = (new Email())
            ->from($this->emailSender)
            ->to($email)
            ->subject($subject)
            ->text($subject.$code);

        $this->mailer->send($message);
    }
}
