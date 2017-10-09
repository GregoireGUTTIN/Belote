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

$('#active').click(function(){
    if ($('button.btn-warning').prop('disabled')) {
      $('button.btn-warning').prop('disabled', false);
    }else {
      $('button.btn-warning').prop('disabled', true);
    }
});

$('#desactive').click(function(){
  console.log($('button.btn-warning').prop('disabled'));
    $('button.btn-warning').prop('disabled', true);
});
