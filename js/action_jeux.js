$('button.btn-warning').click(function(){
  var score1 = '#score1_'+$(this).val();
  var score2 = '#score2_'+$(this).val();
  $.post( "action_jeux.php", {
        action: "score_manche",
        score1: $(score1).val(),
        score2: $(score2).val(),
        id: $(this).val()
  })
  .done(function( data ) {
    //alert( "Data Loaded: " + data );
    location.reload(true);
  });
});


// sécurité pour la saisie des scores
$('input').focus(function() {
  $('button.btn-warning').prop('disabled', true);
  $('input').prop('disabled', true);
  var info = $(this).attr('id').split('_');
  $('#bouton_'+info[1]).prop('disabled', false);
  $('#score1_'+info[1]).prop('disabled', false);
  $('#score2_'+info[1]).prop('disabled', false);
  //alert(info[1]);
});


$('#generation').click(function() {
  var manche = Number($('#nummanche').val()) + 1;
  $.post( "action_match.php", {
        action: "generation",
        manche: manche
  })
  .done(function( data ) {
    //alert( "Data Loaded: " + data );
    location.href = "http://localhost/jeux.php?manche="+manche;
  });

});
