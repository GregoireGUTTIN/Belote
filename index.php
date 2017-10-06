<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/bdd.php';

$loader = new Twig_Loader_Filesystem('template'); // Dossier contenant les templates
$twig = new Twig_Environment($loader, array(
'cache' => false
));

echo $twig->render('head.twig', array('titre' => 'Belote'));

$bdd_connect = bdd::getInstance('BELOTE');
$nombre_equipe = $bdd_connect->Count('nombre_equipe');
$nb_match = $bdd_connect->Count('nombre_match',array(':manche'=>1));

echo $twig->render('bandeau.twig', array('onglet'=>1));

$tab = $bdd_connect->Get('liste_equipe');

echo $twig->render('tableau.twig', array('titre' => "Liste des équipes",'tab' => $tab,'nombre_equipe' => $nombre_equipe ));


echo $twig->render('form_ajout_equipe.twig', array('titre'=>"Ajout d'une équipe", 'id_e' => $nombre_equipe+1));
echo $twig->render('form_modif_equipe.twig', array('titre'=>"Modification d'une équipe"));

echo $twig->render('footer.twig');
?>
