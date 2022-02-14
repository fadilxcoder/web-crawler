<?php

require 'vendor/autoload.php';

use Goutte\Client;
use Tracy\Debugger as Debugger;

$client = new Client();
Debugger::enable(Debugger::DEVELOPMENT);

const ALB_WTC = 'https://www.alibaba.com/countrysearch/CN/mens-watches.html';
$crawler = $client->request('GET', ALB_WTC);

$names = $crawler->filter('.m-gallery-product-item .item-info .title a')->each(function ($node) {
    return $node->text();
});
dump($names);

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