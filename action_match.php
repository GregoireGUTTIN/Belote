<?php
require_once __DIR__ . '/src/bdd.php';
$bdd_connect = bdd::getInstance('BELOTE');

switch($_POST['action']){
  case 'ajout':
    $bdd_connect->Set('ajout_match',array(':equipe1'=>$_POST['equipe1'],':equipe2'=>$_POST['equipe2'],':manche'=>$_POST['manche']));
    break;
  case 'modif':

    break;
  case 'sup':
    $res = $bdd_connect->Get('recup_match',array(':id' => $_POST['id']));
    $id1 = $res[0]['ID_Equipe_1'];
    $id2 = $res[0]['ID_Equipe_2'];
    $bdd_connect->Set("maj_score_vic_".$res[0]['ID_Match']."_manche",array(':id'=>$id1,':score'=>0,':vic'=>0));
    $bdd_connect->Set("maj_score_vic_".$res[0]['ID_Match']."_manche",array(':id'=>$id2,':score'=>0,':vic'=>0));

    $res = $bdd_connect->Get('info_equipe',array(':id'=>$id1));
    $tot_vic = $res[0]['Vic_1'] + $res[0]['Vic_2'] + $res[0]['Vic_3'] + $res[0]['Vic_4'];
    $tot_score = $res[0]['Match_1'] + $res[0]['Match_2'] + $res[0]['Match_3'] + $res[0]['Match_4'];
    $bdd_connect->Set("maj_score_vic",array(':id'=>$id1,':score'=>$tot_score,':vic'=>$tot_vic));

    $res = $bdd_connect->Get('info_equipe',array(':id'=>$id2));
    $tot_vic = $res[0]['Vic_1'] + $res[0]['Vic_2'] + $res[0]['Vic_3'] + $res[0]['Vic_4'];
    $tot_score = $res[0]['Match_1'] + $res[0]['Match_2'] + $res[0]['Match_3'] + $res[0]['Match_4'];
    $bdd_connect->Set("maj_score_vic",array(':id'=>$id2,':score'=>$tot_score,':vic'=>$tot_vic));

    $bdd_connect->Set('sup_match',array(':id'=>$_POST['id']));
    break;
  case 'generation':
    $manche = $_POST['manche'];
    $nb_equipe = $bdd_connect->Count('nombre_equipe');
    $nb_match = $bdd_connect->Count('nombre_match',array(':manche'=>$manche));

    if ($nb_match < $nb_equipe/2 ){
      //liste des équipes au complet
      $res = $bdd_connect->Get('liste_equipe');
      foreach ( $res as $equipe){
        //vérification de non match de l'équipe en cours dans la manche en cours
        $equipe1 = $equipe["Num équipe"];
        $existe = $bdd_connect->Count('existe_match',array(':manche'=>$manche,':id_equip'=>$equipe1));
        if($existe == 0) {
          // recherche d'une equipe contre qui il n'y a pas eu de match
          $id_res = $bdd_connect->Get('id_possible',array(':id_equip'=>$equipe1,':manche'=>$manche));
          $poss = count($id_res);
          // Si une équipe a été trouvée, on ajoute le match
          if($poss != 0) {
            $equipe2 = $id_res[0]["ID"];
            $bdd_connect->Set('ajout_match',array(':equipe1'=>$equipe1,':equipe2'=>$equipe2,':manche'=>$manche));
          }
        }
      }
    }
    break;
  case 'info':
    break;
}

?>
