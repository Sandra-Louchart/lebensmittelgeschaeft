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

    public function succesEmail(
        string $to,
    )
    {
        $email = (new Email())
            ->from('Bioladen@bio.com')
            ->to($to)
            ->subject('Danke für Ihren Einkauf!')
            ->text('Vielen Dank für Ihren Einkauf. Sie können Ihre Bestellung direkt in Ihrem Konto verfolgen');

        $this->mailer->send($email);

    }

    public function cancelEmail(
        string $to,
    )
    {
        $email = (new Email())
            ->from('Bioladen@bio.com')
            ->to($to)
            ->subject('Fehlerbestätigung')
            ->text('Ihre Bestellung konnte nicht validiert werden');

        $this->mailer->send($email);

    }

}