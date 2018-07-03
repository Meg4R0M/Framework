<?php
namespace App\Auth\Mailer;

use Framework\Renderer\RendererInterface;

/**
 * Class PasswordResetMailer
 * @package App\Auth\Mailer
 */
class PasswordResetMailer
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var string
     */
    private $from;

    /**
     * PasswordResetMailer constructor.
     * @param \Swift_Mailer $mailer
     * @param RendererInterface $renderer
     * @param string $from
     */
    public function __construct(\Swift_Mailer $mailer, RendererInterface $renderer, string $from)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
        $this->from = $from;
    }

    /**
     * @param string $to
     * @param array $params
     */
    public function send(string $to, array $params): void
    {
        $message = new \Swift_Message(
            'Réinitialisation de votre mot de passe',
            $this->renderer->render('@auth/email/password.text', $params)
        );
        $message->addPart($this->renderer->render('@auth/email/password.html', $params), 'text/html');
        $message->setTo($to);
        $message->setFrom($this->from);
        $this->mailer->send($message);
    }
}
