<?php
return [
    'class' => 'Swift_SmtpTransport',
    'host' => $_ENV['EMAIL_HOST'],
    'username' => $_ENV['EMAIL_USERNAME'],
    'password' => $_ENV['EMAIL_PASSWORD'],
    'port' => $_ENV['EMAIL_PORT'],
    'encryption' => 'tls',
];
