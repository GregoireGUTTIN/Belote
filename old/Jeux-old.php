<HTML>
<head>
<link rel="stylesheet" type="text/css" href="./style.css">
<?php
include ('./fonction_bdd.php');
include ('./fonction_analyse.php');
include ('./fonction_affichage.php');
?>
<script>
function ModifScore(val,id,f)
{
	var modif = document.getElementById('mod');
	var id_modif = document.getElementById('Id_Mod');
	modif.value = val;
	id_modif.value = id;
	f.submit();
}

function actualise(f)
{
	var modif = document.getElementById('mod');
        modif.value = '2';
        f.submit();
}

function ChangeManche(val,id_m,f)
{
	var manche = document.getElementById('manche');
	var modif = document.getElementById('mod');
	modif.value = val;
	manche.value = id_m;
	f.submit();
}
function ChangeVal(val,id,f)
{
	var modif = document.getElementById('mod');
	var id_modif = document.getElementById('Id_Mod');
	modif.value = val;
	id_modif.value = id;
	f.submit();
}
</script>
</head>
<body>
<center>
<?php
$table="Equipe";
$page="equipe.php";
$base = Connexion('BELOTE');
$manche = (isset($_POST['manche'])) ? $_POST['manche'] : 1;
$modification =  (isset($_POST['mod']))? $_POST['mod'] : 0;
$id = (isset($_POST['Id_Mod']))?$_POST['Id_Mod']:-1;



switch ($modification)
{
case 1:
	$nb_equipe = nombre_equipe($base);
	generation_match($base,$manche,$nb_equipe);
	break;
case 2: 
	// recuperation du nombre d'equipe
	//$nb_e = nombre_equipe();
    //$id_equipe = rec_id_equipe($base);
    //$nb_e = count($id_equipe);
    //echo $nb_e;
	//var_dump($id_equipe);
	// boucle sur toutes les equipe
    /*for($i=0;$i<$nb_e;$i++)
	{
		$n = "Match_$id_equipe[$i]";
		$M1 = $_POST[$n];
		//echo $n." ".$M1."<br>"; 
		maj_score($base,$id_equipe[$i],$M1,$manche);
	}*/
	//var_dump($_POST);
	//Mise à jour de la victoire du match en cours
	maj_victoire_match($base,$_POST);
	//maj_victoire($base);
	break;
case 3:
	$n = "Match_$id";
	$M1 = $_POST[$n];
	//Mise à jour du Score
	maj_score($base,$id,$M1,$manche);


	//Mise à jour de la victoire du match en cours
	maj_victoire_match($base,$manche);
	maj_victoire($base);
	
 	break;
case 5: 
	if ( verfi_math($base,$_POST['Equipe1'],$_POST['Equipe2']) )
	{
		echo "<P class='red'>Le match n'a pas encore eu lieu </P>";
	}
	else
	{
		echo "<P class='red'>Le match a déjà eu lieu</P>";
	}
	ajout_match($base,$_POST['Equipe1'],$_POST['Equipe2'],$manche);
	break;
case 6:
	supprime($base,"Match",$id);
	break;
}

	
	echo "<P>Manche Num&eacute;ro $manche</P>";
	echo "<form method='post' action='match.php'>";
	echo "<input type='hidden' name='manche2' value='$manche'/>";
	echo "<input type='submit' value='Gestion'/>";
	echo "</form>";
	echo "<form method='post' action='Jeux.php'>";
	echo "\t\t<input type='hidden' id='mod' name='mod' value='0'/></td>\n";
	echo "\t\t<input type='hidden' id='Id_Mod' name='Id_Mod' value='0'/></td>\n";
	echo "<input type='hidden' id='manche' name='manche' value='$manche'/>";
	
	$nb_match = nombre_match($base,$manche);
	if ($manche > 1)
	{
		$m = $manche-1; 
		echo "\t\t<input type='button' value='Manche Precedente' onclick='ChangeManche(0,$m,this.form);'/>\n";
	}
	echo "\t\t<input type='button' value='Actualise' onclick='actualise(this.form);'/>\n";
	echo "\t\t<input type='button' value='Retour' onclick='window.location.href=\"index.php\"'/>\n";

	$nb_v = nb_victoire_manche($base,$manche);

	if ($manche < 4 && $nb_match == $nb_v)
	{
		$m = $manche+1;  
		echo "\t\t<input type='button' value='Manche Suivante' onclick='ChangeManche(1,$m,this.form);'/>\n";
	}


	if ($manche == 4 && $nb_match == $nb_v)
	{
		echo "\t\t<input type='button' value='Bilan' onclick='window.location.href=\"bilan.php\"'/>\n";
	}
	$nb_equipe = nombre_equipe($base);
	$n = $nb_equipe/2;
	//echo "<br>$nb_match<br>";
	if ($nb_match == $n)
	{
		affichage_equipe_manche($base,$manche);
		echo "<br>";
	}
	else
	{
		echo "<P>Les matchs de la manche $manche ne sont pas tous d&eacute;finis</P>";
		echo "<P>Corrigez les matchs de la manche $manche</P>";
		affiche_match_ajout($base,$manche,$nb_match, $n);
	}	

Deconnexion($base);
?>
</form>
</center>
</body>
</HTML>

