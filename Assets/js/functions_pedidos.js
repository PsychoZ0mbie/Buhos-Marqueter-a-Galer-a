let tablePedidos;
let rowTable;
let divLoading = document.querySelector("#divLoading");
$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});
tablePedidos = $('#tablePedidos').dataTable( {
    "aProcessing":true,
    "aServerSide":true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax":{
        "url": " "+base_url+"/Pedidos/getPedidos",
        "dataSrc":""
    },
    "columns":[
        {"data":"idorderdata"},
        {"data":"firstname"},
        {"data":"lastname"},
        {"data":"date"},
        {"data":"price"},
        {"data":"status"},
        {"data":"options"}
    ],
    'dom': 'lBfrtip',
    'buttons': [
        {
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i> Copiar",
            "titleAttr":"Copiar",
            "className": "btn btn-secondary",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
        },{
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr":"Exportar a Excel",
            "className": "btn btn-success",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
        },{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr":"Exportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
        },{
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr":"Exportar a CSV",
            "className": "btn btn-info",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
        }
    ],
    "responsieve":"true",
    "bDestroy": true,
    "iDisplayLength": 10,
    "order":[[0,"desc"]]  
});

window.addEventListener('load',function(){
    document.querySelector('#pills-make').classList.add("d-none");
    document.querySelector('#pills-make-tab').classList.add("d-none");
    
},false);


function fntViewInfo(idpedido,idpersona){
    document.querySelector('#pills-make').classList.remove("d-none");
    document.querySelector('#pills-make-tab').classList.remove("d-none");
    document.querySelector('#pills-make-tab').classList.add("active");
    document.querySelector('#pills-make').classList.add("active","show");
    document.querySelector('#pills-products').classList.add("d-none");
    document.querySelector('#pills-products-tab').classList.add("d-none");

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+"/pedidos/getPedidoDetalle";
    let formData =new FormData();
    formData.append("idpedido",idpedido);
    formData.append("idpersona",idpersona);

    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange=function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                document.querySelector("#fecha").innerHTML = objData.orden.date;
                document.querySelector("#numOrden").innerHTML = objData.orden.idorderdata;
                document.querySelector("#nombre").innerHTML = objData.orden.firstname+" "+objData.orden.lastname;
                document.querySelector("#identificacion").innerHTML = objData.orden.identification;
                document.querySelector("#email").innerHTML = objData.orden.email;
                document.querySelector("#telefono").innerHTML = objData.orden.phone;
                document.querySelector("#departamento").innerHTML = objData.orden.departamento;
                document.querySelector("#ciudad").innerHTML = objData.orden.ciudad;
                document.querySelector("#direccion").innerHTML = objData.orden.address;
                document.querySelector("#mensaje").innerHTML = objData.orden.comment;
                document.querySelector("#subtotal").innerHTML = objData.orden.price+" "+md;
                document.querySelector("#totalprecio").innerHTML = objData.orden.price+" "+md;
                let arrDetalle = objData.detalle;
                let html="";
                for (let i = 0; i < arrDetalle.length; i++) {
                    let largo = arrDetalle[i]['length'];
                    let ancho = arrDetalle[i]['width'];
                    let medidas="";
                    let tipo="";
                    if( largo != 0 && ancho != 0){
                        medidas = `<p><strong>Medidas:</strong> ${largo}cm X ${ancho}cm</p>`;
                    }
                    if(arrDetalle[i]['type']!=""){
                        tipo = `<p><strong>Tipo:</strong> ${arrDetalle[i]['type']}</p>`;
                    }
                    if(arrDetalle[i]['topic'])
                    html+=` <tr>
                                <td>
                                    <p><strong>Referencia:</strong> ${arrDetalle[i]['title']}</p>
                                    ${medidas}
                                    <p><strong>Categoría:</strong> ${arrDetalle[i]['topic']}</p>
                                    
                                    <p><strong>Técnica/Color:</strong> ${arrDetalle[i]['subtopic']}</p>
                                    ${tipo}
                                    
                                </td>
                                <td>${arrDetalle[i]['price']} ${md}</td>
                                <td>${arrDetalle[i]['quantity']}</td>
                                <td>${arrDetalle[i]['total']} ${md}</td>
                            </tr>`;
                }
                document.querySelector("#detalle").innerHTML = html;

            }
        }
    }

}

function fntEditInfo(idorden,idcliente){
    let idpedido = idorden;
    let idpersona = idcliente;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url+"/pedidos/getPedido";
    let formData = new FormData();
    formData.append("idpedido",idpedido);
    formData.append("idpersona",idpersona);
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            document.querySelector("#pedido").innerHTML = objData.orden.idorderdata;
            document.querySelector("#cliente").innerHTML = objData.orden.firstname+" "+objData.orden.lastname;
            document.querySelector("#totalpedido").innerHTML = objData.orden.price;
            document.querySelector("#listEstado").innerHTML = objData.estado;
            $('#modalFormPedido').modal("show");
            if(document.querySelector("#formPedido")){
                let formPedido = document.querySelector("#formPedido");
                formPedido.onsubmit=function(e){
                    e.preventDefault();
                    let estado = document.querySelector("#listEstado").options[document.querySelector("#listEstado").selectedIndex].text;
                    let requestForm = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
                    let ajaxUrlForm = base_url+"/pedidos/updatePedido"
                    let formDataForm = new FormData();

                    formDataForm.append("idpedido",idpedido);
                    formDataForm.append("idpersona",idpersona);
                    formDataForm.append("estado",estado);

                    request.open("POST",ajaxUrlForm,true);
                    request.send(formDataForm);
                    request.onreadystatechange = function(){
                        if(request.readyState == 4 && request.status == 200){
                            let objData = JSON.parse(request.responseText);
                            if(objData.status){
                                swal("Actualizado",objData.msg,"success");
                                tablePedidos.api().ajax.reload();
                            }else{
                                swal("Error",objData.msg,"error");
                            }
                            $('#modalFormPedido').modal("hide");
                        }
                    }
                }
            }
            
        }
    }
    
}

function fntDelInfo(idorden,idcliente){
    swal({
        title: "Eliminar",
        text: "¿Estas segur@?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    },function(isConfirm){
        if(isConfirm){
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+"/pedidos/delPedido";
            let formData = new FormData();

            formData.append("idorden",idorden);
            formData.append("idpersona",idcliente);

            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.status==200 && request.readyState==4){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status){
                        swal("Eliminado",objData.msg,"success");
                        tablePedidos.api().ajax.reload();
                    }else{
                        swal("Error",objData.msg,"error");
                    }
                }
            }
        }
    });
    
}



