# Ride: Mailer Library

Library to offer editable templates for mails in the PHP Ride framework.

## What's In This Library

### MailType

The _MailType_ interface specifies an available mail.
It can be considered an event which is triggered when certain business logic occurs. 
They are defined by the system/developer.
Eg. A user is registered; A user is activated; An inquiry is requested; ...

### MailTypeProvider

The _MailTypeProvider_ interface is used for the data storage of mail types.
Use it to retrieve a single or all mail types.

### MailTemplate

The _MailTemplate_ interface represents a preset of an outgoing mail.
Recipients and variables are defined by it and are replaced by the actual values when the mail is being send.

### MailTemplateProvider

The _MailTemplateProvider_ interface is used for the data store of mail templates.
Use it o retrieve a single or all mail templates.

### MailHandler

The _MailHandler_ interface is responsible for filling in the variables and sending the mail.

### MailService

The _MailService_ class is a facade to this library.
You can use this class to retrieve the providers or send a mail.

## Code Sample

Check the following code sample to some of the possibilities of this library.

```php
<?php

use ride\service\MailService;

function sendMail(MailService $mailService) {
    $contentVariables = array('user' => 'My User', 'url' => 'http://www.github.com');
    $recipientVariables = array('recipient1' => 'user@domain.com', 'recipient2' => 'john@doe.com');
    $mailTemplate = 5;
    $locale = 'en';

    $mailService->sendMailTemplate($contentVariables, $recipientVariables, $mailTemplate, $locale);
}
```

## Related Modules

- [ride/app-mailer](https://github.com/all-ride/ride-app-mailer)
- [ride/app-mailer-orm](https://github.com/all-ride/ride-app-mailer-orm)
- [ride/lib-mail](https://github.com/all-ride/ride-lib-mail)
- [ride/wba-mailer](https://github.com/all-ride/ride-wba-mailer)

## Installation

You can use [Composer](http://getcomposer.org) to install this library.

```
composer require ride/lib-mailer
```
