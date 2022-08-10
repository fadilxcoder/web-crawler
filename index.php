<?php

require 'vendor/autoload.php';

use Goutte\Client;
use Tracy\Debugger as Debugger;

$client = new Client();
Debugger::enable(Debugger::DEVELOPMENT);

#####                         ALERT                            #####
dump('Use CLI or comment this line to allow script execution !');die;


### TV SHOW CRAWLER ###


const STREAM_URL = 'https://french-stream.re/serie/15608-person-of-interest-saison-1-streaming-complet-vf-vostfr.html';

$crawler = $client->request('GET', STREAM_URL);

$hrefs = $crawler->filter('div.elink .fstab')->each(function ($node) {
    return $node->attr('href');
});

$titles = $crawler->filter('div.elink .fstab')->each(function ($node) {
    return $node->text();
});

dump(array_combine($titles, $hrefs)); die;


### WEBSITE CONTENT CRAWLER ###


const ALB_WTC = 'https://www.alibaba.com/countrysearch/CN/mens-watches.html';

$crawler = $client->request('GET', ALB_WTC);

$names = $crawler->filter('.m-gallery-product-item .item-info .title a')->each(function ($node) {
    return $node->text();
});

dump($names); die;


### LOCAL APP CRAWLER ###


$url = 'http://front.symfony.car-rental.local/';

loginSuccess($url, $client);

loginFail($url, $client);


function loginSuccess($url, $client): void
{
    # SUCCESS
    $crawler = $client->request('GET', $url);
    $crawler = $client->click($crawler->selectLink('Login')->link());
    $form = $crawler->selectButton('Log In')->form();
    $crawler = $client->submit($form, ['email' => 'feil.aditya@gmail.com', 'password' => 'admin123']);
    $crawler->filter('.mainmenu > ul:last-child > li:last-child')->each(function ($node) {
        dump($node->text());
    });
    $client->click($crawler->selectLink('Logout')->link());
}

function loginFail($url, $client): void
{
    # FAIL
    $crawler = $client->request('GET', $url);
    $crawler = $client->click($crawler->selectLink('Login')->link());
    $form = $crawler->selectButton('Log In')->form();
    $crawler = $client->submit($form, ['email' => 'no-user@gmail.com', 'password' => 'xxx']);
    $crawler->filter('.alert-danger')->each(function ($node) {
        dump($node->text());
    });
}