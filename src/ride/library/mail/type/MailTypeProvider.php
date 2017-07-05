<?php

namespace ride\library\mail\type;

/**
 * Interface for the provider of the mail types
 */
interface MailTypeProvider {

    /**
     * Gets the available mail types
     * @return array Array with the machine name of the mail type as key and an
     * instance of the mail type as value
     */
    public function getMailTypes();

    /**
     * Gets a specific mail type
     * @param string $name Machine name of the mail type
     * @return MailType Instance of the mail type
     * @throws TypeNotFoundMailException when the mail type does not exist
     */
    public function getMailType($name);

}
