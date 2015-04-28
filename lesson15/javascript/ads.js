$(function(){
$('a.delete').click(function(){
  $(this).attr('disabled', 'disabled');
                              var id = $(this).attr('id');
                              var tr = $(this).closest('tr');
                              console.log(id);
  function deleteSuccess(id){
    tr.fadeOut('slow',function(){
                      $(this).remove();
                      
                      show_popup();
    });
 }
 

  
 
 function show_popup(){
      $("#adsContainer").after('<h4 style="position: absolute;height: 300px" id="dynamic">Объявление успешно удалено.</h4>');
      $("#dynamic").slideUp(800, 'linear', function(){
          $(this).remove()
      });
   };
  
  $('div#adsContainer').load('buttonLogic.php?delentry='+id,deleteSuccess(id));

  });
  });


