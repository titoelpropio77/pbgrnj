$(document).ready(function () {
    /*AUMENTE TODO ESTO*/ //AUMENTE ESA RUTA Y UNA CONSULTA BUSCAR EN ROUTE LA RUTA Y A CONSULTA EN EL CONTROLADOR DE COMPRA
    var route="obtener_compra"
    $.get(route, function (res) {
          $(res).each(function (key, value) {
            variacion(value.id);            
          });
        $('#loading').css("display","none");             
    });
    /*HASTA ACA*/
    $('#oculta').hide(5000);    
    $(function (){ $("#datetimepicker1").datetimepicker({ viewMode: 'days',  format: 'YYYY-MM-DD' }); });
    $(function (){ $("#datetimepicker2").datetimepicker({ viewMode: 'days',  format: 'YYYY-MM-DD' }); });
    $('#btnPDF2').attr("disabled", true);
    var hoy = new Date();
    var dd = hoy.getDate();
    var mm = hoy.getMonth() + 1; //hoy es 0!
    var yyyy = hoy.getFullYear();
    if (dd < 10) {  dd = '0' + dd }
    if (mm < 10) {  mm = '0' + mm  }
    hoy = yyyy + '-' + mm + '-' + dd;
    $('#fecha_inicio').val(hoy);
    $('#fecha_fin').val(hoy);    
    cargar_lista_comra();
});

function obtener_id_silo(id_silo) {
$('#btncomprar'+id_silo).hide(); 
var cantidad = $("#cantidad"+id_silo).text();
var capacidad = $("#capacidad"+id_silo).text();
var id_sil = id_silo;
var nombre = $("#nombre"+id_silo).text();
var cantidad_total = $("#cantidad_total"+id_silo).val();
var precio_compra = $("#precio_compra"+id_silo).val();
 if (cantidad_total=="" || precio_compra=="") {
    alertify.alert('ERROR','INTRODUSCA LOS DATOS REQUERIDOS');
    $('#btncomprar'+id_silo).show();
 } else {
    //var token = $("#token").val();
    var x=parseFloat(cantidad)+parseFloat(cantidad_total);
    if (x<=capacidad) {
      alertify.confirm("MENSAJE","DESEA REALIZAR ESTA COMPRA EN EL "+nombre,
      function(){
            $('#loading').css("display","block");            
            $.ajax({
                url: "crear_compra",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'GET',
                dataType: 'json',
                data: {precio_compra: precio_compra, cantidad_total: cantidad_total, id_silo: id_sil},
                success:function(){                    
                    $("#cantidad_total"+id_silo).val("");
                    $("#precio_compra"+id_silo).val("");
                    $('#btncomprar'+id_silo).show();                    

                    $("#cantidad"+id_silo).text((parseFloat(cantidad) + parseFloat(cantidad_total)).toFixed(1));
                    $("#llenar"+id_silo).text((parseFloat($("#capacidad"+id_silo).text()) - parseFloat($("#cantidad"+id_silo).text())).toFixed(1));                        
                    
                    if (parseFloat($("#cantidad"+id_silo).text()) > parseFloat($("#cantidad_minima"+id_silo).val())) {
                            variacion(id_silo);
                            $("#alerta"+id_silo).hide();                        
                            $("#tabla"+id_silo).css({'background':'white'});              
                    } else {
                        $("#alerta"+id_silo).show();                       
                        $("#tabla"+id_silo).css({'background':'MistyRose'}); 
                    }
                   // setTimeout("location.href='compra'",1000);   
                    $('#loading').css("display","none"); 
                    alertify.success('COMPRA GUARDADO CORRECTAMENTE EN EL '+nombre);
                },
                error:function(){
                    $('#loading').css("display","none"); 
                    alertify.alert("ERROR","NO SE PUDO GUARDAR LOS DATOS INTENTE NUEVAMENTE");
                    //setTimeout("location.href='compra'",3000);            
                }
            });
      },
      function(){        
        alertify.error('COMPRA CANCELADA');
        $("#cantidad_total"+id_silo).val("");
        $("#precio_compra"+id_silo).val("");
        $('#btncomprar'+id_silo).show();
     }); 
    }
    else{
        alertify.alert("MENSAJE","LA CANTIDAD ES MAYOR A LA CAPACIDAD!!!!");
        $("#cantidad_total"+id_silo).val("");
        $("#precio_compra"+id_silo).val("");
        $('#btncomprar'+id_silo).show(); 
    }
  }    
}


