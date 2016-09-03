<?php
/**
 * 
 * User: wissem
 * Date: 15/12/2014
 * Time: 21:44
 * Email: wissemr@gmail.com
 */

namespace Covoiturage\FrontendBundle\Helper;


class MailingHelper
{
    private $mailer;

    private $from;

    private $to;

    private $subject;

    private $body;

    public function __construct($mailer, $to ,$from,$subject, $body)
    {
        $this->mailer = $mailer;
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
    }

    public function send()
    {

        $message = \Swift_Message::newInstance()

        ->setSubject($this->subject)
        ->setFrom($this->from)
        ->setTo($this->to)
        ->setBody($this->body)
        ;
        
        $this->mailer->send($message);
    }

} 