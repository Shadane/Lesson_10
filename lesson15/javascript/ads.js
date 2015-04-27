$(function(){
$('a.delete').click(function(){
                              var id = $(this).attr('id');
                              var tr = $(this).closest('tr');
                              console.log(id);
  function deleteSuccess(){
    tr.fadeOut('slow',function(){
                      $(this).remove()});
  }
  
  $('div#container').load('buttonLogic.php?delentry='+id,deleteSuccess);
  });
});


