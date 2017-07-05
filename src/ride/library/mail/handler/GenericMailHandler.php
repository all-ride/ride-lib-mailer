<?php

namespace ride\library\mail\handler;

use ride\library\mail\exception\MailException;
use ride\library\mail\exception\RecipientNotFoundMailException;
use ride\library\mail\exception\VariableNotFoundMailException;
use ride\library\mail\template\MailTemplate;
use ride\library\mail\transport\Transport;
use ride\library\system\file\browser\FileBrowser;

/**
 * Generic implementation for a mail handler.
 * The mail handler is actually performing the sending of the mail, using a
 * queue or directly, or ... is up to the implementation itself.
 */
class GenericMailHandler implements MailHandler {

    /**
     * Instance of the mail transport
     * @var \ride\library\mail\transport\Transport
     */
    private $transport;

    /**
     * Instance of the file browser to lookup attachments
     * @var \ride\library\system\file\browser\FileBrowser
     */
    private $fileBrowser;

    /**
     * Constructs a new mail handler
     * @param \ride\library\mail\transport\Transport $transport
     * @param \ride\library\system\file\browser\FileBrowser $fileBrowser
     * @return null
     */
    public function __construct(Transport $transport, FileBrowser $fileBrowser) {
        $this->transport = $transport;
        $this->fileBrowser = $fileBrowser;
    }

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
    public function sendMail(MailTemplate $mailTemplate, array $contentVariables, array $recipientVariables) {
        $mailType = $mailTemplate->getMailType();

        $this->checkContentVariables($mailType->getContentVariables(), $contentVariables);
        $this->checkRecipientVariables($mailType->getRecipientVariables(), $recipientVariables);

        $from = $this->parseVariables($contentVariables, $mailTemplate->getSenderName()) . ' <' . $this->parseVariables($recipientVariables, $mailTemplate->getSenderEmail()) . '>';
        $subject = $this->parseVariables($contentVariables, $mailTemplate->getSubject());
        $body = $this->parseVariables($contentVariables, $mailTemplate->getBody());
        $recipients = $this->parseVariablesInArray($recipientVariables, $mailTemplate->getRecipients(), false);
        $cc = $this->parseVariablesInArray($recipientVariables, $mailTemplate->getCc());
        $bcc = $this->parseVariablesInArray($recipientVariables, $mailTemplate->getBcc());

        $message = $this->transport->createMessage();
        $message->setIsHtmlMessage(true);
        $message->setReplyTo($from);
        $message->setSubject($subject);
        $message->setMessage($body);
        $message->setTo($recipients);
        $message->setCc($cc);
        $message->setBcc($bcc);

        $attachments = $mailTemplate->getAttachments();
        foreach ($attachments as $attachment) {
            $file = $this->fileBrowser->getFile($attachment);
            if (!$file) {
                continue;
            }

            $message->addAttachment($file);
        }

        $this->transport->send($message);
    }

    /**
     * Parses the provided variables in the provided array values
     * @param array $variables Array with the variable name as key and the
     * replacement as value
     * @param array $array Array with the strings to parse as value
     * @return array Provided array with the variables replaced
     */
    private function parseVariablesInArray(array $variables, array $array = null, $useVariableTokens = true) {
        if ($array === null) {
            return array();
        }

        foreach ($array as $key => $value) {
            $array[$key] = $this->parseVariables($variables, $value, $useVariableTokens);
        }

        return $array;
    }

    /**
     * Parses the provided variables in the provided string
     * @param array $variables Array with the variable name as key and the
     * replacement as value
     * @param string $string String to apply the variables in
     * @return string Provided string with the variables replaced
     */
    private function parseVariables(array $variables, $string, $useVariableTokens = true) {
        foreach ($variables as $variable => $value) {
            if ($useVariableTokens) {
                $string = str_replace(MailTemplate::VARIABLE_OPEN . $variable . MailTemplate::VARIABLE_CLOSE, $value, $string);
            } else {
                $string = str_replace($variable, $value, $string);
            }
        }

        return $string;
    }

    /**
     * Checks the content variables
     * @param array $availableVariables Variables which are available in the
     * mail type
     * @param array $providedVariables Variables provided by the send logic
     * @return null
     * @throws \ride\library\mail\exception\VariableNotFoundException when an
     * available variable of the mail type is not provided by the send logic
     */
    private function checkContentVariables(array $availableVariables, array $providedVariables) {
        foreach ($availableVariables as $variable => $translation) {
            if (!array_key_exists($variable, $providedVariables)) {
                throw new VariableNotFoundMailException('Variable ' . $variable . ' is missing in the provided content variables');
            }
        }
    }

    /**
     * Checks the recipient variables
     * @param array $availableRecipients Recipients which are available in the
     * mail type
     * @param array $providedRecipients Recipients provided by the send logic
     * @return null
     * @throws \ride\library\mail\exception\RecipientNotFoundException when an
     * available recipient of the mail type is not provided by the send logic
     */
    private function checkRecipientVariables(array $availableRecipients, array $providedRecipients) {
        foreach ($availableRecipients as $recipient => $translation) {
            if (!array_key_exists($recipient, $providedRecipients)) {
                throw new RecipientNotFoundMailException('Recipient ' . $recipient . ' is missing in the provided recipient variables');
            }
        }
    }

}
