
<?php

require __DIR__ . '/vendor/autoload.php';

$keys = \Minishlink\WebPush\VAPID::createVapidKeys();

echo "PUBLIC KEY: " . $keys['publicKey'] . PHP_EOL;
echo "PRIVATE KEY: " . $keys['privateKey'] . PHP_EOL;
