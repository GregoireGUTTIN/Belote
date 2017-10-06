<HTML>
<head>
<link rel="stylesheet" type="text/css" href="./style.css">
<?php
include ('./fonction_bdd.php');
include ('./fonction_analyse.php');
include ('./fonction_affichage.php');
?>
</head>
<body>
<center>
<?php
$base = Connexion('BELOTE');
$manche = $_POST['manche2'];
$nb_match = nombre_match($base,$manche);
echo "<P>Corrigez les matchs de la manche $manche</P>";
		affiche_match_ajout($base,$manche,$nb_match, $n);
		
echo "<form method='post' action='Jeux.php'>";
		echo "<input type='hidden' name='manche' value='$manche'/>";
		echo "<input type='submit' value='Retour aux jeux'/>";
echo "</form>";
Deconnexion($base);
?>
</center>
</body>
</HTML>
