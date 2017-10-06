<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/bdd.php';

$loader = new Twig_Loader_Filesystem('template'); // Dossier contenant les templates
$twig = new Twig_Environment($loader, array(
'cache' => false
));

$manche = ($_GET)?$_GET['manche'] : 1;

echo $twig->render('head.twig', array('titre' => 'Belote'));

$bdd_connect = bdd::getInstance('BELOTE');
$nombre_equipe = $bdd_connect->Count('nombre_equipe');
$nb_match = $bdd_connect->Count('nombre_match',array(':manche'=>$manche));

echo $twig->render('bandeau.twig', array('onglet'=>2));
echo $twig->render('bandeau_manche.twig', array('manche'=>$manche));

$tab = $bdd_connect->Get('liste_equipe_sans_match',array(':manche'=>$manche));
$tab_match = $bdd_connect->Get('liste_match',array(':manche'=>$manche));
echo "<div class='row'>";
  echo "<div class='col-sm-6'>";
    echo $twig->render('tableau-liste-match.twig', array('titre'=>'liste equipe sans match','tab'=>$tab));
  echo "</div>";
  echo "<div class='col-sm-6'>";
    echo $twig->render('tableau-match.twig', array('titre'=>'liste match','tab'=>$tab_match));
  echo "</div>";
echo "</div>";

echo $twig->render('footer.twig', array('page' => 'match' ));
?>
