'use strict';
import Marqueteria from "./modules/marqueteriaClass.js";
import Galeria from "./modules/galeriaClass.js";
import Usuario from "./modules/usuarioClass.js";



/*************************User Page*******************************/

{
    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".item");
    let value = search.value.toLowerCase();
    for(let i = 0; i < elements.length; i++) {
        let element = elements[i];
        let strName = element.getAttribute("data-name").toLowerCase();
        let strLastName = element.getAttribute("data-lastname").toLowerCase();
        let strEmail = element.getAttribute("data-email").toLowerCase();
        let strPhone = element.getAttribute("data-phone").toLowerCase();
        if(!strName.includes(value) && !strLastName.includes(value) && !strEmail.includes(value) && !strPhone.includes(value)){
            element.classList.add("d-none");
        }else{
            element.classList.remove("d-none");
        }
    }
    })

    let item = new Usuario();
    item.interface();
    let element = document.querySelector("#listItem");
    let img = document.querySelector("#txtImg");
    let imgLocation = ".uploadImg img";
    img.addEventListener("change",function(){
        uploadImg(img,imgLocation);
    });
    window.addEventListener("DOMContentLoaded",function() {
        item.showItems(element);
    })
    let form = document.querySelector("#formItem");
    form.addEventListener("submit",function(e){
        e.preventDefault();

        let strFirstName = document.querySelector("#txtFirstName").value;
        let strLastName = document.querySelector("#txtLastName").value;
        let strEmail = document.querySelector("#txtEmail").value;
        let strPhone = document.querySelector("#txtPhone").value;
        let typeList = document.querySelector("#typeList");
        let typeName = typeList.selectedOptions[0].text;
        let typeValue = typeList.value;
        let strPassword = document.querySelector("#txtPassword").value;
        let idUser = document.querySelector("#idUser").value;

        if(strFirstName == "" || strLastName == "" || strEmail == "" || strPhone == "" || typeValue == "" || strPassword == ""){
            Swal.fire("Error","Todos los campos son obligatorios","error");
            return false;
        }
        if(!fntEmailValidate(strEmail)){
            let html = `
            <br>
            <br>
            <p>micorreo@hotmail.com</p>
            <p>micorreo@outlook.com</p>
            <p>micorreo@yahoo.com</p>
            <p>micorreo@live.com</p>
            <p>micorreo@gmail.com</p>
            `;
            Swal.fire("Error","El correo ingresado es inválido, solo permite los siguientes correos: "+html,"error");
            return false;
        }
        if(strPassword.length < 8){
            Swal.fire("Error","La contraseña debe tener mínimo 8 carácteres","error");
            return false;
        }
        if(strPhone.length < 10){
            Swal.fire("Error","El número de teléfono debe tener 10 dígitos","error");
            return false;
        }

        //Request
        let formData = new FormData(form);
        formData.append("rolName",typeName);
        let url = base_url+"/Usuarios/setUsuario";
        request(url,formData,1).then(function(objData){
            if(objData.status){
                location.reload();
            }else{
                Swal.fire("Error",objData.msg,"error");
            }
        });
    });
    //buttons
    if(document.querySelector("#listItem")){
        let listProduct = document.querySelector("#listItem");
        listProduct.addEventListener("click",function(e) {
                let element = e.target;
                let id = element.getAttribute("data-id");
                if(element.name == "btnDelete"){
                    item.deleteItem(element,id);
                }else if(element.name == "btnView"){
                    item.viewItem(id);
                }else if(element.name == "btnEdit"){
                    item.editItem(id);
                }
        });
    }
}


/******************************************************************/

/*************************Product Page*******************************/

