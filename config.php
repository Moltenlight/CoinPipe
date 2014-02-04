<?php

$time               = 86400;                  // The time in seconds before somebody can get another hit from the pipe. (Huehuehuehue)
$payoutMultiplier   = 0.0333;                 // The percentage of the wallet the user will get.
$payoutMax          = 33.3;                   // The maximum amount of coin the user can get.


$username           = "username";             // Username of the wallet account.
$password           = "password";             // Password of the wallet account.
$daemonIP           = "127.0.0.1";            // Address of the bitcoind / whatevercoind. If the daemon runs local, keep this at 127.0.0.1
$port               = "7331";                 // The port the daemon accepting connections from. Check your daemon config files.
$dbName             = "pipehitters.db";       // Filename of the database that will keep track of who took coins at what time.

$publickey          = "your google captcha public key goes here.";
$privatekey         = "your google captcha private key goes here.";
?>
