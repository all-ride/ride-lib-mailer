<?php

namespace ride\library\mail\handler;

use ride\library\mail\template\MailTemplate;

/**
 * Interface for a mail handler.
 * The mail handler is actually performing the sending of the mail, using a
 * queue or directly, or ... is up to the implementation itself.
 */
interface MailHandler {

    /**
     * Performs the sending of a mail
     * @param MailTemplate $mailTemplate Instance of a mail template
     * @param array $contentVariables Array with the name of the variable as key
     * and the variable value as array value. All variables defined in the mail
     * type must be present.
     * @param array $recipientVariables Array with the name of the recipient as
     * key and the actual recipient as value. All recipients defined in the mail
     * type must be present.
     * @return null
     * @throws \ride\library\mail\exception\MailException when the mail could
     * not be send
     * @see \ride\library\mail\type\MailType
     */
    public function sendMail(MailTemplate $mailTemplate, array $contentVariables, array $recipientVariables);

}
