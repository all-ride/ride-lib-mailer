<?php

namespace ride\service;

use ride\library\mail\exception\MailException;
use ride\library\mail\handler\MailHandler;
use ride\library\mail\template\MailTemplateProvider;
use ride\library\mail\template\MailTemplate;
use ride\library\mail\type\MailTypeProvider;

/**
 * Service for the mail template functions
 */
class MailService {

    /**
     * Instance of the mail type provider
     * @var \ride\library\mail\type\MailTypeProvider
     */
    protected $mailTypeProvider;

    /**
     * Instance of the mail template provider
     * @var \ride\library\mail\template\MailTemplateProvider
     */
    protected $mailTemplateProvider;

    /**
     * Instance of the mail handler provider
     * @var \ride\library\mail\handler\MailHandler
     */
    protected $mailHandler;

    /**
     * Constructs the mail service
     * @param \ride\library\mail\type\MailTypeProvider $mailTypeProvider
     * @param \ride\library\mail\template\MailTemplateProvider $mailTemplateProvider
     * @param \ride\library\mail\handler\MailHandler $mailHandler
     * @return null
     */
    public function __construct(MailTypeProvider $mailTypeProvider, MailTemplateProvider $mailTemplateProvider, MailHandler $mailHandler) {
        $this->mailTypeProvider = $mailTypeProvider;
        $this->mailTemplateProvider = $mailTemplateProvider;
        $this->mailHandler = $mailHandler;
    }

    /**
     * Gets the mail type provider
     * @return \ride\library\mail\type\MailTypeProvider
     */
    public function getMailTypeProvider() {
        return $this->mailTypeProvider;
    }

    /**
     * Gets the mail template provider
     * @return \ride\library\mail\template\MailTemplateProvider
     */
    public function getMailTemplateProvider() {
        return $this->mailTemplateProvider;
    }

    /**
     * Performs the sending of a mail
     * @param array $contentVariables Array with the name of the variable as key
     * and the variable value as array value. All variables defined in the mail
     * type must be present.
     * @param array $recipientVariables Array with the name of the recipient as
     * key and the actual recipient as value. All recipients defined in the mail
     * type must be present.
     * @param \ride\library\mail\template\MailTemplate|string $mailTemplate Id
     * or instance of a mail template
     * @param string $locale Code of the locale, only needed when a mail
     * template id is provided
     * @return \ride\library\mail\handler\MailStatus Result or status of the
     * mail
     * @see \ride\library\mail\type\MailType
     */
    public function sendMailTemplate(array $contentVariables, array $recipientVariables, $mailTemplate, $locale = null) {
        if (!$mailTemplate instanceof MailTemplate) {
            if ($locale === null) {
                throw new MailException('Could not fetch the mail template: no locale provided');
            }

            $mailTemplate = $this->mailTemplateProvider->getMailTemplate($mailTemplate, $locale);
        }

        return $this->mailHandler->sendMail($mailTemplate, $contentVariables, $recipientVariables);
    }

}
