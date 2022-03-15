let tableAtributo;
let rowTable="";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded',function(){
    tableAtributo = $('#tableAtributo').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Marqueteria/getAtributos",
            "dataSrc":""
        },
        "columns":[
            {"data":"title"},
            {"data":"categoria"},
            {"data":"price"},
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
                    "columns": [ 0, 1] 
                }
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Exportar a Excel",
                "className": "btn btn-success",
                "exportOptions": { 
                    "columns": [ 0, 1] 
                }
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": { 
                    "columns": [ 0, 1] 
                }
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Exportar a CSV",
                "className": "btn btn-info",
                "exportOptions": { 
                    "columns": [ 0, 1] 
                }
            }
        ],
        "responsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"asc"]]  
    });

    //NUEVA CATEGORÍA
    let formAtributos = document.querySelector("#formAtributos");
    formAtributos.onsubmit = function(e) {
        e.preventDefault();

        let strNombre = document.querySelector('#txtNombre').value;
        let intCategoria = document.querySelector('#listCategoria').value;
        let intPrecio = document.querySelector('#txtPrecio').value;

        if(strNombre == '' || intCategoria =='' || intPrecio == ''){
        
            swal("Atención", "Todos los campos son obligatorios" , "error");
            return false;
        }
        divLoading.style.display = "flex";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Marqueteria/setAtributo'; 
        let formData = new FormData(formAtributos);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
           if(request.readyState == 4 && request.status == 200){
                
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    if(rowTable == ""){
                        tableAtributo.api().ajax.reload();
                    }else{
                        rowTable.cells[1].textContent = strNombre;
                        rowTable.cells[2].textContent = objData.categoria;
                        rowTable.cells[3].textContent = objData.price;
                        rowTable = "";
                    }
                    $('#modalformAtributo').modal("hide");
                    formAtributos.reset();
                    swal("Atributo", objData.msg ,"success");
                }else{
                    swal("Error", objData.msg , "error");
                }              
            }
            divLoading.style.display = "none";
            return false; 
        }

        
    }
    

},false);

window.addEventListener('load',function(){
    fntCategorias();
},false);


function fntEditInfo(element, idtecnica){

    rowTable = element.parentNode.parentNode.parentNode;

    document.querySelector('#titleModal').innerHTML ="Actualizar";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl  = base_url+'/Marqueteria/getAtributo/'+idtecnica;
    request.open("GET",ajaxUrl ,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {
                document.querySelector("#idAtributo").value = objData.data.idattribute;
                document.querySelector("#txtNombre").value = objData.data.titulo;
                document.querySelector("#txtPrecio").value = objData.data.price;
                document.querySelector("#listCategoria").value = objData.data.subtopicid;
                $("#listCategoria").selectpicker("render");

            }else{
                swal("Error", objData.msg , "error");
            }
        }
        $('#modalFormAtributo').modal('show');
    }
}

function fntDelInfo(idtecnica){

    swal({
        title: "Eliminar",
        text: "¿Está seguro de eliminar?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Marqueteria/delAtributo/'+idtecnica;
            let strData = "idatributo="+idtecnica;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminado", objData.msg , "success");
                        tableAtributo.api().ajax.reload();
                    }else{
                        swal("Atención", objData.msg , "error");
                    }
                }
            }
        }

    });
}
function fntCategorias(){
    if(document.querySelector('#listCategoria')){

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl  = base_url+'/Marqueteria/getSelectSubcategorias';
        request.open("GET",ajaxUrl ,true);
        request.send(); 
        request.onreadystatechange = function(){
            if(request.readyState ==4 && request.status ==200){
                document.querySelector('#listCategoria').innerHTML = request.responseText;
                $('#listCategoria').selectpicker('render');
            }
        }
    }
}


function openModal(){
    rowTable ="";
    document.querySelector('#idAtributo').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva";
    document.querySelector("#formAtributos").reset();
	$('#modalFormAtributo').modal('show');
}