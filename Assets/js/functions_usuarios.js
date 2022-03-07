let tableUsuarios;
let rowTable = "";
var divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded',function(){

    tableUsuarios = $('#tableUsuarios').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Usuarios/getUsuarios",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_person"},
            {"data":"first_name"},
            {"data":"phone"},
            {"data":"email"},
            {"data":"rolname"},
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
                    "columns": [ 0, 1, 2, 3, 4,5,6] 
                }
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success",
                "exportOptions": { 
                    "columns": [ 0, 1, 2, 3, 4,5,6] 
                }
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": { 
                    "columns": [ 0, 1, 2, 3, 4,5,6] 
                }
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info",
                "exportOptions": { 
                    "columns": [ 0, 1, 2, 3, 4,5,6] 
                }
            }
        ],
        "responsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"asc"]]  
    });
    
    if(document.querySelector("#formUsuario")){
        let formUsuario = document.querySelector("#formUsuario");
        formUsuario.onsubmit = function(e) {
            e.preventDefault();
            let strNombre = document.querySelector('#txtNombre').value;
            let strApellido = document.querySelector('#txtApellido').value;
            let strEmail = document.querySelector('#txtEmail').value;
            let intTelefono = document.querySelector('#txtTelefono').value;
            let intTipousuario = document.querySelector('#listRolid').value;
            let strPassword = document.querySelector('#txtPassword').value;
            let intStatus = document.querySelector('#listStatus').value;

            if(strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '' || intTipousuario == '')
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }
            if(strPassword.length <8){
                swal("Atención", "La contraseña debe tener un mínimo de 8 carácteres." , "error");
                return false; 
            }

            if(intTelefono != ""){
                if(intTelefono.length < 10 || intTelefono.length > 10 ){
                    swal("Atención", "El número de teléfono es incorrecto." , "error");
                return false;
                }
            }


            /*let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    swal("Atención", "Por favor verifique los campos en rojo." , "error");
                    return false;
                } 
            }*/
            divLoading.style.display = "flex"; 
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Usuarios/setUsuario'; 
            let formData = new FormData(formUsuario);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableUsuarios.api().ajax.reload();
                        }else{
                            htmlStatus = intStatus ==1 ?
                            '<span class="badge badge-success">Activo</span>':
                            '<span class="badge badge-danger">Inactivo</span>';

                            rowTable.cells[1].textContent = strNombre;
                            rowTable.cells[2].textContent = strApellido;
                            rowTable.cells[3].textContent = intTelefono;
                            rowTable.cells[4].textContent = strEmail;
                            rowTable.cells[5].textContent = document.querySelector("#listRolid").selectedOptions[0].text;
                            rowTable.cells[6].innerHTML = htmlStatus;
                            rowTable = "";
                        }
                        $('#modalFormUsuario').modal("hide");
                        formUsuario.reset();
                        swal("Usuarios", objData.msg ,"success");
                        
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }

        }
    }
    ///////////////////////////////////////Actualizar perfil
    if(document.querySelector("#profile-img")){
        let foto = document.querySelector("#profile-img");
        foto.onchange = function(e) {
            let uploadFoto = document.querySelector("#profile-img").value;
            let fileimg = document.querySelector("#profile-img").files;
            let nav = window.URL || window.webkitURL;
            if(uploadFoto !=''){
                let type = fileimg[0].type;
                let name = fileimg[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
                    swal("Error","El archivo no es válido, inténtelo de nuevo","error");
                    foto.value="";
                    return false;
                }else{  
                    let objeto_url = nav.createObjectURL(this.files[0]);
                    document.querySelector('.profile-image img').setAttribute("src",objeto_url);
                }
            }
        }
    }
    if(document.querySelector("#formPerfil")){
        let formPerfil = document.querySelector("#formPerfil");
        formPerfil.onsubmit = function(e) {
            e.preventDefault();
            let strNombre = document.querySelector('#txtNombre').value;
            let intDepartamento = document.querySelector("#listDepartamento").value;
            let intCiudad = document.querySelector("#listCiudad").value;
            let strDireccion = document.querySelector('#txtDir').value;
            let intTipoId = document.querySelector("#listId").value;
            let strId = document.querySelector("#txtId").value;
            let intTelefono = document.querySelector('#txtTelefono').value;
            let strPassword = document.querySelector('#txtPassword').value;
            let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;
            let fileimg = document.querySelector("#profile-img").files;

            if(strDireccion == '' || strNombre == '' || intTelefono == '' || strId == '')
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }

            if(intTelefono != ""){
                if(intTelefono.length < 10 || intTelefono.length > 10 ){
                    swal("Atención", "El número de teléfono es incorrecto." , "error");
                return false;
                }
            }

            if(strPassword != "" || strPasswordConfirm !=""){
                if(strPassword != strPasswordConfirm){
                    swal("Atención","Las contraseñas no coinciden.", "info");
                    return false;
                }
                if(strPassword.length < 8){
                    swal("Atención", "La contraseña debe tener un mínimo de 8 carácteres.","info");
                    return false;
                }
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    swal("Atención", "Por favor verifique los campos en rojo." , "error");
                    return false;
                } 
            } 
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Usuarios/putPerfil'; 
            let formData = new FormData(formPerfil);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState != 4) return;
                if(request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal({
                            title: "",
                            text: objData.msg,
                            type: "success",
                            confirmButtonText: "Aceptar",
                            closeOnconfirm: false,
                        }, function(isConfirm){
                            if(isConfirm){
                                location.reload();
                            }
                        });
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                return false;
            }

        }
    }
}, false);

