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
    "order":[[3,"desc"]]  
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
                document.querySelector("#subtotal").innerHTML = objData.orden.price;
                document.querySelector("#totalprecio").innerHTML = objData.orden.price;
                let arrDetalle = objData.detalle;
                let html="";
                for (let i = 0; i < arrDetalle.length; i++) {
                    let largo = arrDetalle[i]['length'];
                    let ancho = arrDetalle[i]['width'];
                    let medidas="";
                    if( largo != 0 && ancho != 0){
                        medidas = `<p>${largo}cm X ${ancho}cm</p>`;
                    }
                    html+=` <tr>
                                <td>
                                    <p>${arrDetalle[i]['title']}</p>
                                    ${medidas}
                                    <p>${arrDetalle[i]['subtopic']}</p>
                                    <p>${arrDetalle[i]['type']}</p>
                                </td>
                                <td>${arrDetalle[i]['price']}</td>
                                <td>${arrDetalle[i]['quantity']}</td>
                                <td>${arrDetalle[i]['total']}</td>
                            </tr>`;
                }
                document.querySelector("#detalle").innerHTML = html;

            }
        }
    }

}

function fntEditInfo(idpedido){
    document.querySelector('#pills-make-tab').classList.add("active");
    document.querySelector('#pills-make').classList.add("active","show");
    document.querySelector('#pills-products').classList.add("d-none");
    document.querySelector('#pills-products-tab').classList.add("d-none");
}

