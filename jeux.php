<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/bdd.php';

$loader = new Twig_Loader_Filesystem('template'); // Dossier contenant les templates
$twig = new Twig_Environment($loader, array(
'cache' => false
));

$manche = ($_GET)?$_GET['manche'] : 1;

$bdd_connect = bdd::getInstance('BELOTE');
$tab = $bdd_connect->Get('liste_match',array(':manche'=>$manche));
$nombre_match_non_fini = $bdd_connect->Count('match_zero',array(),$manche);
$fin = ($nombre_match_non_fini == 0)?true:false;

echo $twig->render('head.twig', array('titre' => 'Belote'));

echo $twig->render('bandeau.twig', array('onglet'=>3));

echo $twig->render('bandeau_manche.twig', array('manche'=>$manche,'fin_manche'=>$fin));

echo $twig->render('liste-match-jeux.twig', array('titre'=>'Match en cours','tab'=>$tab,'manche'=>$manche));

echo $twig->render('footer.twig',array('page'=>'jeux'));
?>
