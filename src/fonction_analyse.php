<?php
function ajout_match($bd,$id1,$id2,$manche)
{
	if ( $id1 < $id2 )
	{
		$e1 = $id1;
		$e2 = $id2;
	}
	else
	{
		$e2 = $id1;
		$e1 = $id2;
	}
	$ajout_match = "INSERT INTO  Match (ID ,
						ID_Equipe_1 ,
						ID_Equipe_2 ,
						ID_Match)
			VALUES (NULL ,  '$e1',  '$e2', '$manche')";
	Set($bd,$ajout_match);
}

function verif_sup_equipe($bd,$id)
{
	$req = "SELECT ID
		FROM Match
		WHERE ID_Equipe_1 = $id or ID_Equipe_2 = $id";
	$res = Get($bd,$req);
	$valide = count($res);
	return $valide==0 ? TRUE : FALSE;
}

function verfi_math($bd,$id1,$id2)
{
	if($id1==$id2)
	{
		$valide = 1;
	}
	else
	{
		if ( $id1 < $id2 )
		{
			$e1 = $id1;
			$e2 = $id2;
		}
		else
		{
			$e2 = $id1;
			$e1 = $id2;
		}
		$reque = "SELECT * FROM Match WHERE ID_Equipe_1 = $e1 and ID_Equipe_2 = $e2";
		$valide_match = Get($bd,$reque);
		$valide = count($valide_match);
	}
	return $valide==0 ? TRUE : FALSE;
}

function verfi_math_nb($bd,$id1,$id2,$manche)
{
	if($id1==$id2)
	{
		$valide = 1;
	}
	else
	{
		if ( $id1 < $id2 )
		{
			$e1 = $id1;
			$e2 = $id2;
		}
		else
		{
			$e2 = $id1;
			$e1 = $id2;
		}
		$reque = "SELECT * FROM Match WHERE ID_Equipe_1 = $e1 and ID_Equipe_2 = $e2 and ID_Match < $manche";
		$valide_match = Get($bd,$reque);
		$valide = count($valide_match);
	}
	return $valide;
}

function nombre_equipe($bd)
{
	$result = Get($bd,"SELECT Count(ID) FROM Equipe;");
	return $result[0]["Count(ID)"];
}
function nombre_match($bd,$manche)
{
	//vérification du nombre de match dans la manche
	$reque1 = "SELECT * FROM Match WHERE ID_Match = $manche";
	$match = Get($bd,$reque1);
	$nb_match = count($match);

	return $nb_match;
}

function verif_exist($bd,$id_equip,$manche)
{
	//test de vérification d'existance de Match sur l'équipe en cours
	$existe_match = "SELECT *
					 FROM Match
					 WHERE ID_Match = '$manche' and
					 (ID_Equipe_1 = '$id_equip' OR ID_Equipe_2 = '$id_equip')";
	$existe = Get($bd,$existe_match);			 
	$ex = count($existe);
	
	return ($ex == 0) ? TRUE : FALSE;
}

function generation_match($bd,$manche)
{
	$nb_match = nombre_match($bd,$manche);
	$nb_equipe = nombre_equipe($bd);
	
	$n = $nb_equipe/2;
	if ($nb_match < $n)
	{	
		//liste des équipes au complet
		$requete = "SELECT Equipe.ID 
					FROM Equipe 
					ORDER BY Equipe.Nb_Victoire DESC, Equipe.Score DESC";
		$res = Get($bd,$requete);
		//$index = 0;
		foreach ( $res as $equipe)
		{
			//vérification de non match de l'équipe en cours dans la manche en cours
			if(verif_exist($bd,$equipe["ID"],$manche))
			{			 
				$id_possible = "SELECT ID FROM Equipe 
								WHERE ID <> '".$equipe['ID']."' 
								and ID NOT IN (SELECT ID_Equipe_2 FROM Match WHERE ID_Equipe_1 = '".$equipe["ID"]."') 
								and ID NOT IN (SELECT ID_Equipe_1 FROM Match WHERE ID_Equipe_2 = '".$equipe["ID"]."')
								and ID NOT IN (SELECT ID_Equipe_1 FROM Match WHERE ID_Match = '$manche')
								and ID NOT IN (SELECT ID_Equipe_2 FROM Match WHERE ID_Match = '$manche')
								ORDER BY Equipe.Nb_Victoire DESC, Equipe.Score DESC";
				
				$id_res = Get($bd,$id_possible);
				$poss = count($id_res);
				
				//vérification de la possibilité de match.
				if($poss != 0)
				{
					$equipe2 = $id_res[0]["ID"];
					ajout_match($bd,$equipe["ID"],$equipe2,$manche);
				}
			}
		}
	}
}

function maj_score($bd,$id,$M1,$manche)
{
	//calcul du score de l'équipe avec mise à jour de score de la manche
	$reque = "SELECT ID,Match_1,Match_2,Match_3,Match_4 FROM Equipe WHERE  ID =$id;";
	$res = Get($bd,$reque);
	$line = $res;
	$total = $M1;
	for ($i = 1;$i<=4;$i++)
	{
		if ($manche != $i ) {$total += $line[0]["Match_".$i];}
	}

	$reque = "UPDATE  Equipe SET  
		Match_$manche = $M1,
		Score = $total
		WHERE  ID =$id;";
	//echo $reque;	
	Set($bd,$reque);
}

