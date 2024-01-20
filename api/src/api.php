<?php

use GuzzleHttp\Client;

const BASE_URL = "https://wol.jw.org";
require_once '../vendor/autoload.php';

$client = new Client();

$test = 1;

if ($test = 1) {
    $rawHTML = file_get_contents("test.html");
} else {
    $url = BASE_URL . "/fr/wol/meetings/r30/lp-f/" .date("Y")."/".date("W");
    $rawHTML = $response = $client->get($url);
}

$sanitizedHtml = preg_replace("/&(?!\S+;)/", "&amp;", $rawHTML);
$doc = new DOMDocument();
$doc->loadHTML($sanitizedHtml);

$xpath = new DOMXpath($doc);
$link = $xpath->query('//div[contains(@class, "pub-w")]//a[@class="it"]/@href')->item(0);

if ($test = 1) {
    $tgRawHtml = file_get_contents('tg.html');
} else {
    $tgRawHtml = $client->get(BASE_URL. $link->nodeValue)->getBody();
}

$sanitizedHtml = preg_replace("/&(?!\S+;)/", "&amp;", $tgRawHtml);
$doc = new DOMDocument();
$doc->loadHTML($sanitizedHtml);


$xpath = new DOMXpath($doc);
$title = $xpath->query('//div[@class="pubNavTitle"]//li[contains(@class, "resultDocumentPubTitle")]')->item(0);


$subTitles = $xpath->query('//ul[@role="navigation"]/li');

var_dump($subTitles);