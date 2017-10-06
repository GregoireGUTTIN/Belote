<?php
require_once __DIR__ . '/src/bdd.php';
$bdd_connect = bdd::getInstance('BELOTE');
switch($_POST['action']){
  case 'ajout':
    $bdd_connect->Set('ajout_equipe',array(':nom1'=>$_POST['nom1'],':nom2'=>$_POST['nom2']));
    break;
  case 'modif':
    $bdd_connect->Set('modif_equipe',array(':id'=>$_POST['id'],':nom1'=>$_POST['nom1'],':nom2'=>$_POST['nom2']));
    break;
  case 'majscore': break;
  case 'reset':
    echo "reset";
    $bdd_connect->Reset();
    break;
  case 'info':
    $res = $bdd_connect->Get('info_equipe',array(':id'=>$_POST['id']));
    $resultat = array("nom1"=>$res[0]['Nom_1'],"nom2"=>$res[0]['Nom_2']);
    echo json_encode($resultat);
    break;
}
?>
