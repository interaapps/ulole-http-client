<?php
// Init
use de\interaapps\ulole\httpclient\HttpClient;

chdir(".");;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
(require_once './autoload.php')();

// Testing
echo "Testing:\n";

$test = new HttpClient();
$test->header("Hey", "World");
try {
    var_dump($test->post("https://ping.intera.dev", ["aaaaaaaa" => "#######################"])->query("Hey", "World")->send()->json());
    assert(false, "ERR");
} catch (\de\interaapps\ulole\httpclient\exceptions\HttpException $e) {
    echo "\n {$e->getMessage()} \n";
}