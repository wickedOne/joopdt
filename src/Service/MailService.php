<?php

declare(strict_types=1);

/*
 * This file is part of joopdt.nl.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Entity\Story;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Mail Service.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class MailService
{
    /**
     * @var \Symfony\Component\Mailer\MailerInterface
     */
    private $mailer;
    /**
     * @var \Symfony\Contracts\Translation\TranslatorInterface
     */
    private $translator;

    /**
     * @param string                                             $gmailUser
     * @param string                                             $gmailPass
     * @param \Symfony\Contracts\Translation\TranslatorInterface $translator
     */
    public function __construct(string $gmailUser, string $gmailPass, TranslatorInterface $translator)
    {
        $transport = new GmailSmtpTransport($gmailUser, $gmailPass);

        $this->mailer = new Mailer($transport);
        $this->translator = $translator;
    }

    /**
     * @param \App\Entity\Story $story
     *
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendStory(Story $story): void
    {
        $email = (new Email())
            ->from('jooptidooptie@gmail.com')
            ->to($story->getEmail())
            ->subject($story->getTitle() ?? $this->translator->trans('mailer.your.story'))
            ->text($story->getText())
        ;

        $this->mailer->send($email);
    }
}
