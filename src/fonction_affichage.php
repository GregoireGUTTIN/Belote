<?php
function affichage_equipe_manche($bd,$manche)
{
	//récupération des score de chaque équipe
	$res = Get($bd,"SELECT E1.ID, E1.ID || ' : <b>' || E1.Nom_1 || ' - ' || E1.Nom_2 || '</b>' AS 'Equipe',
	E1.Match_1 AS 'Match 1', 
	E1.Match_2 AS 'Match 2', 
	E1.Match_3 AS 'Match 3',
	E1.Match_4 AS 'Match 4', 
	E1.Nb_Victoire AS 'Nombre de victoire', E1.Score ,Match.ID AS 'Id Match'
	FROM Equipe AS E1, Match
	WHERE (Match.ID_Equipe_1 = E1.ID or Match.ID_Equipe_2 = E1.ID) and Match.ID_Match = $manche
	ORDER BY Match.ID, E1.Match_$manche DESC, E1.Nb_Victoire DESC");

	// Affichage des résultats en HTML
	$num_rows = count($res);
	$col = count($res[0]);
	//affichage des équipes avec saisi des scores de la manche en cours
	echo "<table>\n";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Numero table</th>";
	$l =0;
	foreach ($res[0] as $cle => $value)
	{
		if($l != 0 && $l != 8){
			echo "<th>$cle</th>";
		}
		$l++;
	}
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>\n";
	$l = 0;
	$id_couleur = 0;
	
	$nb_table = 1;
	$change_table = 0;
	
	foreach ($res as $line) {
		if ( $id_couleur%2 == 0 ) { 
		  echo "\t<tr class='claire'>\n"; 
		  if($l==0){echo "\t\t<td rowspan=2>$nb_table</td>\n";} 
		  else{$nb_table++;}
		} else { 
		  echo "\t<tr class='fonce'>\n";
		  if($l==0){echo "\t\t<td rowspan=2>$nb_table</td>\n";} 
		  else{$nb_table++;}
		}

		$i=0;
	    foreach ($line as $col_value) 
		{
			if ($i != 8 && $i != 0)
			{
				if ($i == $manche+1)
				{
					echo "\t\t<td><input class='petit' type='number' name='Match_".$line["ID"]."' min='0' max='1944' value='$col_value'/></td>\n";
				}
				else
				{
					echo "\t\t<td>$col_value</td>\n";
				}
			}
			$i++; 
		}
		echo "\t</tr>\n";
		$l++;
		if($l > 1) { $id_couleur++; $l=0;}
	}
	echo "</tbody>";
	echo "</table>\n";	
}
function affichage_bilan($bd)
{
	//récupération des score de chaque équipe
	$res = Get($bd,"SELECT E1.ID || ' : <b>' || Nom_1 || ' - ' || Nom_2 || '</b>' AS 'Equipe', Match_1 AS 'Score 1', Match_2 AS 'Score 2', Match_3 AS 'Score 3', Match_4 AS 'Score 4', Nb_Victoire AS 'Nombre de Victoire', Score
	FROM Equipe AS E1
	ORDER BY E1.Nb_Victoire DESC,E1.Score DESC");

	// Affichage des résultats en HTML
	$num_rows = count($res);
	$col = count($res[0]);
	//affichage des équipes avec saisi des scores de la manche en cours
	echo "<table>\n";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Classement</th>";
	//$l =0;
	foreach ($res[0] as $cle => $value)
	{
		//if($l != 0 && $l != 8){
			echo "<th>$cle</th>";
		//}
		//$l++;
	}
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	$l = 1;
	foreach ($res as $line) {
		if ( $l%2 ==0 ) { echo "\t<tr class='claire'>\n"; }
		else { echo "\t<tr class='fonce'>\n"; }
		echo "<td>$l</td>";
	    	foreach ($line as $col_value) 
		{
			echo "\t\t<td>$col_value</td>\n";
	    	}
	    	echo "\t</tr>\n";
	    	$l++;
	}
	echo "</tbody>";
	echo "</table>\n";	
}
function affiche_match($db,$manche)
{
	$result = Get($db,"SELECT CONCAT(E1.ID, ' : <b>',E1.Nom_1,' - ',E1.Nom_2,'</b>') AS 'Equipe 1',
						  CONCAT(E2.ID, ' : <b>',E2.Nom_1,' - ',E2.Nom_2,'</b>') AS 'Equipe 2', 
			E1.Match_$manche AS 'Score Equipe 1',
			E2.Match_$manche AS 'Score Equipe 2',
			E1.ID , E2.ID,Match.ID
		FROM Equipe AS E1,Equipe AS E2,Match 
		WHERE Match.ID_Equipe_1 = E1.ID and Match.ID_Equipe_2 = E2.ID and Match.ID_Match = $manche
		ORDER BY Match.ID");

	$num_rows = count($result);
	
	$col = count($result[0]);
	echo "<table>\n";
	echo "<thead>";
	echo "<tr>";
	foreach ($res[0] as $cle => $value)
	{
		echo "<th>$cle</th>";
	}
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	$l = 1;
	foreach ($result as $line) {
		if ( $l%2 ==0 ) { echo "\t<tr class='claire'>\n"; }
		else { echo "\t<tr class='fonce'>\n"; }

		if (verfi_math_nb($db,$line[4],$line[5],$manche) == 0)
		{
			$e1 = intval($line[2]);
			$e2 = intval($line[3]);
			if ( $e1 == $e2 )
			{
				echo "\t\t<td>$line[0]</td>\n";
				echo "\t\t<td>$line[1]</td>\n";
			}
			else
			{
				if ( $e1 > $e2 )
				{
					echo "\t\t<td class='victoire'>$line[0]</td>\n";
					echo "\t\t<td class='defete'>$line[1]</td>\n";
				}
				else
				{
					echo "\t\t<td class='defete'>$line[0]</td>\n";
					echo "\t\t<td class='victoire'>$line[1]</td>\n";
				}
			}
			echo "\t</tr>\n";
		}
		else
		{
			echo "\t\t<td class='conflit'>$line[0]</td>\n";
			echo "\t\t<td class='conflit'>$line[1]</td>\n";
		}
	    $l++;
	}
	echo "</tbody>";
	echo "</table>\n";
}
function affiche_match_ajout($db,$manche,$nb_match, $n)
{
	$result = Get($db,"SELECT Match.ID_Match AS 'Manche',
				E1.ID || ' : <b>' || E1.Nom_1 || ' - ' || E1.Nom_2 || '</b>' AS 'Equipe 1',
				E2.ID || ' : <b>' || E2.Nom_1 || ' - ' || E2.Nom_2 || '</b>' AS 'Equipe 2',
				Match.ID	as 'SUP'			
	FROM Equipe AS E1,Equipe AS E2,Match 
	WHERE Match.ID_Equipe_1 = E1.ID and Match.ID_Equipe_2 = E2.ID ORDER BY Match.ID_Match");
	
	// Affichage des résultats en HTML
	$num_rows = count($result);
	echo "<table>\n";
	if($num_rows > 0){
		$col = count($result[0]);
		
	}
	echo "<thead>";
		echo "<tr>";
			echo "<th>Manche</th>";
			echo "<th>Equipe 1</th>";
			echo "<th>Equipe 2</th>";
			echo "<th>SUP</th>";
		
		echo "</tr>";
	echo "</thead>";
	
	
	echo "<tfoot>";
	bas_match($db,$nb_match, $n,0,$manche);
	echo "</tfoot>";
	echo "<tbody>";
	
	foreach ($result as $line) {
		switch( $line['Manche']) { 
			case 1 :
				echo "\t<tr class='manche1'>\n"; 
				break;
			case 2 :
				echo "\t<tr class='manche2'>\n"; 
				break;
			case 3 :
				echo "\t<tr class='manche3'>\n"; 
				break;
			case 4 :
				echo "\t<tr class='manche4'>\n"; 
				break;
		}
	    $i=0;
	    foreach ($line as $col_value) 
	    {
			if ($i == 3 && $line['Manche'] == $manche)
			{
				echo "\t\t<td><input  type='button' value='Supprimer' onclick='ChangeVal(6,$col_value,this.form,2);'/></td>\n";
			}
			else
			{	if ($i == 3 && $line['Manche'] != $manche){echo "\t\t<td> </td>\n";}
				else{echo "\t\t<td>$col_value</td>\n";}
			}
			$i++;
	    }
	    echo "\t</tr>\n";
	    
	}
	echo "</tbody>";
	
	echo "</table>\n";
}
function bas_match($db,$nb_match, $n,$l,$manche)
{
	if ( $nb_match != $n) 
	{ 
		//ligne ajouté
		if ( $l%2 ==0 ) { echo "\t<tr class='claire'>\n"; }
			else { echo "\t<tr class='fonce'>\n"; }
		echo "\t\t<td>$manche</td>\n";
		echo "\t\t<td>";
		//requète
		$sql = " SELECT  Equipe.ID , ID || ' : <b>' || Nom_1 || ' - ' || Nom_2 || '</b>' AS  'Equipe'
			FROM  Equipe 
			WHERE  Equipe.ID NOT IN (
				SELECT  Equipe.ID 
				FROM  Equipe ,  Match 
				WHERE  (Equipe.ID =  Match.ID_Equipe_1 
				OR  Equipe.ID =  Match.ID_Equipe_2)
				AND Match.ID_Match = '$manche'
				)"; 
		$res = Get($db,$sql); 

		echo "<select name='Equipe1'>"; 
		foreach ($res as $row) 
		{ 
			echo"<option value=".$row["ID"].">".$row["Equipe"]."</option>"; 
		} 
		echo"</select>"; 
		
		echo "</td>\n";
		echo "\t\t<td>";
		$res = Get($db,$sql); 
		echo "<select name='Equipe2'>"; 
		foreach ($res as $row)
		{ 
			echo"<option value=".$row["ID"].">".$row["Equipe"]."</option>";  
		} 
		echo"</select>"; 
		
		echo "</td>\n";
		echo "\t\t<td><input type='button' value='Ajouter' onclick='ChangeVal(5,0,this.form,2);'/></td>\n";
		echo "\t</tr>\n";
	}
}
function affiche_equipe_ajout($db,$modification,$id)
{
	$r = "SELECT ID,ID || ' : <b>' || Nom_1 || ' - ' || Nom_2 || '</b>' AS 'Nom Equipe' FROM Equipe";
	$result = Get($db,$r);
	//var_dump($result);
	
	echo "<table>\n";
	echo "<thead>";
	echo "<tr>";
	
	echo "<th>Numero</th>";
	echo "<th colspan = 2>Nom equipe</th>";
	echo "<th>Sup</th>";
	echo "<th>Mod</th>";
	echo "</tr>";
	$l = 0;
	
	/*if ( $modification != 2 )
	{
		//ligne ajouté
		if ( $l%2 == 0 ) { echo "\t<tr class='claire'>\n"; }
			else { echo "\t<tr class='fonce'>\n"; }
		echo "\t\t<td> </td>\n";
		echo "\t\t<td><input type='text' name='nom1' placeholder='nom du joueur 1'/></td>\n";
		echo "\t\t<td><input type='text' name='nom2' placeholder='nom du joueur 2'/></td>\n";
		echo "\t\t<td colspan=2><input type='button' value='Ajouter' onclick='ChangeVal(1,0,this.form,1);'/></td>\n";
		echo "\t</tr>\n";
    }*/
	echo "</thead>";
	echo "<tbody>";
	
	
	foreach ($result as $line) 
	{	
		//ligne 
		if ( $l%2 ==0 ) { echo "\t<tr class='claire'>\n"; }
		else { echo "\t<tr class='fonce'>\n"; }
		$i=0;
		 
		echo "\t\t<td>".$line["ID"]."</td>\n";
		
		if ( $modification == 2 && $line["ID"] == $id)
		{
			$no = explode(' - ',$line["Nom Equipe"]);
			
			// supprimer les balises <b>.
			
			echo "\t\t<td><input type='text' name='Nom_1' value='$no[0]'/></td>\n";
			echo "\t\t<td><input type='text' name='Nom_2' value='$no[1]'/></td>\n";
		}
		else {	echo "\t\t<td colspan=2>".$line["Nom Equipe"]."</td>\n"; } 
		
		echo "\t\t<td><input  type='button' value='Sup' onclick='ChangeVal(4,".$line["ID"].",this.form,1);'/></td>\n";
		if ( $modification == 2 && $line["ID"] == $id)
		{
			echo "\t\t<td><input  type='button' value='Appliquer' onclick='ChangeVal(3,".$line["ID"].",this.form,1);'/></td>\n";
		}
		else
		{
			echo "\t\t<td><input  type='button' value='Mod' onclick='ChangeVal(2,".$line["ID"].",this.form,1);'";
			if ($modification == 2){echo "disabled";}
			echo "/></td>\n";
		}
	    	
	    	echo "\t</tr>\n";
	    	$l++;
	}
	echo "</tbody>";
	echo "</table>\n";	
}
?>
