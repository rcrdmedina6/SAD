 "use strict";

var j = jQuery.noConflict();

  j.getJSON("/vista_apuesta/php/convertirJson.php",function(json){
    //Contador de juegos
    var x= 0;
    //Contador de Runlines
    var a=0;
    var string=0;

      j.each( json.Odds, function( key, val) {
        j.each( val, function(y) {
          string =String(val[y].aname);
          if ( !string.test('Winner','i') ) {
            x++;
            j("#idContenedorTabla").clone().attr("id","idContainerXmlTable"+ String(x) ).appendTo('#idFormXmldefault');
            //Muestra las tablas de las apuestas, ya que son clonadas del html la cual esta oculta
            j("#idContainerXmlTable"+ String(x)).show();

            //Cabera de la tabla
            j("#idContainerXmlTable"+ String(x)+" .valoresCampos "+" table"+" tr"+" td"+" #idNameJuego").append(val[y].aname);
            j("#idContainerXmlTable"+ String(x)+" .valoresCampos "+" table"+" tr"+" td"+" #idInicioJuego").attr("value", val[y].GameStartTime);
            j("#idContainerXmlTable"+ String(x)+" .valoresCampos "+" table"+" tr"+" td"+" #idFinApuesta").attr("value", val[y].BettingEndTime);
            j("#idContainerXmlTable"+ String(x)+" .valoresCampos "+" table"+" tr"+" td"+" #idLiveBet").attr("value", val[y].LiveBet);
            j("#idContainerXmlTable"+ String(x)+" .valoresCampos "+" table"+" tr"+" td"+" #idIsRunning").attr("value", val[y].IsRunning);

            //Contenido de la tabla de apuestas
            //Participantes
            j("#idContainerXmlTable"+ String(x)+" div "+" .tabla"+" .tablaXml"+" tr"+" td" +" #idParticipante1").attr("value", val[y].Participant[0].c);
            j("#idContainerXmlTable"+ String(x)+" div "+" .tabla"+" .tablaXml"+" tr"+" td" +" #idParticipante2").attr("value", val[y].Participant[1].c);
            //Logro aGanar
            //Bucle que recorre el OutcomeSet de la apuesta Aganar
            j.each( val[y].OutcomeSet, function(key1, val1) {
            //Bucle que recorre el Outcome de los OutcomeSet de la  apuesta Aganar
              j.each( val1, function(z,w)  {
                //Valida que el OutcomeSet sea Aganar
                if (val1[z] == "Result") {
                //Valida que el odds sea el del participante 1 para ello compara el id mostrado en Game.Participant con el de Outcomeset.Outcome.participant
                  if (val[y].Participant[0].aid == val1.Outcome[0].Participant.aid) {
                      j("#idContainerXmlTable"+ String(x)+" div "+" .tabla"+" .tablaXml"+" tr"+" td" +" #idLogroAganar1").attr("value", val1.Outcome[0].aodds);
                      j("#idContainerXmlTable"+ String(x)+" div "+" .tabla"+" .tablaXml"+" tr"+" td" +" #idLogroAganar2").attr("value", val1.Outcome[1].aodds);
                  }
                }
                if (val1[z] == "Handicap") {
                  console.log(val[y].aname);
                  console.log("odds1: "+ val1.Outcome[0].aodds);
                  console.log("odds2: "+ val1.Outcome[1].aodds);
                  console.log("OptionalValue1: "+val1.Outcome[0].OptionalValue1);
                  console.log("OptionalValue2: "+val1.Outcome[1].OptionalValue1);
                  //a++;
                  //RunlineTabla(a,x,"Cabecera");
                  //RunlineTabla(a,x,"Equipo1");
                  //RunlineTabla(a,x,"Equipo2");
                } 
              }); 
            });
          }
        });
    });
  function RunlineTabla (numero,numIdTabla,tipo ) {
    j("#id"+tipo+"Runline").clone().attr("id","idContaRunlineTable"+ String(numero) ).appendTo("#idContainerXmlTable"+ String(numIdTabla)+ 
                                                                                                     " div" + " .tabla" +" #idTablaXml"+
                                                                                                     " #id"+tipo);
    j("#idContaRunlineTable"+ String(numero)).show();
  } 
  });
