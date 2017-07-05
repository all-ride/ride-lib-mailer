<?php

namespace ride\library\mail\template;

use ride\library\mail\type\MailType;

/**
 * Interface for the provider/data source of the mail templates.
 */
interface MailTemplateProvider {

    /**
     * Gets the available mail templates
     * @param array $options Options to fetch the mail templates. Available keys
     * are locale, query, limit, offset.
     * @return array Array with the id or machine name of the mail template as
     * key and an instance of the mail template as value
     * @see \ride\library\mail\template\MailTemplate
     */
    public function getMailTemplates(array $options);

    /**
     * Gets the available mail templates for a specific mail type
     * @param \ride\library\mail\type\MailType $mailType Instance of the mail
     * type to filter on
     * @param string $locale Code of the locale
     * @return array Array with the id or machine name of the mail template as
     * key and an instance of the mail template as value
     * @see \ride\library\mail\template\MailTemplate
     */
    public function getMailTemplatesForType(MailType $mailType, $locale = null);

    /**
     * Gets a specific mail type
     * @param string $id Id or machine name of the mail template
     * @return MailType Instance of the mail template
     * @throws \ride\library\mail\exception\TemplateNotFoundMailException when
     * the mail template does not exist
     */
    public function getMailTemplate($id, $locale);

    /**
     * Creates a new mail template
     * @param string $locale Code of the locale
     * @return \ride\library\mail\template\MailTemplate
     */
    public function createMailTemplate($locale);

    /**
     * Saves the provided mail template in the data store
     * @param \ride\library\mail\template\MailTemplate $mailTemplate
     * @return null
     */
    public function saveMailTemplate(MailTemplate $mailTemplate);

    /**
     * Deletes the provided mail template from the data store
     * @param \ride\library\mail\template\MailTemplate $mailTemplate
     * @return null
     */
    public function deleteMailTemplate(MailTemplate $mailTemplate);

}
