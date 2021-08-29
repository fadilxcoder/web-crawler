<?php

require 'vendor/autoload.php';

use Goutte\Client;
use Tracy\Debugger as Debugger;

$client = new Client();
Debugger::enable(Debugger::DEVELOPMENT);

const URL_S4 = 'https://symfony.com/doc/current/http_client.html';
$crawler = $client->request('GET', URL_S4);
$crawler->filter('h2')->each(function ($node) {
    bdump($node->text());    # Display all H2 headings
});

const URL = 'http://symfony.car-rental.local/';

$crawler = $client->request('GET', URL);
$crawler = $client->click($crawler->selectLink('Login')->link());
$form = $crawler->selectButton('Log In')->form();

/*

# Success

$crawler = $client->submit($form, ['email' => 'elise.spencer@gmail.com', 'password' => 'admin123']);
$crawler->filter('.mainmenu ul')->each(function ($node) {
    dump($node->text());
});
*/

/*

# FAIL

$crawler = $client->submit($form, ['email' => 'no-user@gmail.com', 'password' => 'xxx']);
$crawler->filter('.alert-danger')->each(function ($node) {
    dump($node->text());
});
*/