function maj_victoire_match($bd,$info)
{
	$manche = $info["manche"];
	//récupération des matchs avec le score des équipes
	$req1 = "SELECT E1.ID AS 'ID_Equipe_1',
					E1.Match_$manche AS 'Score Equipe 1',
					E1.Vic_1 as 'vic1_1', E1.Vic_2 as 'vic1_2', E1.Vic_3 as 'vic1_3', E1.Vic_4 as 'vic1_4',
					E1.Match_1 as 'score1_1', E1.Match_2 as 'score1_2', E1.Match_3 as 'score1_3', E1.Match_4 as 'score1_4',
					E2.ID AS 'ID_Equipe_2',
					E2.Match_$manche AS 'Score Equipe 2',
					E2.Vic_1 as 'vic2_1', E2.Vic_2 as 'vic2_2', E2.Vic_3 as 'vic2_3', E2.Vic_4 as 'vic2_4',
					E2.Match_1 as 'score2_1', E2.Match_2 as 'score2_2', E2.Match_3 as 'score2_3', E2.Match_4 as 'score2_4'
		FROM Equipe AS E1,Equipe AS E2,Match 
		WHERE Match.ID_Equipe_1 = E1.ID and Match.ID_Equipe_2 = E2.ID and Match.ID_Match = $manche";
	//echo $req1;
	$res1 = Get($bd,$req1);
	// par match, on met a jour les victoires des deux équipes 0 perdu, 1 gagné
	
	foreach ($res1 as $line) {
		
		if($line["score1_".$manche] != $info["Match_".$line["ID_Equipe_1"]] || $line["score2_".$manche] != $info["Match_".$line["ID_Equipe_2"]]){
			// récupération des scores des deux équipes		
			$line["score1_".$manche]= $info["Match_".$line["ID_Equipe_1"]];
			$index++;
			$line["score2_".$manche]= $info["Match_".$line["ID_Equipe_2"]];
			$e1 = intval($line["score1_".$manche]);
			$e2 = intval($line["score2_".$manche]);
			
			if ( $e1 == $e2) // si égalité
			{
				$line["vic1_".$manche] = 0;
				$line["vic2_".$manche] = 0;
			}
			else
			{
				if ( $e1 > $e2 ) // si équipe 1 a gagnée
				{
					$line["vic1_".$manche] = 1;
					$line["vic2_".$manche] = 0;
				}
				else 	// Si équipe 2 a gagnée.
				{
					$line["vic1_".$manche] = 0;
					$line["vic2_".$manche] = 1;
				}
			}
			//echo "<br>$req_u1<br>";
			// mise à jour de la base
			$vic1 = $line["vic1_1"] + $line["vic1_2"] + $line["vic1_3"] + $line["vic1_4"];
			$vic2 = $line["vic2_1"] + $line["vic2_2"] + $line["vic2_3"] + $line["vic2_4"];
			$sco1 = $line["score1_1"] + $line["score1_2"] + $line["score1_3"] + $line["score1_4"];
			$sco2 = $line["score2_1"] + $line["score2_2"] + $line["score2_3"] + $line["score2_4"];
			$req_u1 = "UPDATE Equipe set 
					Vic_$manche = ".$line["vic1_".$manche].", 
					Nb_Victoire = $vic1,
					Match_$manche = ".$line["score1_".$manche].",
					Score = $sco1
					WHERE ID = ".$line["ID_Equipe_1"];
			$req_u2 = "UPDATE Equipe set 
					Vic_$manche = ".$line["vic2_".$manche].", 
					Nb_Victoire = $vic2,
					Match_$manche = ".$line["score2_".$manche].",
					Score = $sco2
					WHERE ID = ".$line["ID_Equipe_2"];
			
			Set($bd,$req_u1);
			Set($bd,$req_u2);
		}
	}
}
function maj_victoire($bd)
{
	// Somme des victoires pour mise à jour du nombre de victoire pour chaque équipe
	$requete = "SELECT ID, Vic_1, Vic_2, Vic_3, Vic_4 FROM Equipe";
	$resultat = Get($bd,$requete);
	$index=0;
	foreach ($resultat as $line) {
		$total = 0;		
		for ($i = 1;$i<5;$i++)
		{
			$total += $line["Vic_".$i];
		}
		$req_u = "UPDATE Equipe set Nb_Victoire = $total WHERE ID = ".$line["ID"];
		Set($bd,$req_u);
	}
}
function supprime($bd,$table,$id)
{
	$req = "DELETE FROM $table WHERE $table.ID = $id;";
	
	Set($bd,$req); 
}
function maj_equipe($bd,$id,$nom1,$nom2)
{
	$reque = "UPDATE  Equipe SET  
		Nom_1 =  '$nom1',
		Nom_2 = '$nom2'
		WHERE  ID =$id;";
	Set($bd,$reque);
}
function ajout_equipe($bd,$nom1,$nom2)
{
	$reque = "INSERT INTO  Equipe (
					ID ,
					Nom_1 ,
					Nom_2 ,
					Match_1 ,
					Match_2 ,
					Match_3 ,
					Match_4 ,
					Nb_Victoire
					)
		VALUES (NULL ,  '$nom1',  '$nom2', '0', '0', '0', '0', '0')";
	Set($bd,$reque);
}

function nb_victoire_manche($bd,$manche)
{
	$req = "SELECT SUM(Vic_$manche) as SUM FROM Equipe";
	$res = Get($bd,$req);
	return $res[0]["SUM"];
}

function rec_id_equipe($bd)
{
    $req = "SELECT ID FROM Equipe";
    $res = Get($bd,$req);
	$tab = array();
	foreach ($res as $line) {
		$tab[] = $line["ID"];
	}
    return $tab;
}
?>
