<?php
require_once __DIR__ . '/src/bdd.php';
$bdd_connect = bdd::getInstance('BELOTE');
switch($_POST['action']){
  case 'score_manche':
    $res = $bdd_connect->Get('recup_match',array(':id'=>$_POST['id']));
    $id1 = $res[0]['ID_Equipe_1'];
    $id2 = $res[0]['ID_Equipe_2'];
    $manche = $res[0]['ID_Match'];
    $score1 = $_POST['score1'];
    $score2 = $_POST['score2'];

    $Vic1 = $Vic2 = 0;
    if ( $score1 > $score2 ) {// si équipe 1 a gagnée
        $Vic1 = 1;
    }else {// Si équipe 2 a gagnée.
        $Vic2 = 1;
    }
    $bdd_connect->Set("maj_score_vic_".$manche."_manche",array(':id'=>$id1,':score'=>$score1,':vic'=>$Vic1));
    $bdd_connect->Set("maj_score_vic_".$manche."_manche",array(':id'=>$id2,':score'=>$score2,':vic'=>$Vic2));

    $res = $bdd_connect->Get('info_equipe',array(':id'=>$id1));
    $tot_vic = $res[0]['Vic_1'] + $res[0]['Vic_2'] + $res[0]['Vic_3'] + $res[0]['Vic_4'];
    $tot_score = $res[0]['Match_1'] + $res[0]['Match_2'] + $res[0]['Match_3'] + $res[0]['Match_4'];
    $bdd_connect->Set("maj_score_vic",array(':id'=>$id1,':score'=>$tot_score,':vic'=>$tot_vic));

    $res = $bdd_connect->Get('info_equipe',array(':id'=>$id2));
    $tot_vic = $res[0]['Vic_1'] + $res[0]['Vic_2'] + $res[0]['Vic_3'] + $res[0]['Vic_4'];
    $tot_score = $res[0]['Match_1'] + $res[0]['Match_2'] + $res[0]['Match_3'] + $res[0]['Match_4'];
    $bdd_connect->Set("maj_score_vic",array(':id'=>$id2,':score'=>$tot_score,':vic'=>$tot_vic));

    break;
}
?>
