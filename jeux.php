<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/bdd.php';

$loader = new Twig_Loader_Filesystem('template'); // Dossier contenant les templates
$twig = new Twig_Environment($loader, array(
'cache' => false
));

echo $twig->render('head.twig', array('titre' => 'Belote'));

echo $twig->render('bandeau.twig', array('onglet'=>3));

echo $twig->render('footer.twig');
?>