function llenar_silo(id_silo) {
var nombre = $("#nombre"+id_silo).text();    
  alertify.confirm("MENSAJE","DESEA LLENAR EL "+nombre,
  function(){       
    var cantidad = $("#cantidad"+id_silo).text();
    var capacidad = $("#capacidad"+id_silo).text();
    var x=capacidad-cantidad;
    $("#llenar"+id_silo).text(x.toFixed(1));
    $("#cantidad_total"+id_silo).val(x.toFixed(1));
  },
  function(){});     
}

function variacion(id_silo) {
    var cantidad = $("#cantidad"+id_silo).text();
    var capacidad = $("#capacidad"+id_silo).text();
    var x=capacidad-cantidad;
    if (x==0){
        $("#btnllenar"+id_silo).attr("disabled", true);
        $("#btncomprar"+id_silo).attr("disabled", true);
        $("#cantidad_total"+id_silo).attr("disabled", true);
        $("#precio_compra"+id_silo).attr("disabled", true);                
        $("#llenar"+id_silo).text(x.toFixed(1));
    } 
    else {
        $("#btnllenar"+id_silo).attr("disabled", false);
        $("#btncomprar"+id_silo).attr("disabled", false);
        $("#cantidad_total"+id_silo).attr("disabled", false);
        $("#precio_compra"+id_silo).attr("disabled", false);
        $("#llenar"+id_silo).text(x.toFixed(1));                
    }
}


//REPORTE DADA DOS FECHAS TOTAL
function Cargar_reporte_compra(){
var fecha_inicio = $('#fecha_inicio').val();
var fecha_fin = $('#fecha_fin').val();
    if (fecha_inicio == "" || fecha_fin == "") {
            alertify.alert("MENSAJE",'INTRODUSCA LAS FECHAS');
    } else {
        var tabladatos=$("#datos_rct");
        var route = "lista_reporte_compra/"+fecha_inicio+"/"+fecha_fin;
        $("#datos_rct").empty();

        var primera = Date.parse(fecha_inicio); 
        var segunda = Date.parse(fecha_fin); 
         
        if (primera > segunda) {
           toastr.options.timeOut = 9000;
                    toastr.options.positionClass = "toast-top-right";
                    toastr.error('LA FECHA HASTA TIENE QUE SER MAYOR A LA FECHA DESDE!!!');
        } else{
            $.get(route,function(res){
                $("#datos_rct").empty();
               $(res).each(function(key,value){
                $('#fecha').text("DEL "+fecha_inicio+' / '+fecha_fin);
                if (value.detalle != 'saldo') {
                    tabladatos.append("<tr align=center><td>"+value.detalle+"</td><td>"+value.total+" Bs.</td></tr>");
                } else {
                    tabladatos.append("<tr style='background-color: #A9F5F2' align=center><td><font size=4 color=red>TOTAL</font></td><td><font size=4 color=red>"+value.total+" Bs.</font></td></tr>");
                    $('#btnPDF2').attr("disabled", false);
                }
                });
            }); 
        }                                                                                                                                            
    }
}

function cargar_fechas(){
    var fecha_inicio = $('#fecha_inicio').val();
    var fecha_fin = $('#fecha_fin').val(); 
    window.open('Reporte_Compra_Alimento/'+fecha_inicio+'/'+fecha_fin);                                                    
}

function cargar_lista_comra(){
    var fecha_inicio=$('#fecha_inicio').val();
    var fecha_fin=$('#fecha_fin').val();
    var tabladatos=$("#datos");

    var primera = Date.parse(fecha_inicio); 
    var segunda = Date.parse(fecha_fin); 
     
    if (primera > segunda) {
        alertify.alert("MENSAJE",'LA FECHA HASTA TIENE QUE SER MAYOR A LA FECHA DESDE!!!');
    } else{
        var route2 = "anular_compra/"+fecha_inicio+"/"+fecha_fin;
        $("#datos").empty();
        $.get(route2, function (res) {
        $("#datos").empty();
            $(res).each(function (key, value) {
                tabladatos.append("<tr align=center style='background-color:white' onmouseover='this.style.backgroundColor=\"#F6CED8\"' onmouseout='this.style.backgroundColor=\"white\"'><td width=206>"+value.nombre_silo+"</td><td width=206>"+value.nombre+"</td><td width=206>"+value.tipo+"</td><td width=206>"+value.cantidad_total+" kg.</td><td width=206>"+value.precio_compra+" Bs.</td><td width=206>"+value.fecha+"</td><td width=206><center><button value="+value.id_compra+" class='btn btn-danger' data-toggle='modal' data-target='#myModal' onclick='anular_compras("+value.id_compra+")' >ANULAR COMPRA</button></td></tr>");           
            });
        });   
    }
}

function anular_compras(id_compra) {
    $("#id_compra").val(id_compra);
}