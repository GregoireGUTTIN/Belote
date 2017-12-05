<!DOCTYPE html>
<html>
  <head>
    <title>Frais</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- <link rel="stylesheet" type="text/css" href="./style.css"> -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
  </head>
  <body>
  <div class="container">
  <div class="row">
    <div class="col-sm-10">
        <div class="card" style="width: 50rem;">
            <div class="card-header">
                <div class='row'>
                  <div class='col-sm-4' >note de frais</div>

              </div>
            </div>
            <div class="card-body">

        <table id='tableau' class='table table-sm table-hover table-bordered'>
          <thead>
            <tr>
              <th>Dâte</th><th>Client</th><th>Lieu</th><th>Type de frais</th><th>Nb</th><th>Prix unitaire en Euro</th><th>TOTAL en Euro</th>
            </tr>
          </thead>
          <tbody>
      <?php
        $nb_jour_ouvre = 0;
        $nu_jour = 1;
        $nu_mois = date("n");
        $nu_annee = date("Y");
        $nb_jour_mois = date("t");
        $pris_trajet = "18,20 €";
        $pris_repas = "14,55 €";
        $gris = "<tr class='table-secondary'><td colspan=7>&nbsp;</td></tr>";

        for ($nu_jour=1; $nu_jour <= $nb_jour_mois; $nu_jour++) {

          $mk_jour = mktime(0, 0, 0, $nu_mois, $nu_jour, $nu_annee);
          $jour_semaine = date("w",$mk_jour);
          $jour_format = date("d/m/Y",$mk_jour);
          // si jour ouvré
          if ($jour_semaine > 0 && $jour_semaine < 6) {
            // affichage du numéro de semaine si le 1er du mois ou un lundi
            if($nu_jour==1 || $jour_semaine == 1){
              $semaine = "<tr class='table-secondary'><td colspan=7 class='text-center'>Semaine ".date("W",$mk_jour)."</td></tr>";
              echo $semaine;
            }
            // affichage du trajet et repas
            $jour_trajet = "<tr><td>".$jour_format."</td><td>CETE</td><td>Ile d'Abeau</td><td>Forfait Trajet</td><td>1</td><td>$pris_trajet</td><td>$pris_trajet</td></tr>";
            $jour_repas = "<tr><td>".$jour_format."</td><td>CETE</td><td>Ile d'Abeau</td><td>Forfait Repas</td><td>1</td><td>$pris_repas</td><td>$pris_repas</td></tr>";
            echo $jour_trajet;
            echo $jour_repas;
            $nb_jour_ouvre++;
            if($jour_semaine != 5){
              echo $gris;
            }
          }
        }
        $t_t = $nb_jour_ouvre*18.20;
        $t_r = $nb_jour_ouvre*14.55;
        $t = $t_t + $t_r;

        echo "<tr><td></td><td></td><td></td><td></td><td colspan=2 class='table-secondary'>Total du mois</td><td class='table-secondary'>".number_format($t, 2, ',', ' ')." €</td></tr>";
        ?>
          </tbody>
        </table>
      </div>
      </div>
</div>
<div class="col-sm-2">
<div class="card" style="width: 20rem;">
    <div class="card-header">
        <div class='row'>
          <div class='col-sm-4' >recap</div>

      </div>
    </div>
    <div class="card-body">

  <table id='tableau2' class='table table-sm table-hover'>
    <thead>
      <tr>
        <th>Type</th><th>Nombre</th><th>Montant</th>
      </tr>
    </thead>
    <tbody>

  <?php

    echo "<tr><th>Total trajet</th><th>$nb_jour_ouvre</th><th>".number_format($t_t, 2, ',', ' ')." €</th></tr>";
    echo "<tr><th>Total repas</th><th>$nb_jour_ouvre</th><th>".number_format($t_r, 2, ',', ' ')." €</th></tr>";
    echo "<tr><th>Total mois</th><th>$nb_jour_ouvre</th><th>".number_format($t, 2, ',', ' ')." €</th></tr>";

   ?>

 </tbody>
 </table>

</div>
</div>
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
</div>
</div>
  </body>
</html>
