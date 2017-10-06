$('div.btn-group button.btn-info').click(function(){
  var id = $(this).text();
  //alert( "Data Loaded: " + id );
  if (localStorage.equipe1){
    $.post( "action_match.php", {
          action: "ajout",
          manche: $('#nummanche').val(),
          equipe1: localStorage.equipe1,
          equipe2: id })
    .done(function( data ) {
      //alert( "Data Loaded: " + data );
      location.reload(true);
    })
    .always(function() {
      localStorage.removeItem("equipe1");
      //alert( "test" );
    });
  }else {
    $('#attente').html($(this).parent().html());
    // alert($(this).parent().html());
    $(this).parent().remove();
    localStorage.equipe1 = id;
  }
});


$('button.btn-warning').click(function(){
  $.post( "action_match.php", {
        action: "sup",
        id: $(this).val()
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
