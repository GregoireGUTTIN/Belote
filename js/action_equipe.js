$('#ajout').click(function(){
  $.post( "action_equipe.php", {
        action: "ajout",
        nom1: $('#nom1').val(),
        nom2: $('#nom2').val() })
  .done(function( data ) {
    //alert( "Data Loaded: " + data );
    location.reload(true);
  });
});

$('#modif').click(function(){
  $.post( "action_equipe.php", {
        action: "modif",
        id: $('#num').val(),
        nom1: $('#nom1_mod').val(),
        nom2: $('#nom2_mod').val() })
  .done(function( data ) {
    //alert( "Data Loaded: " + data );
    location.reload(true);
  });
});

$('#reset').click(function(){
  $.post( "action_equipe.php", {
        action: "reset"
         })
  .done(function( data ) {
    //alert( "Data Loaded: " + data );
    location.reload(true);
  });
});

$('td button.btn-info').click(function(){
  var id = $(this).text();
  $.post( "action_equipe.php", {
        action: "info",
        id: id
        })
  .done(function( data ) {
    //alert( "Data Loaded: " + data );
    var equipe = jQuery.parseJSON(data);
     $('#num').val(id);
     $('#nom1_mod').val(equipe.nom1);
     $('#nom2_mod').val(equipe.nom2);
     $('#form_modif_equipe').focus();
  });
});

$('#form_ajout_equipe').on('shown.bs.modal', function () {
  $('#nom1').val("");
  $('#nom2').val("");
  $('#form_ajout_equipe').focus()
});
