<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Sekou KOÏTA <sekou.koita@supinfo.com>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\NotificationBundle\Model;

use IDCI\Bundle\NotificationBundle\Entity\Notification;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class EmailNotification extends AbstractNotification
{
    /**
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    protected $to;

    /**
     */
    protected $cc;

    /**
     */
    protected $bcc;

    /**
     * @Assert\NotBlank()
     */
    protected $subject;

    /**
     * @Assert\NotBlank()
     */
    protected $message;

    /**
     *
     */
    protected $attachements;

    /**
     * @see NotificationInterface
     */
    public function getNotifierServiceName()
    {
        return "email_notifier";
    }

    /**
     * @see NotificationInterface
     */
    public function toNotification()
    {
        $notification = parent::toNotification()
            ->setTo(array(
                'to' => $this->getTo(),
                'cc' => $this->getCc(),
                'bcc' => $this->getBcc()
            ))
            ->setContent(array(
                'subject' => $this->getSubject(),
                'message' => $this->getMessage(),
                'attachements' => $this->getAttachements()
            ))
        ;

        return $notification;
    }

    /**
     * @see NotificationInterface
     */
    public function fromNotification(Notification $notificationEntity)
    {
        parent::fromNotification($notificationEntity);

        $to      = $notificationEntity->getTo();
        $content = $notificationEntity->getContent();

        $this
            ->setTo($to['to'])
            ->setCc($to['cc'])
            ->setBcc($to['bcc'])
            ->setSubject($content['subject'])
            ->setMessage($content['message'])
            ->setAttachements($content['attachements'])
        ;
    }

    /**
     * SetTo
     *
     * @param string $to
     * @return EmailNotification
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Get to
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set cc
     *
     * @param string $cc
     * @return EmailNotification
     */
    public function setCc($cc)
    {
        $this->cc = $cc;

        return $this;
    }

    /**
     * Get cc
     *
     * @return string
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * Set bcc
     *
     * @param string $bcc
     * @return EmailNotification
     */
    public function setBcc($bcc)
    {
        $this->bcc = $bcc;

        return $this;
    }

    /**
     * Get bcc
     *
     * @return string
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return EmailNotification
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return EmailNotification
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set attachements
     *
     * @param string $attachements
     * @return EmailNotification
     */
    public function setAttachements($attachements)
    {
        $this->attachements = $attachements;

        return $this;
    }

    /**
     * Get attachements
     *
     * @return string
     */
    public function getAttachements()
    {
        return $this->attachements;
    }
}
