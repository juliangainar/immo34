<?php

namespace App\Notification;

use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class ContactNotification{

    private $mailer;
    private $renderer;

    /**
     * @param Environment $renderer
     * @param MailerInterface $mailer
     */
    public function __construct(Environment $renderer, MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }


    public function notify(Contact $contact){
        $message = (new Email())
            ->From('noreply@server.com')
            ->To($contact->getEmail())
            ->Subject('Nouvelle demande d\'informations pour un bien')
            ->Html($this->renderer->render('emails/contact.html.twig',[
                'contact' => $contact
            ]), 'text/html');
        $this->mailer->send($message, null);
    }
}

