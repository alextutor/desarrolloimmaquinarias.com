/*
jQuery(function($) {
	 var $cabecera = $('#header_ctn');
	  $('#header_ctn').css('-webkit-transition','transform 0.6s')
	//  $('#header_ctn').css('transform','translateY(-100%)')
	  
	    //var $cabecera = $('.masthead');
   // var $cabecera = $('#header');
  //  var $logo = $('#logo');
    var previousScroll = 0;
    $(window).scroll(function(event){
       var scroll = $(this).scrollTop();
       if (scroll > previousScroll && scroll > 200){
           //alert("alex");	
          // $logo.addClass('logoOnOff');
          // $cabecera.addClass('bgcolor');
          //$cabecera.addClass('stykerheadercolor');
          $('#header_ctn').css('background-color','#000000')
          $('#header_ctn').css('height','80px')
          $('.hfe-site-logo-img').css('height','60px')
         
          $('#mimenu-principal li a').css('color','#ffffff')
         // $('#mimenu-principal li a:active').css('color','#000000')
            
          
       } else {
          //$logo.removeClass('logoOnOff');
           //$cabecera.removeClass('bgcolor');
            //$cabecera.removeClass('stykerheadercolor');
            $('#header_ctn').css('height','100px')
            
             $('.hfe-site-logo-img').css('height','auto')
            
            $('#mimenu-principal li a').css('color','#000000')
            
       }
       previousScroll = scroll;    });
       
});


*/

/*
$(function() {
    $(window).on("scroll", function() {
        if($(window).scrollTop() > 50) {
            $(".elementor-sticky--effects").addClass("active");
        } else {
            //remove the background property so it comes transparent again (defined in your css)
           $(".elementor-sticky--effects").removeClass("active");
        }
    });
});
*/

/*Alex recuerda para addClass deves ponerle a la seccion de elementor un ID y con ese ID se le asigna una clase 
Funcion para que la cabecera al hacer scroll cambie de color
*/


/*----para cambiar color y darle transicion a los iconos  envio gratis / Delivery /Pago con tarjeta / etc  y sus respectivos textos */
jQuery(function($) {
    $('#ttcmsservices1').hover(function() {
       // alert('hola');
        $('#ttservice1-ico1 .elementor-icon').css('color','#6B8E3C')
        $('#ttservice1-ico1 .elementor-icon').css('transform','rotateY(180deg)')
        $('#ttservice1-ico1 .elementor-icon').css('-webkit-transition','transform 0.6s')
        
        $('#ttservice1-text1 .elementor-heading-title').css('color','#6B8E3C')
       }, 
        
        function(){
             $('#ttservice1-ico1 .elementor-icon').css('color','#F5A016')
             $('#ttservice1-ico1 .elementor-icon').css('transform','rotateY(0deg)')
              
             $('#ttservice1-text1 .elementor-heading-title').css('color','#000000')
         });
});

/****************************/
jQuery(function($) {
    $('#ttcmsservices2').hover(function() {
       // alert('hola');
        $('#ttservice1-ico2 .elementor-icon').css('color','#6B8E3C')
        $('#ttservice1-ico2 .elementor-icon').css('transform','rotateY(180deg)')
        $('#ttservice1-ico2 .elementor-icon').css('-webkit-transition','transform 0.6s')
        
        $('#ttservice1-text2 .elementor-heading-title').css('color','#6B8E3C')
       }, 
        
        function(){
             $('#ttservice1-ico2 .elementor-icon').css('color','#F5A016')
             $('#ttservice1-ico2 .elementor-icon').css('transform','rotateY(0deg)')
              
             $('#ttservice1-text2 .elementor-heading-title').css('color','#000000')
         });
});

/****************************/
jQuery(function($) {
    $('#ttcmsservices3').hover(function() {
       // alert('hola');
        $('#ttservice1-ico3 .elementor-icon').css('color','#6B8E3C')
        $('#ttservice1-ico3 .elementor-icon').css('transform','rotateY(180deg)')
        $('#ttservice1-ico3 .elementor-icon').css('-webkit-transition','transform 0.6s')
        
        $('#ttservice1-text3 .elementor-heading-title').css('color','#6B8E3C')
       }, 
        
        function(){
             $('#ttservice1-ico3 .elementor-icon').css('color','#F5A016')
             $('#ttservice1-ico3 .elementor-icon').css('transform','rotateY(0deg)')
              
             $('#ttservice1-text3 .elementor-heading-title').css('color','#000000')
         });
});

/****************************/
jQuery(function($) {
    $('#ttcmsservices4').hover(function() {
       // alert('hola');
        $('#ttservice1-ico4 .elementor-icon').css('color','#6B8E3C')
        $('#ttservice1-ico4 .elementor-icon').css('transform','rotateY(180deg)')
        $('#ttservice1-ico4 .elementor-icon').css('-webkit-transition','transform 0.6s')
        
        $('#ttservice1-text4 .elementor-heading-title').css('color','#6B8E3C')
       }, 
        
        function(){
             $('#ttservice1-ico4 .elementor-icon').css('color','#F5A016')
             $('#ttservice1-ico4 .elementor-icon').css('transform','rotateY(0deg)')
              
             $('#ttservice1-text4 .elementor-heading-title').css('color','#000000')
         });
});


/*----------------------------------------------------------------------*/

jQuery(function($) {
});    
    
    