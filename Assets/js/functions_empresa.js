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
if(document.querySelector("#formEmpresa")){
    let formPerfil = document.querySelector("#formEmpresa");
    formPerfil.onsubmit = function(e) {
        e.preventDefault();
        let strNombre = document.querySelector('#txtNombre').value;
        let strEmail = document.querySelector("#txtEmail").value;
        let intTelefono = document.querySelector('#txtTelefono').value;
        let intCategoria = document.querySelector("#listCategoria").value;
        let strPalabras = document.querySelector("#txtPalabras").value;
        let strDescripcion = document.querySelector("#txtDescripcion").value;
        let fileimg = document.querySelector("#profile-img").files;

        if(strEmail == '' || strNombre == '' || intTelefono == '' || intCategoria =="")
        {
            swal("Atención", "Ingresa los campos obligatorios" , "error");
            return false;
        }

        if(intTelefono != ""){
            if(intTelefono.length < 10 || intTelefono.length > 10 ){
                swal("Atención", "El número de teléfono es incorrecto." , "error");
            return false;
            }
        }

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Empresa/setBusiness'; 
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
window.addEventListener('load',function(){
    fntCategorias();
},false);

function fntCategorias(){
    if(document.querySelector("#listCategoria")){
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
        let ajaxUrl = base_url+"/empresa/getCategorias";
        
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.status == 200 && request.readyState == 4){
                document.querySelector("#listCategoria").innerHTML = request.responseText;
                $("#listCategoria").selectpicker("render");
            }
        }
    }
}