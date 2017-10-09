<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/bdd.php';

$loader = new Twig_Loader_Filesystem('template'); // Dossier contenant les templates
$twig = new Twig_Environment($loader, array(
'cache' => false
));

echo $twig->render('head.twig', array('titre' => 'Belote'));

$bdd_connect = bdd::getInstance('BELOTE');
$tab = $bdd_connect->Get('liste_resultat_equipe');

echo $twig->render('bandeau.twig', array('onglet'=>4));

echo $twig->render('liste_resultat_equipe.twig', array('titre' => 'Resultat','tab'=>$tab));

echo $twig->render('footer.twig');
?>