{

    if(document.querySelector("#selectTopic")){
        let select = document.querySelector("#selectTopic");
        select.addEventListener('change',function(){
            let item={};
            if(select.value == 1){
                item = new Marqueteria();
                item.interface();
                if(document.querySelector("#formItem")){
                    let img = document.querySelector("#txtImg");
                        img.addEventListener("change",function(){
                            let imgUpload = img.value;
                            let fileUpload = img.files;
                            let type = fileUpload[0].type;
                            if(type != "image/png" && type != "image/jpg" && type != "image/jpeg"){
                                imgUpload ="";
                                Swal.fire("Error","El archivo es incorrecto.","error");
                            }else{
                                let objectUrl = window.URL || window.webkitURL;
                                let route = objectUrl.createObjectURL(fileUpload[0]);
                                document.querySelector(".uploadImg img").setAttribute("src",route);
                            }
                    });
                    let form = document.querySelector("#formItem");
                    form.addEventListener('submit',function(e){
                        e.preventDefault();
                        let element = document.querySelector("#listItem");
                        let strName = document.querySelector("#txtName").value;
                        let intPrice = document.querySelector("#intPrice").value;
                        let intStock = document.querySelector("#intStock").value;
                        let type = document.querySelector("#typeList");
                        let strImg = document.querySelector(".uploadImg img").src;
                        let strFile = document.querySelector("#txtImg").value;
    
                        if(strName =="" || intPrice == "" || intStock=="" || strFile=="" || type.value == 0){
                            Swal.fire("Error","Todos los campos son obligatorios","error");
                            return false;
                        }
    
                        document.querySelector("#search").classList.remove("d-none");
    
                        let strType = type.selectedOptions[0].text;
                        item.addItem(element,strImg,strName,intPrice,intStock,strType);
                        Swal.fire("Agregado","Producto agregado correctamente","success");
                        form.reset();
                        document.querySelector(".uploadImg img").setAttribute("src","Assets/images/uploads/subirfoto.png");
                    });
                }
            }else{
                item = new Galeria();
                item.interface();
                if(document.querySelector("#formItem")){
                    let img = document.querySelector("#txtImg");
                        img.addEventListener("change",function(){
                            let imgUpload = img.value;
                            let fileUpload = img.files;
                            let type = fileUpload[0].type;
                            if(type != "image/png" && type != "image/jpg" && type != "image/jpeg"){
                                imgUpload ="";
                                Swal.fire("Error","El archivo es incorrecto.","error");
                            }else{
                                let objectUrl = window.URL || window.webkitURL;
                                let route = objectUrl.createObjectURL(fileUpload[0]);
                                document.querySelector(".uploadImg img").setAttribute("src",route);
                            }
                    });
                    let form = document.querySelector("#formItem");
                        form.addEventListener('submit',function(e){
                            e.preventDefault();
                            let element = document.querySelector("#listItem");
                            let strName = document.querySelector("#txtName").value;
                            let intPrice = document.querySelector("#intPrice").value;
                            let intStock = document.querySelector("#intStock").value;
                            let type = document.querySelector("#typeList");
                            let boolFrame = document.querySelector("#boolFrame").checked;
                            let strImg = document.querySelector(".uploadImg img").src;
                            let strFile = document.querySelector("#txtImg").value;
                            let intWidth = document.querySelector("#intWidth").value;
                            let intHeight = document.querySelector("#intHeight").value;
    
                            if(strName =="" || intPrice == "" || intStock=="" || strFile=="" || type.value == 0
                            || intWidth =="" || intHeight == ""){
                                Swal.fire("Error","Todos los campos son obligatorios","error");
                                return false;
                            }
                            let strType = type.selectedOptions[0].text;
                            item.addItem(element,strImg,strName,intPrice,intStock,strType,intWidth,intHeight);
    
                            document.querySelector("#search").classList.remove("d-none");
                            Swal.fire("Agregado","Producto agregado correctamente","success");
    
                            form.reset();
                            document.querySelector(".uploadImg img").setAttribute("src","Assets/images/uploads/subirfoto.png");
                        });
                }
            }
        });
    }
    
    /*if(document.querySelector("#listItem")){
        let listProduct = document.querySelector("#listItem");
        let intTopic = document.querySelector("#selectTopic");
        listProduct.addEventListener("click",function(e) {
            if(intTopic.value == 1){
    
                let item = new Marqueteria();
                let element = e.target;
    
                if(element.name == "btnDelete"){
                    item.deleteItem(element);
                }else if(element.name == "btnView"){
                    item.viewItem(element);
                }else if(element.name == "btnEdit"){
                    item.editItem(element);
                }
            }else{
                let item = new Galeria();
                let element = e.target;
    
                if(element.name == "btnDelete"){
                    item.deleteItem(element);
                }else if(element.name == "btnView"){
                    item.viewItem(element);
                }else if(element.name == "btnEdit"){
                    item.editItem(element);
                }
            }
                
        });
    }*/
}
/******************************************************************/
