let tableContacto;
let rowTable="";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded',function(){
    tableContacto = $('#tableContacto').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Mensaje/getMensajes",
            "dataSrc":""
        },
        "columns":[
            {"data":"firstname"},
            {"data":"lastname"},
            {"data":"phone"},
            {"data":"email"},
            {"data":"ip"},
            {"data":"device"},
            {"data":"date"},
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
        "order":[[6,"desc"]]  
    });

},false);

function fntViewInfo(idpersona){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Mensaje/getMensaje/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status){
                document.querySelector("#nombre").innerHTML = objData.data.firstname;
                document.querySelector("#apellido").innerHTML = objData.data.lastname;
                document.querySelector("#telefono").innerHTML = objData.data.phone;
                document.querySelector("#email").innerHTML = objData.data.email;
                document.querySelector("#ip").innerHTML = objData.data.ip;
                document.querySelector("#dispositivo").innerHTML = objData.data.device;
                document.querySelector("#navegador").innerHTML = objData.data.useragent;
                document.querySelector("#fecha").innerHTML = objData.data.date; 
                document.querySelector("#mensaje").innerHTML = objData.data.message; 
                $('#modalViewContacto').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}