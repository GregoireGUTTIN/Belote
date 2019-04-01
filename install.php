<?php

require_once __DIR__ . '/src/bdd.php';
$bdd_connect = bdd::getInstance('BELOTE');

$bdd_connect->Set('create_equipe');
$bdd_connect->Set('create_match');


?>
