<?php
require_once __DIR__ . '/src/bdd.php';
$bdd_connect = bdd::getInstance('BELOTE');
switch($_POST['action']){
  case 'ajout':
    $bdd_connect->Set('ajout_match',array(':equipe1'=>$_POST['equipe1'],':equipe2'=>$_POST['equipe2'],':manche'=>$_POST['manche']));
    break;
  case 'modif':

    break;
  case 'sup':
    $bdd_connect->Set('sup_match',array(':id'=>$_POST['id']));
    break;
  case 'reset':
    break;
  case 'info':
    break;
}

?>
