<?php

namespace ride\library\mail\template;

/**
 * Interface for a mail template.
 * A mail template is a preset for an outgoing mail. Recipients and variables
 * are replaced when the mail is actually being send.
 */
interface MailTemplate {

    /**
     * Symbol to open a variable
     * @var string
     */
    const VARIABLE_OPEN = '[[';

    /**
     * Symbol to close a variable
     * @var string
     */
    const VARIABLE_CLOSE = ']]';

    /**
     * Gets the id of this template
     * @return string
     */
    public function getId();

    /**
     * Gets the mail type of this template
     * @return \ride\library\mail\type\MailType
     */
    public function getMailType();

    /**
     * Gets the name of this mail template
     * @return string
     */
    public function getName();

    /**
     * Gets the subject for the mail of this template
     * @return string Subject of the mail
     */
    public function getSubject();

    /**
     * Gets the body for the mail of this template
     * @return string Body of the mail
     */
    public function getBody();

    /**
     * Gets the predefined attachments for the mail
     * @return array Array with relative or absolute paths
     */
    public function getAttachments();

    /**
     * Gets the display name of the sender
     * @return string
     */
    public function getSenderName();

    /**
     * Gets the email address of the sender
     * @return string
     */
    public function getSenderEmail();

    /**
     * Gets the recipients for the mail
     * @return array Array with the machine name of the recipients in the mail
     * type as value
     * @see \ride\library\mail\type\MailType
     */
    public function getRecipients();

    /**
     * Gets the CC mail addresses for the mail
     * @return array Array with the email address as key and an email address or
     * name <email address> as value
     */
    public function getCc();

    /**
     * Gets the BCC mail addresses for the mail
     * @return array Array with the email address as key and an email address or
     * name <email address> as value
     */
    public function getBcc();

}
