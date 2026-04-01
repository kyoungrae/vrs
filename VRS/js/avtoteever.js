 $(function(){
        'use strict'
		//Бусад мэдээлэл дээр дарах үед жагсаалтыг нээх
		$( "#moreHistory" ).click(function() {
		  $(".moreHistory").toggle();
		});
		$( "#moreInformation" ).click(function() {
		  $(".moreInformation").toggle();
		});
		$( "#moreService" ).click(function() {
		  $(".moreService").toggle();
		});
      });
 $(window).on('load', function() {
     $(".required-input").append("<span class='mandatory'>*</span>")
 });
 function limitText(field, maxChar){
     var ref = $(field),
         val = ref.val();
     if ( val.length >= maxChar ){
         ref.val(function() {
             return val.substr(0, maxChar);
         });
     }
 }

 $('.topSeachFormNumberId').keydown(function(event) {
     is_top = true;
     if (is_top) {
         if (event.keyCode == 13) {
             this.form.submit();
             return false;
         }
     }
 });

 $('.topSeachFormNumberId').keyup(function(){
     this.value = this.value.toUpperCase();
 });