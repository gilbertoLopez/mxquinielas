$(".fondo").animate({opacity:0.8,width:"100%",height:"100%",top:0,left:0},600,"linear",function(){$(this).animate({opacity:1},250,"linear");});
if(navigator.userAgent.match(/iemobile/i)) 
{                                       
    alert('Atencion: Puede tener problemas de incompatibilidad con su IE Mobile');
}
function menu(){
    var $menu = $("#menuPrin");
    var pos   = $menu.offset();
    if (pos.top != 0) {
        $menu.animate({
            top: '0'
        });
        
    }else{
        $menu.animate({
            top: '-100%'
        });
    }
}
function cancelaPartido(){
    $(".areaPartido").each(function(){
        var status = parseInt($(this).attr("data-status"));
        if(status == 0){
            $(this).find("input").attr("disabled","disabled");
            $(this).find("select").html("<option value='-'>cancelado</option>").attr("readonly","readonly").removeClass('requerido');
            $(this).find("label").off("click");
            $(this).find("label").off("dblclick");
        }
    });
}
$(".menuDesp").on("click",menu);
$("#menuPrin li").on("click",function(){
    var mod = $(".menu").css("position");
    var regreso = false;
    var url = $(this).find("a").attr("href");
    if(url.match(/^#/i))
    {
        $(url).toggle("clip");
    }
    else{
        regreso = true;
    }
    if (mod == "fixed") {
        menu();
    }
    return regreso;
});
$(".cerrar").on("click",function(){
    $(this).parent().hide(500);
});

var resultadosPart = function(){
    var form = $("#cJornada").attr("for");
    var area = $("#"+form).attr("for");
    if ( $.trim( $("#cJornada").val() ) != "" ) {
       $("#"+area).show().find("div").html("<img src='includes/img/iconos/cargando.gif' style='width:40px;height:40px;display:block;margin:10px auto;'/>");
       $("#"+form).trigger("submit");
       $("#cJornada,#actResult").attr("disabled","disabled");
    }
    else{
        $("#"+area).hide().find("div").html("");
    }
}
$("#actResult").on("click",resultadosPart);
$("#cJornada").on("change",resultadosPart);
function cronometro(){
    timekeeper(function(span,time){
        $(".now").html(time.now.hour+":"+time.now.minut+":"+time.now.second);
        if(time.to.type == 1){
            if(time.to.hour == 0){
                if(time.to.minut < 46 ){
                    $(span).html("Primer tiempo, minuto "+time.to.minut+" * ");
                }else{
                    $(span).html("Medio tiempo * ");
                }
            }else if(time.to.hour == 1){
                if(time.to.minut < 46 ){
                    $(span).html("Segundo tiempo, minuto "+time.to.minut+" * ");
                }else{
                    $(span).html("Partido finalizado  * ");
                }
            }else{
                $(span).html("Partido finalizado");
                $(span).removeClass("timekeeper");
                cronometro();
            }
        }else{
            $(span).html("Falta "+time.to.hour+":"+time.to.minut+":"+time.to.second);
        }
    });
}
$("form.ajax").on("submit",function(){
    var $form  = $(this);
    var url    = $form.attr("action");
    var metodo = $form.attr("method");
    var tipoR  = $form.attr("type");
    var datos  = $form.serialize();
    var async  = true;
    ajax(url,metodo,tipoR,datos,async,function(resp){accionForm(resp)});
    return false;
});
function accionForm(datos) {
    if (datos.accion == "llenarQuin") {
        $("#areaQuin").show().find("div").html(datos.contenido);
        seleccionaQuin();
        cancelaPartido();
    }
    else if (datos.accion == "mostrarQuin") {
        $("#areaQuin").show().find("div").html(datos.contenido);
        ganador();
        cronometro();
        /*ganador();*/
    }
    else if (datos.accion == "torneo") {
        $("#areaTorn").show().find("div").html(datos.contenido);
        partidosAct();
    }
    $("#cJornada,#actResult").removeAttr("disabled");
}

function partidosAct() {
    $(".fPartidos").on("submit",function(){
        var check = $(this).find("input[type='checkbox']:checked").val();
        var texta = $(this).find("textarea");
        var enviar = true;
        if (check != undefined) {
            if ($.trim(texta.val()) == "") {
                enviar = false;
            }
        }
        else{
            $(this).find(".requerido").each(function(){
                if ($.trim($(this).val()) == "") {
                    enviar = false;
                }
            });
        }
        if (enviar) {
            var $form  = $(this);
            var url    = $form.attr("action");
            var metodo = $form.attr("method");
            var tipoR  = $form.attr("type");
            var datos  = $form.serialize();
            var async  = true;
            ajax(url,metodo,tipoR,datos,async,function(resp){
                console.log(resp);
                alert(resp.estatus);
            });
        }
        return false;
    });
    $(".fPartidos input[type='checkbox']").on("click",function(){
        var txta = $(this).attr("for");
        if ($(this).is(":checked")) {
            $("#"+txta).show("500");
            $(".requerido").val("").attr("disabled","disabled");
        }
        else{
            $("#"+txta).hide("500");
            $(".requerido").removeAttr("disabled");
        }
    });
    $("input[type='number']").on("change",function(){
        var para = $(this).attr("for");
        var r1 = 0;
        var r2 = 0;
        if ($(this).hasClass("local")) {
            r1 = $(this).val();
            r2 = $("input[for="+para+"].visitante").val();
        }
        else{
            r1 = $("input[for="+para+"].local").val();
            r2 = $(this).val();
        }
        if (r1 == r2) {
            $("#"+para).val("empate");
        }else if (r1 > r2) {
            $("#"+para).val("local");
        }else if (r1 < r2) {
            $("#"+para).val("visitante");
        }
    });
}

function seleccionaQuin(){
    $("#areaQuin label").on("click",function(){
        var equipo = $(this);
        var combo  = equipo.attr("for");
        var valor  = equipo.attr("value");
        if ($('#'+combo).attr("disabled") == undefined) {
            $('#'+combo).val(valor);
        }
        else{
            $(".comodin2[for='"+combo+"'][value='"+valor+"']").trigger("click");
        }
    });
    $("#areaQuin label").on("dblclick",function(){
        var equipo = $(this);
        var combo  = equipo.attr("for");
        $('#'+combo).val("empate");
    });
    $("#areaQuin input[name='comodin']").on("change",function(){
        $(".areaSeleccion select:hidden").show().val("").removeAttr("disabled").addClass("requerido");
        $(".areaSeleccion table:visible").hide().find("input[type='checkbox']:checked").removeAttr("checked");
        $("#comodinComp").val("");
        var comodin = $(this).val();
        var combo  = '#select-'+comodin;
        var tabla  = '#table-'+comodin;
        $(combo).attr("disabled","disabled").removeClass("requerido");
        $(combo+","+tabla).toggle();
    });
    $(".areaSeleccion table .comodin2").on("click",function(){
        var total = $(".areaSeleccion table:visible input[type='checkbox']:checked").length;
        if (total == 2) {
            $("#comodinComp").val("ok");
        }
        else{
            if (total == 3) {
                $(".areaSeleccion table:visible input[type='checkbox']:checked").not($(this)).first().removeAttr("checked");
            }
            else{
                $("#comodinComp").val("");
            }
        }
    });
    $("#fQuinUsua").on("submit",function(){
        var enviar = true;
        var mensaje = '';
        $(this).find(".requerido").each(function(a,b){
            if($.trim($(b).val()) == ""){
                mensaje = $(b).attr("title")+'\n';
                enviar = false;
            }
            return enviar;
        });
        if (enviar) {
            $("#enviarQuin").attr("disabled","disabled");
            var $form  = $(this);
            var url    = $form.attr("action");
            var metodo = $form.attr("method");
            var tipoR  = $form.attr("type");
            var datos  = $form.serialize();
            var async  = true;
            $("#enviarQuin").html("<img src='includes/img/iconos/cargando.gif' style='width:20px;height:20px;display:block;margin: 0 auto;'/>");
            ajax(url,metodo,tipoR,datos,async,function(resp){
                alert(resp.mns);
                if (resp.status == 'OK') {
                     $("#fQuin").trigger("submit");
                }
            });
        }
        else{
            alert(mensaje);
        }
        return false;
    });
}
function ganador(){
    var max = 0;
    $("td.total").each(function(){
        var val = parseInt($(this).attr("data-value"));
        if ( val > max ){
            max = val;
        }
    });
    if(max != 0){
        $("td[data-value='"+max+"']").parent().addClass("color2");
    }
}
//===================================================================== funcion de cuenta regresiva

function timekeeper(callback){
    if(callback === undefined){
        callback = function(){};
    }
    var timeK = [];
    var spanT = [];
    var index = 0;
    var clockFormat = function clockFormat(num) {
        return String("00" + num).slice(-2);
    }
    $(".timekeeper").each(function(){
        var time     = $(this).attr("data-time").split(":");
        spanT[index] = this;
        timeK[index] = new Date();
        timeK[index].setHours(time[0]);
        timeK[index].setMinutes(time[1]);
        timeK[index].setSeconds(time[2]);
        index++;
    });
    var tKeeper = function tKeeper(){
        var now = new Date();
        $.each(timeK,function(key,tk){
            var type = 0;
            var hour = (tk.getHours()-now.getHours())-1;
            var min  = (tk.getMinutes()-now.getMinutes())+59;
            var sec  = (tk.getSeconds()-now.getSeconds())+60;
            if (min > 59) {
                hour++;
                min = min - 60;
            }
            if(hour < 0 ){
                hour = (hour * -1 ) - 1;
                min  = 59 - min;
                sec  = now.getSeconds();
                type = 1;
            }
            sec = sec == 60 ? 0 : sec;
            callback(spanT[key],{
                now : { 
                    hour   : clockFormat(now.getHours()), 
                    minut  : clockFormat(now.getMinutes()), 
                    second : clockFormat(now.getSeconds()) 
                }, to : {
                    hour   : clockFormat(hour),
                    minut  : clockFormat(min),
                    second : clockFormat(sec),
                    type   : type
                }
            });
        });
        setTimeout(tKeeper,1000);
    }.call();
}