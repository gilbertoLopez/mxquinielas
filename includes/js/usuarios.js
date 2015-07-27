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
    }
    else if (datos.accion == "mostrarQuin") {
        $("#areaQuin").show().find("div").html(datos.contenido);
        ganador();
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

function cuenta() {
    var fechaP = new Array();
    var campo  = new Array();
    var fTime  = new Array();
    $(".hora.partidoAct").each(function(i){
        var tiempo = $(this).text().split(":");
        $(this).append("<br/><span></span>");
        campo[i]  = $(this);
        fechaP[i] = new Date();
        fechaP[i].setHours(tiempo[0]);
        fechaP[i].setMinutes(tiempo[1]);
        fechaP[i].setSeconds(tiempo[2]);
        fTime[i] = null;
    });
    function regresivo() {
        var fecha  = new Date();
        var contador = 0;  
        $.each(fechaP,function(i,h){
            contador = i;
            var hor = (h.getHours()-fecha.getHours())-1;
            var min = (h.getMinutes()-fecha.getMinutes())+59;
            var seg = (h.getSeconds()-fecha.getSeconds())+59;
            if (min > 59) {
                hor++;
                min = fReloj(min-60);
            }
            
            if (hor > -1)
            {
                $(campo[i]).find('span').html('Falta '+fReloj(hor)+':'+fReloj(min)+':'+fReloj(seg));
            }else
            {
                if (hor == -1) {
                    if (min < 46) {
                        $(campo[i]).find('span').html('1er Tiempo, min. '+fReloj(min));
                    }
                    else if (min <= 59 ) {
                        $(campo[i]).find('span').html('Medio tiempo');
                    }
                }
                else if((hor == -2)){
                    if (min < 46) {
                        $(campo[i]).find('span').html('2do Tiempo, min. '+fReloj(min));
                    }
                    else{
                        $(campo[i]).html('');
                    }
                }
                else{
                    $(campo[i]).html('');
                }
            }
        });
            setTimeout(regresivo,1000);
    }
    regresivo();
}


function timekeeper(){
        $(".timekeeper").each(function(){
            var time = $(this).attr("data-time").split(":");
            var now = new Date();
            var tk   = new Date();
            tk.setHours(time[0]);
            tk.setMinutes(time[1]);
            tk.setSeconds(time[2]);
            var hour = (tk.getHours()-now.getHours())-1;
            var min  = (tk.getMinutes()-now.getMinutes())+59;
            var sec  = (tk.getSeconds()-now.getSeconds())+60;
            if (min > 59) {
                hour++;
                min = min-60;
            }
            if(hour < 0 ){
                hour = (hour * -1 ) - 1;
                min = 59 - min;
                sec = now.getSeconds();
            }
            sec = sec == 60 ? 0 : sec;
            $(this).html(clockFormat(hour)+":"+clockFormat(min)+":"+clockFormat(sec));  
            $(".now").html(clockFormat(now.getHours())+":"+clockFormat(now.getMinutes())+":"+clockFormat(now.getSeconds()));
        });
        setTimeout(timekeeper,1000);
    }

    function timekeeper2(){
        var timeK = [];
        var index = 0;
        $(".timekeeper").each(function(){
            var time = $(this).attr("data-time").split(":");
            timeK[index] = new Date();
            timeK[index].setHours(time[0]);
            timeK[index].setMinutes(time[1]);
            timeK[index].setSeconds(time[2]);
            var hour = (tk.getHours()-now.getHours())-1;
            var min  = (tk.getMinutes()-now.getMinutes())+59;
            var sec  = (tk.getSeconds()-now.getSeconds())+60;
            if (min > 59) {
                hour++;
                min = min-60;
            }
            if(hour < 0 ){
                hour = (hour * -1 ) - 1;
                min = 59 - min;
                sec = now.getSeconds();
            }
            sec = sec == 60 ? 0 : sec;
            $(this).html(clockFormat(hour)+":"+clockFormat(min)+":"+clockFormat(sec));  
            $(".now").html(clockFormat(now.getHours())+":"+clockFormat(now.getMinutes())+":"+clockFormat(now.getSeconds()));
        });
        setTimeout(timekeeper,1000);
    }
    function clockFormat(num) {
        return String("00" + num).slice(-2);
    }
function fReloj(num) {
    return String("00" + num).slice(-2);
}*/