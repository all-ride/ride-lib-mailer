<?php

namespace ride\library\mail\type;

/**
 * Interface for a mail type.
 * The availalble mail types can be considered events which are triggered when
 * certain business logic occurs. These are defined by the system/developer.
 * Eg. A user is registered; A user is activated; An inquiry is requested; ...
 */
interface MailType {

    /**
     * Gets the machine name of this mail type
     * @return string
     */
    public function getName();

    /**
     * Gets the avaiable content variables for this mail type. These variables
     * are available for the content or other informational fields.
     * @return array Array with the name of the variable as key and a
     * translation for the human friendly name as value
     */
    public function getContentVariables();

    /**
     * Gets the available recipient variables for this mail type. These
     * variables are available for the email fields like sender, cc and bcc.
     * They will be translated into real recipients when sending the mail.
     * @return array Array with the name of the variable as key and a
     * translation for the human friendly name as value
     */
    public function getRecipientVariables();

}