window.addEventListener('load',function(){

    if(document.querySelector("#listDepartamento")){
        let dep = document.querySelector("#listDepartamento");
        dep.onchange= function(){
            let id = document.querySelector("#listDepartamento").value;
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
            let ajaxUrl = base_url+"/Usuarios/getSelectCity/"+id;

            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    document.querySelector("#listCiudad").innerHTML = request.responseText;
                    $("#listCiudad").selectpicker("refresh");
                    $("#listCiudad").selectpicker({
                        noneSelectedText : 'Seleccione...'
                    })
                }
            }
        }
    }
    fntRolesUsuario();
    fntId();
    fntDepartamento();
    //fntViewUsuario();
    //fntEditUsuario();
    //fntDelUsuario();
},false);

function fntViewUsuario(idpersona){
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl  = base_url+'/Usuarios/getUsuario/'+idpersona;
            request.open("GET",ajaxUrl ,true);
            request.send();
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
        
                    if(objData.status)
                    {
                       let estadoUsuario = objData.data.status == 1 ? 
                        '<span class="badge badge-success">Activo</span>' : 
                        '<span class="badge badge-danger">Inactivo</span>';
        
                        document.querySelector("#celNombre").innerHTML = objData.data.first_name;
                        document.querySelector("#celApellido").innerHTML = objData.data.last_name;
                        document.querySelector("#celTelefono").innerHTML = objData.data.phone;
                        document.querySelector("#celEmail").innerHTML = objData.data.email;
                        document.querySelector("#celTipoUsuario").innerHTML = objData.data.rolname;
                        document.querySelector("#celEstado").innerHTML = estadoUsuario;
                        document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro; 
                        $('#modalViewUser').modal('show');
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
            }
}

function fntEditUsuario(element,idpersona){
    rowTable = element.parentNode.parentNode.parentNode;
    //rowTable.cells[1].textContent = "Julio";
    document.querySelector('#titleModal').innerHTML ="Actualizar Usuario";
    document.querySelector('.modal-header').classList.replace("header-primary", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl  = base_url+'/Usuarios/getUsuario/'+idpersona;
    request.open("GET",ajaxUrl ,true);
    request.send();
    request.onreadystatechange = function(){
        
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {
                document.querySelector("#idUsuario").value = objData.data.id_person;
                document.querySelector("#txtNombre").value = objData.data.first_name;
                document.querySelector("#txtApellido").value = objData.data.last_name;
                document.querySelector("#txtTelefono").value = objData.data.phone;
                document.querySelector("#txtEmail").value = objData.data.email;
                document.querySelector("#listRolid").value =objData.data.idrol;
                $('#listRolid').selectpicker('render');

                if(objData.data.status == 1){
                    document.querySelector("#listStatus").value = 1;
                }else{
                    document.querySelector("#listStatus").value = 2;
                }
                $('#listStatus').selectpicker('render');
            }
        }
    
        $('#modalFormUsuario').modal('show');    
    }
}



function fntRolesUsuario(){
    if(document.querySelector('#listRolid')){

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl  = base_url+'/Roles/getSelectRoles';
        request.open("GET",ajaxUrl ,true);
        request.send(); 
    
        request.onreadystatechange = function(){
            if(request.readyState ==4 && request.status ==200){
                document.querySelector('#listRolid').innerHTML = request.responseText;
                $('#listRolid').selectpicker('render');
            }
        }
    }
}
function fntId(){
    if(document.querySelector('#listId')){

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl  = base_url+'/Usuarios/getSelectId';
        request.open("GET",ajaxUrl ,true);
        request.send(); 
    
        request.onreadystatechange = function(){
            if(request.readyState ==4 && request.status ==200){
                document.querySelector('#listId').innerHTML = request.responseText;
                $('#listId').selectpicker('render');
            }
        }
    }
}
function fntDepartamento(){
    if(document.querySelector('#listDepartamento')){

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl  = base_url+'/Usuarios/getSelectDepartamentos';
        request.open("GET",ajaxUrl ,true);
        request.send(); 
        request.onreadystatechange = function(){
            if(request.readyState ==4 && request.status ==200){
                let objData = JSON.parse(request.responseText);
                document.querySelector('#listDepartamento').innerHTML = objData.department;
                document.querySelector('#listCiudad').innerHTML = objData.city;
                $('#listDepartamento').selectpicker('render');
                $('#listCiudad').selectpicker('render');
            }
        }
    }
}

function fntDelUsuario(idpersona){

            swal({
                title: "Eliminar Usuario",
                text: "¿Está seguro de eliminar el usuario?",
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
                    let ajaxUrl = base_url+'/Usuarios/delUsuario/'+idpersona;
                    let strData = "idUsuario="+idpersona;
                    request.open("POST",ajaxUrl,true);
                    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    request.send(strData);
                    request.onreadystatechange = function(){
                        if(request.readyState == 4 && request.status == 200){
                            let objData = JSON.parse(request.responseText);
                            if(objData.status)
                            {
                                swal("Eliminado", objData.msg , "success");
                                tableUsuarios.api().ajax.reload(function(){
                                    fntRolesUsuario();
                                });
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
    document.querySelector('#idUsuario').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    document.querySelector("#formUsuario").reset();
	$('#modalFormUsuario').modal('show');
}
