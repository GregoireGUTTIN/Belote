$('#form_ajout_equipe').on('shown.bs.modal', function () {
  $('#nom1').val("");
  $('#nom2').val("");
  $('#form_ajout_equipe').focus()
})


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
