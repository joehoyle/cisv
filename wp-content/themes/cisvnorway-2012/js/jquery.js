 $(document).ready(function() {
   $('.hide,#searchform').hide();
 });
 $(document).ready(function() {
   $('.show').click(function(){
     $('.show,#introtekst').hide();
     $('.hide,#searchform').show();
   });
   $('.hide').click(function(){
     $('.hide,#searchform').hide();
     $('.show, #introtekst').show();
   });
 }); 