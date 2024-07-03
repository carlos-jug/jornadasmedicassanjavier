$(document).ready(function(){

    $('#Boton').on('click',function(eEvento){
        //prevenir el comportamiento normal del enlace
        eEvento.preventDefault();
		var left = ($(window).width() - 546)/2;
		var top = ($(window).height() - 720)/2;
		window.open('sender.html', 'PagoTarjeta', 'width=546,height=720,location=1,menubar=0,resizable=0,scrollbars=0,toolbar=0, left='+left+',top='+top);
    });

});