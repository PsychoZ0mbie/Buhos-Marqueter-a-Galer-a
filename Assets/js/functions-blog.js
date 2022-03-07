
/*Menu*/
addEventListener('DOMContentLoaded',()=>{
    const btn = document.querySelector('.menu-btn');
    if(btn){

        btn.addEventListener('click',()=>{
            const menu = document.querySelector('.menu-items');
            menu.classList.toggle('show');
        })
    }
})
/*Pagination*/
$(document).ready(function(){
    $('.next').click(function(){
        $('.page').find('.page-number.active').next().
        addClass('active');
        $('.page').find('.page-number.active').prev().
        removeClass('active');
    })
    $('.previus').click(function(){
        $('.page').find('.page-number.active').prev().
        addClass('active');
        $('.page').find('.page-number.active').next().
        removeClass('active');
    })

})


if(document.querySelector("#frmContacto")){
    let frmContacto = document.querySelector("#frmContacto");
	frmContacto.addEventListener('submit',function(e) { 
		e.preventDefault();

        let name = document.querySelector("#txtNombreContacto").value;
		let email = document.querySelector("#txtEmailContacto").value;
        let descripcion = document.querySelector("#txtComentarios").value;
        if(name ==""){
            swal("", "El nombre es obligatorio" ,"error");
			return false;
        }
		if(!fntEmailValidate(email)){
			swal("", "El email no es válido." ,"error");
			return false;
		}
        if(descripcion ==""){
            swal("", "Por favor, escribe el mensaje" ,"error");
			return false;
        }else{
            divLoading.style.display = "flex";

            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Publicaciones/mensaje'; 
            let formData = new FormData(frmContacto);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState != 4) return;
                if(request.status == 200){
                    //console.log(request.responseText);
                    let objData = JSON.parse(request.responseText);
                    if(objData.status){
                        swal("", objData.msg , "success");
                        document.querySelector("#frmContacto").reset();
                    }else{
                        swal("", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            
            }
        }
    })
}
if(document.querySelector("#formRegister")){
    let formRegister = document.querySelector("#formRegister");
    formRegister.onsubmit = function(e){
        e.preventDefault();
        let strUsuario = document.querySelector('#txtUsuario').value;
        let strEmail = document.querySelector('#txtEmailRegister').value;
        let strPassword = document.querySelector('#txtPasswordRegister').value;
        let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;
        let boxCheck = document.querySelector('#check').checked;

        if(strUsuario == "" || strEmail =="" || strPassword =="" || strPasswordConfirm==""){
            swal("Por favor", "Todos los campos son obligatorios", "error");
            return false;
        }
        if(boxCheck == false){
            swal("Por favor", "Acepta las políticas de privacidad", "error");
            return false; 
        }
        if(strPassword.length <8){
            swal("Atención", "La contraseña debe tener un mínimo de 8 carácteres." , "error");
            return false; 
        }if(strPassword != strPasswordConfirm){
            swal("Atención", "Las contraseñas no coincinden, inténtelo de nuevo." , "error");
            return false;
        }else{
            divLoading.style.display = "flex";
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Publicaciones/registro'; 
            var formData = new FormData(formRegister);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState != 4)return;
                if(request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status){           
                        //swal("", objData.msg , "success");
                        document.querySelector("#formRegister").reset();
                        window.location.reload(false);
                    }else{
                        swal("Atención", objData.msg, "error");
                        document.querySelector('#txtPasswordRegister').value = "";
                        document.querySelector('#txtPasswordConfirm').value = "";
                    }
                }else{
                    swal("Atención","Error en el proceso","error");
                }
                divLoading.style.display = "none";
                return false;
            }

        }
    }
}
if(document.querySelector("#formComentario")){
    let formComentario = document.querySelector("#formComentario");
    formComentario.onsubmit = function(e){
        e.preventDefault();
        let strComentario = document.querySelector('#txtComentario').value;
        let idPost = document.querySelector('#idPost').value;
        let idcomment = document.querySelector('#idComentario').value;

        if(strComentario == ""){
            swal("Por favor", "Escribe tu comentario", "error");
            return false;
        }else{
            divLoading.style.display = "flex";
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Publicaciones/comentario'; 
            var formData = new FormData(formComentario);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState != 4)return;
                if(request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status){          
                       window.location.reload(false);
                    }else{
                        swal("Atención", objData.msg, "error");
                    }
                }else{
                    swal("Atención","Error en el proceso","error");
                }
                divLoading.style.display = "none";
                return false;
            }

        }
    }
}
function fntEditInfo(idcomment){
    document.querySelector('#idComentario').setAttribute("value",idcomment)
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl  = base_url+'/Publicaciones/getComentario/'+idcomment;
    request.open("GET",ajaxUrl ,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                document.querySelector("#txtComentario").value = objData.data.comment;
            }
        }
    }
}
function fntDeleteInfo(idcomment){

    swal({
        title: "Eliminar Comentario",
        text: "¿Está seguro de eliminar el comentario?",
        icon: "warning",
        buttons: {
            cancel:"Cancelar",
            text: "Sí, eliminar."
        },
        dangerMode: true,
    }) 
    .then((willDelete)=> {
        
        if (willDelete) {
        
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Publicaciones/delComentario/'+idcomment;
            let strData = "idComentario="+idcomment;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status){
                        window.location.reload(false);
                    }else{
                        swal("Atención", objData.msg , "error");
                    }
                }
            }
        }
    });
}

if(document.querySelector(".btn-comment")){
    $('.btn-comment').on('click touchstart', function(){
        $('#modalSesion').modal('show');
    });
}
/*function openSesion(){
    $('#modalSesion').modal('show');
}*/

function openModal(){
    $('#modalCompartir').modal('show');
}
