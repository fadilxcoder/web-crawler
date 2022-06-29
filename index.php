<?php

require 'vendor/autoload.php';

use Goutte\Client;
use Tracy\Debugger as Debugger;

$client = new Client();
Debugger::enable(Debugger::DEVELOPMENT);

#####                         ALERT                            #####
dump('Use CLI or comment this line to allow script execution !');die;

const STREAM_URL = 'https://french-stream.re/serie/15608-person-of-interest-saison-1-streaming-complet-vf-vostfr.html';

$crawler = $client->request('GET', STREAM_URL);

$hrefs = $crawler->filter('div.elink .fstab')->each(function ($node) {
    return $node->attr('href');
});

$titles = $crawler->filter('div.elink .fstab')->each(function ($node) {
    return $node->text();
});

dump(array_combine($titles, $hrefs));