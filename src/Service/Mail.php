<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mail
{

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;

    }

    public function sendEmail(
        string $from,
        string $subject,
        string $message,
        string $to = 'admin@bioladen.com',
    )
    {
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->text($message);

        $this->mailer->send($email);
    }

}