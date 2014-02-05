
<!doctype html>
<html>
    <head>
        <title>
            GBN SteamPipe :: Halleluja!
        </title>
        <link href="./style.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div id="box">

<?php
require_once('jsonRPCClient.php');
require_once('recaptchalib.php');
require_once('config.php');

// ----------------------------------------------------------------------------
// Let's do some captcha checking first, to filter out the laziest bots.
// ----------------------------------------------------------------------------
$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

if (!$resp->is_valid)
{
  // What happens when the CAPTCHA was entered incorrectly
  die ("The reCAPTCHA wasn't entered correctly. Go back and try it again. (reCAPTCHA said: " . $resp->error . ")");
}

// ----------------------------------------------------------------------------
// Now it's time to block off any TOR locations. Sorry mates!
// ----------------------------------------------------------------------------
if (gethostbyname(ReverseIPOctets($_SERVER['REMOTE_ADDR']).".".$_SERVER['SERVER_PORT'].".".ReverseIPOctets($_SERVER['SERVER_ADDR']).".ip-port.exitlist.torproject.org")=="127.0.0.2")
{
    exit("Sorry, but TOR users cannot be enlightened because of possible exploitation :(");
}

function ReverseIPOctets($inputip)
{
    $ipoc = explode(".",$inputip);
    return $ipoc[3].".".$ipoc[2].".".$ipoc[1].".".$ipoc[0];
}

// ----------------------------------------------------------------------------
// Fetch IP and adress, and check whether the address is a valid one with a regex.
// ----------------------------------------------------------------------------
$ip      = $_SERVER['REMOTE_ADDR'];
$address = $_POST["address"];

if (!preg_match("/^7[A-Za-z0-9]{26,33}/", $address))
{
    exit("You have not entered a valid GBN address.");
}

// ----------------------------------------------------------------------------
// Define the function that will be used to actually send the coins.
// ----------------------------------------------------------------------------
function send($addr)
{
    global $username;
    global $password;
    global $daemonIP;
    global $port;
    $bitcoin = new jsonRPCClient("http://" . $username . ":" . $password . "@" . $daemonIP . ":" . $port . "/");
    
    global $payoutMultiplier;
    global $payoutMax;
    $balance = $bitcoin->getbalance($username);
    $payout  = min($balance * $payoutMultiplier, $payoutMax);

    $bitcoin->sendfrom($username, $addr, $payout);
    return $payout;
}

// ----------------------------------------------------------------------------
// Try to find the user from the databse by either looking for his IP or Wallet Address.
// If there's no result, add him to the database and send him coins.
// If he's in the database, check if he can be replenished.
// If he can be replenished, send him coins and update his timestamp.
// ---------------------------------------------------------------------------
$db = new SQLite3($dbName);
$lookup = $db->prepare("SELECT last FROM ascendants WHERE ip = :ip OR address = :address;");
$lookup->bindValue(":ip", $ip, SQLITE3_TEXT);
$lookup->bindValue(":address", $address, SQLITE3_TEXT);

$result = $lookup->execute()->fetchArray();

if ($result != FALSE)
{ 
    // User has already drained the faucet before.
    if (time() - $result["last"] >= $time)
    {
	$replenish = $db->prepare("UPDATE ascendants SET last = :last WHERE ip = :ip OR address = :address");
        $replenish->bindValue(":ip", $ip, SQLITE3_TEXT);
        $replenish->bindValue(":address", $address, SQLITE3_TEXT);
        $replenish->bindValue(":last", time(), SQLITE3_INTEGER);
        $replenish->execute();

        echo "You have been replenished with ", send($address), " GBN!";
    }

    else
    {
        echo "I'm sorry, but you need to wait ", $time - (time() - $result["last"]), " seconds before you can get more holyness.";
    }
}

else
{ 
    $ascendant = $db->prepare("INSERT INTO ascendants VALUES(:ip, :address, :last);");
    $ascendant->bindValue(":ip", $ip, SQLITE3_TEXT);
    $ascendant->bindValue(":address", $address, SQLITE3_TEXT);
    $ascendant->bindValue(":last", time(), SQLITE3_INTEGER);
    $ascendant->execute();

    echo "You have been enlightened with ", send($address), " GBN!";
} 

$db->close();

?>

        </div>
    </body>
</html>
