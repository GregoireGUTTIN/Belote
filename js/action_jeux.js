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
