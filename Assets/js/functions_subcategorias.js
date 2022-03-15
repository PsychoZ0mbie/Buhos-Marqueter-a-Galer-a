let tableSubcategorias;
let rowTable="";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded',function(){
    tableSubcategorias = $('#tableSubcategorias').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Galeria/getSubcategorias",
            "dataSrc":""
        },
        "columns":[
            {"data":"idsubtopic"},
            {"data":"title"},
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
    let formCategoria = document.querySelector("#formSubcategoria");
    formCategoria.onsubmit = function(e) {
        e.preventDefault();

        let strNombre = document.querySelector('#txtNombre').value;

        if(strNombre == ''){
        
            swal("Atención", "Todos los campos son obligatorios" , "error");
            return false;
        }
        divLoading.style.display = "flex";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Galeria/setSubcategoria'; 
        let formData = new FormData(formCategoria);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
           if(request.readyState == 4 && request.status == 200){
                
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    if(rowTable == ""){
                        tableSubcategorias.api().ajax.reload();
                    }else{
                        rowTable.cells[1].textContent = strNombre;
                        rowTable = "";
                    }
                    $('#modalformSubcategorias').modal("hide");
                    formCategoria.reset();
                    swal("Categorias", objData.msg ,"success");
                }else{
                    swal("Error", objData.msg , "error");
                }              
            }
            divLoading.style.display = "none";
            return false; 
        }

        
    }
    

},false);


function fntEditInfo(element, idcategoria){

    rowTable = element.parentNode.parentNode.parentNode;

    document.querySelector('#titleModal').innerHTML ="Actualizar";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl  = base_url+'/Galeria/getSubcategoria/'+idcategoria;
    request.open("GET",ajaxUrl ,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {
                url=objData.data.image;
                document.querySelector("#idSubcategoria").value = objData.data.idsubtopic;
                document.querySelector("#txtNombre").value = objData.data.title;

            }else{
                swal("Error", objData.msg , "error");
            }
        }
        $('#modalFormSubcategoria').modal('show');
    }
}

function fntDelInfo(idsubcategoria){

    swal({
        title: "Eliminar Categoría",
        text: "¿Está seguro de eliminar la Categoría?",
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
            let ajaxUrl = base_url+'/Galeria/delSubcategoria/'+idsubcategoria;
            let strData = "idSubcategoria="+idsubcategoria;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminado", objData.msg , "success");
                        tableSubcategorias.api().ajax.reload();
                    }else{
                        swal("Atención", objData.msg , "error");
                    }
                }
            }
        }

    });
}

function openModal(){
    rowTable ="";
    document.querySelector('#idSubcategoria').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo";
    document.querySelector("#formSubcategoria").reset();
	$('#modalFormSubcategoria').modal('show');
}