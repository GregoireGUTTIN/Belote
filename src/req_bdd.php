<?php

/* fichier contenant les requètes utilisées dans l'application
 *
 */

class requete
{
  static private $champ_equipe = array(
    "Nom_1"=>"Nom_1",
    "Nom_2"=>"Nom_2",
    "Score_1"=>"Match_1",
    "Score_2"=>"Match_2",
    "Score_3"=>"Match_3",
    "Score_4"=>"Match_4",
    "Vic_1"=>"Vic_1",
    "Vic_2"=>"Vic_2",
    "Vic_3"=>"Vic_3",
    "Vic_4"=>"Vic_4",
    "Nb_Vic"=>"Nb_Victoire",
    "Tot_Score"=>"Score"
  );


  static public $req = array(
    'liste_equipe'  => "SELECT ID as 'Num équipe' ,Nom_1 || ' - ' || Nom_2 AS 'Nom Equipe' FROM Equipe",
    'nombre_equipe' => "SELECT Count(ID) FROM Equipe;", // pour les fonctions count elles doivent toujours être sur le champ ID
    'nombre_match'  => "SELECT Count(ID) FROM Match WHERE ID_Match = :manche", // pour les fonctions count elles doivent toujours être sur le champ ID
    'ajout_equipe'  => "INSERT INTO  Equipe (Nom_1, Nom_2, Match_1, Match_2,	Match_3, Match_4, Nb_Victoire)
      VALUES (:nom1, :nom2, '0', '0', '0', '0', '0')",
    'modif_equipe'  => "UPDATE  Equipe SET Nom_1 = :nom1,	Nom_2 = :nom2	WHERE  ID = :id",
    'info_equipe'   => "SELECT ID, Nom_1, Nom_2,Vic_1,Vic_2,Vic_3,Vic_4,Match_1,Match_2,Match_3,Match_4,Nb_Victoire,Score FROM Equipe WHERE ID = :id",
    'info_match'    => "SELECT ID_Equipe1, ID_Equipe2,ID_Match  FROM Match WHERE ID = :id",
    'reset'         => array("DELETE FROM Match", "DELETE FROM Equipe", "VACUUM"),
    'liste_equipe_sans_match'=>"SELECT ID as 'Num équipe' ,Nom_1 || ' - ' || Nom_2 AS 'Nom Equipe' FROM Equipe
                                WHERE ID NOT IN (SELECT ID_Equipe_1 FROM Match WHERE ID_Match = :manche)
                                AND ID NOT IN (SELECT ID_Equipe_2 FROM Match WHERE ID_Match = :manche)",
    'liste_match'   =>"SELECT Match.ID,
                           Equipe1.ID AS ID1,
                           Equipe1.Nom_1 || ' - ' || Equipe1.Nom_2 AS NomEquipe1,
                           Equipe1.Match_1 AS S1_1,Equipe1.Match_2 AS S1_2,Equipe1.Match_3 AS S1_3,Equipe1.Match_4 AS S1_4,
                           Equipe2.ID AS ID2,
                           Equipe2.Match_1 AS S2_1,Equipe2.Match_2 AS S2_2,Equipe2.Match_3 AS S2_3,Equipe2.Match_4 AS S2_4,
                           Equipe2.Nom_1 || ' - ' || Equipe2.Nom_2 AS NomEquipe2
                           FROM Match
                           INNER JOIN Equipe AS Equipe1 ON ID_Equipe_1 = Equipe1.ID
                           INNER JOIN Equipe AS Equipe2 ON ID_Equipe_2 = Equipe2.ID
                           WHERE ID_Match = :manche",
    'recup_match'  =>"SELECT ID_Equipe_1,ID_Equipe_2,ID_Match FROM Match WHERE ID = :id",
    'ajout_match'  => "INSERT INTO  Match (ID_Equipe_1, ID_Equipe_2, ID_Match)
                              VALUES (:equipe1, :equipe2, :manche)",
    'sup_match'    => "DELETE FROM Match WHERE ID = :id",
    'maj_score_vic_1_manche' => "UPDATE Equipe set Match_1 = :score,Vic_1 = :vic WHERE ID = :id",
    'maj_score_vic_2_manche' => "UPDATE Equipe set Match_2 = :score,Vic_2 = :vic WHERE ID = :id",
    'maj_score_vic_3_manche' => "UPDATE Equipe set Match_3 = :score,Vic_3 = :vic WHERE ID = :id",
    'maj_score_vic_4_manche' => "UPDATE Equipe set Match_4 = :score,Vic_4 = :vic WHERE ID = :id",
    'maj_score_vic' => "UPDATE Equipe set Score = :score,Nb_Victoire = :vic WHERE ID = :id",

    'liste_resultat_equipe'  => "SELECT ID as 'Num équipe' ,Nom_1 || ' - ' || Nom_2 AS 'Nom Equipe',
                          Match_1,Match_2,Match_3,Match_4,
                          Vic_1,Vic_2,Vic_3,Vic_4,
                          Nb_Victoire,
                          Score
                        FROM Equipe
                        ORDER BY Nb_Victoire DESC, Score DESC",


    'existe_match' => "SELECT COUNT(ID)
  					 FROM Match
  					 WHERE ID_Match = :manche and
  					 (ID_Equipe_1 = :id_equip OR ID_Equipe_2 = :id_equip)",

    'id_possible' => "SELECT ID FROM Equipe
            WHERE ID <> :id_equip
            and ID NOT IN (SELECT ID_Equipe_2 FROM Match WHERE ID_Equipe_1 = :id_equip)
            and ID NOT IN (SELECT ID_Equipe_1 FROM Match WHERE ID_Equipe_2 = :id_equip)
            ORDER BY Equipe.Nb_Victoire DESC, Equipe.Score DESC",
            // and ID NOT IN (SELECT ID_Equipe_1 FROM Match WHERE ID_Match = :manche)
            // and ID NOT IN (SELECT ID_Equipe_2 FROM Match WHERE ID_Match = :manche)

    'create_equipe' => "CREATE TABLE IF NOT EXISTS `Equipe` (
                              `ID`	INTEGER NOT NULL,
                              `Nom_1`	TEXT NOT NULL,
                              `Nom_2`	TEXT NOT NULL,
                              `Match_1`	INTEGER DEFAULT '0',
                              `Match_2`	INTEGER DEFAULT '0',
                              `Match_3`	INTEGER DEFAULT '0',
                              `Match_4`	INTEGER DEFAULT '0',
                              `Vic_1`	INTEGER DEFAULT '0',
                              `Vic_2`	INTEGER DEFAULT '0',
                              `Vic_3`	INTEGER DEFAULT '0',
                              `Vic_4`	INTEGER DEFAULT '0',
                              `Nb_Victoire`	INTEGER DEFAULT '0',
                              `Score`	INTEGER DEFAULT '0',
                              PRIMARY KEY(ID)
                              );",
    'create_match' => "CREATE TABLE IF NOT EXISTS `Match` (
                        `ID`	INTEGER NOT NULL,
                        `ID_Equipe_1`	INTEGER,
                        `ID_Equipe_2`	INTEGER,
                        `ID_Match`	INTEGER,
                        PRIMARY KEY(ID)
                        );"

  );
}

?>
