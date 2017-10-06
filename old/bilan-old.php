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
$table="Equipe";
$page="equipe.php";
$base = Connexion('BELOTE');

echo "<H1>R&eacute;sultat du concours</H1>";

?>
<form method='post' action='Jeux.php'>
	<input type='hidden' id='manche' name='manche' value='4'/>
	<input type="submit" value="Retour" onclick="window.location.href='Jeux.php'"/>
</form>

<?php

affichage_bilan($base);

echo "<br><br>";

/*echo "<table class='presentation'>";
echo "<tr><th>Manche 1</th><th>Manche 2</th><th>Manche 3</th><th>Manche 4</th></tr>";
echo "<tr><td class='presentation'>";
affiche_match(1);
echo "</td><td class='presentation'>";
affiche_match(2);
echo "</td><td class='presentation'>";
affiche_match(3);
echo "</td><td class='presentation'>";
affiche_match(4);
echo "</td><tr>";
echo "</table>";*/
Deconnexion($base);

?>


</center>
</body>
</HTML>

