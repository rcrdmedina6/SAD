$(window).load(function() {
        
        $('#menu-apuestas').organicTabs();
        
});


//JSON para juegos activos
$.getJSON("/apuestas/php/parserJuegosActivos.php",function(json){
	 $( "#idNombreLiga" ).append(json.Juego1.participante1);
});




