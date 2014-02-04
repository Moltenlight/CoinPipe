<?php
require_once('jsonRPCClient.php');
require_once('recaptchalib.php');
require_once('config.php');
$bitcoin = new jsonRPCClient("http://" . $username . ":" . $password . "@" . $daemonIP . ":" . $port . "/");
?>

<!doctype html>
<html>
    <head>
        <title>
            GBN SteamPipe :: Halleluja!
        </title>
        <link href="./style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
            var RecaptchaOptions = {
                                       theme : 'blackglass'
                                   };
        </script>
    </head>

    <body>
        <div id="box">
            <h1>Pipe Information</h1>
            <table id="info">
                <tr>
                    <td>Donation Address:</td>
                    <td width="50%">7dmJUbfShQ6RiasRkoq7ptVPDSWY4n6doZ</td>
                </tr>
                <tr>
                    <td>Balance:</td>
                    <td width="50%"><?php echo $bitcoin->getbalance($username); ?> GBN</td>
                </tr>
            </table>
            <h1>PLEASE DONATE TO THIS ADDRESS TO FILL THE STEAMPIPE ! ! !</h1>
        </div>
        <br />
        <div id="box">
            <strong>Q:</strong> Help! How do I start this GabenCoin wallet crypto thingy!?<br />
            <strong>A:</strong> Read the wiki over <a href="http://www.reddit.com/r/gaben_coin/wiki/">here</a>.<br />
            <br />
            <strong>Q:</strong> How many coins can I get and how many times can I drain the pipe?<br />
            <strong>A:</strong> Every 24 hours you can get 3.33% of the pipe's balance, with a maximum of 33.3 GBN.<br />
            <br />
            <strong>Q:</strong> How can I contact you?<br />
            <strong>A:</strong> You can find my details on my <a href="https://github.com/Shammah">GitHub</a>.<br />
            <br />
            <strong>Q:</strong> What is your favorite color?<br />
            <strong>A:</strong> GabeN.
        </div>
        <br />
        <div id="box">
            <form action="pipe.php" method="post">
                Your Address: <input type="text" name="address" size=40><br /><br />
                <div align="center"><?php echo recaptcha_get_html($publickey); ?></div><br />
                <input type="submit" value="May the lord shine upon me!">
            </form>
        </div>
        <br />
        <div id="box">
            <h1>Latest 50 enrichenings. Negative numbers are deposits.</h1>
            <table id="hist">
                <tr>
                    <td><h2>Time (DD/MM/YYYY)</h2></td>
                    <td><h2>Address</h2></td>
                    <td><h2>Amount</h2></td>
                </tr>

<?php

$transactions = $bitcoin->listtransactions($username, 50);
$transactions = array_reverse($transactions);

foreach ($transactions as $t)
{
    echo "<tr>";
    echo "<td id=\"hl\">", date("d/m/y H:i:s", $t["time"]), "</td>";
    echo "<td id=\"hc\">", $t["address"], "</td>";
    echo "<td id=\"hr\">", -1 * $t["amount"],"</td>"; // -1 because opposite world!
    echo "</tr>";
}

?>

            </table>
        </div>
</body>
</html>
