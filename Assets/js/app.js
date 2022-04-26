'use strict';
import Marqueteria from "./modules/marqueteriaClass.js";
import Galeria from "./modules/galeriaClass.js";
import Usuario from "./modules/usuarioClass.js";


let loading = document.querySelector("#divLoading");

/*************************User Page*******************************/

if(document.querySelector("#usuarios")){
    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".item");
    let value = search.value.toLowerCase();
        for(let i = 0; i < elements.length; i++) {
            let element = elements[i];
            let strName = element.getAttribute("data-name").toLowerCase()+" "+element.getAttribute("data-lastname").toLowerCase();
            let strEmail = element.getAttribute("data-email").toLowerCase();
            let strPhone = element.getAttribute("data-phone").toLowerCase();
            if(!strName.includes(value) && !strEmail.includes(value) && !strPhone.includes(value)){
                element.classList.add("d-none");
            }else{
                element.classList.remove("d-none");
            }
        }
    })

    let orderBy = document.querySelector("#orderBy");
    orderBy.addEventListener("change",function(){
        item.orderItem(orderBy.value);
    });

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
        let typeValue = document.querySelector("#typeList").value;
        let strPassword = document.querySelector("#txtPassword").value;
        let idUser = document.querySelector("#idUser").value;

        if(idUser == 0){

            if(strFirstName == "" || strLastName == "" || strEmail == "" || strPhone == "" || typeValue == "" || strPassword == ""){
                Swal.fire("Error","Todos los campos son obligatorios","error");
                return false;
            }
            if(strPassword.length < 8){
                Swal.fire("Error","La contraseña debe tener mínimo 8 carácteres","error");
                return false;
            }
        }else{
            if(strFirstName == "" || strLastName == "" || strEmail == "" || strPhone == "" || typeValue == ""){
                Swal.fire("Error","Todos los campos son obligatorios","error");
                return false;
            }
            if(strPassword !=""){
                if(strPassword.length < 8){
                    Swal.fire("Error","La contraseña debe tener mínimo 8 carácteres","error");
                    return false;
                } 
            }
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
        if(strPhone.length < 10){
            Swal.fire("Error","El número de teléfono debe tener 10 dígitos","error");
            return false;
        }

        //Request
        let formData = new FormData(form);
        let url = base_url+"/Usuarios/setUsuario";
        loading.style.display="flex";
        request(url,formData,1).then(function(objData){
            loading.style.display="none";
            if(objData.status){
                Swal.fire("Usuario",objData.msg,"success");
                setTimeout(function(){
                    location.reload();
                },2000);
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

/*************************Gallery Page*******************************/

if(document.querySelector("#galeria")){

    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".item");
    let value = search.value.toLowerCase();
        for(let i = 0; i < elements.length; i++) {
            let element = elements[i];
            let strTitle = element.getAttribute("data-title").toLowerCase();
            let strTopic = element.getAttribute("data-topic").toLowerCase();
            let strTechnique = element.getAttribute("data-technique").toLowerCase();
            let strAuthor = element.getAttribute("data-author").toLocaleLowerCase();
            if(!strTitle.includes(value) && !strTopic.includes(value) && !strTechnique.includes(value) && !strAuthor.includes(value)){
                element.classList.add("d-none");
            }else{
                element.classList.remove("d-none");
            }
        }
    })

    

    let item = new Galeria();
    item.interface();
    let element = document.querySelector("#listItem");
    let img = [document.querySelector("#txtImg"),document.querySelector("#txtImg2")];
    let imgLocation = ["#img","#img2"];
    for (let i = 0; i < 2; i++) {
        let image = img[i];
        let imageLocation = imgLocation[i];
        image.addEventListener("change",function(){
            uploadImg(image,imageLocation);
        })
    }

    let orderBy = document.querySelector("#orderBy");
    orderBy.addEventListener("change",function(){
        item.orderItem(element,orderBy.value);
    });

    window.addEventListener("DOMContentLoaded",function() {
        item.showItems(element);
    })
    let form = document.querySelector("#formItem");
    form.addEventListener("submit",function(e){
        e.preventDefault();

        let strName = document.querySelector("#txtName").value;
        let intWidth = document.querySelector("#intWidth").value;
        let intHeight = document.querySelector("#intHeight").value;
        let topicList = document.querySelector("#topicList");
        let subtopicList = document.querySelector("#subtopicList");
        let frameList = document.querySelector("#frameList").value;
        let statusList = document.querySelector("#statusList").value;
        let intPrice = document.querySelector("#intPrice").value;
        let idProduct = document.querySelector("#idProduct").value;

        if(strName == "" || intWidth == "" || intHeight == "" || topicList.value == "" || subtopicList.value == ""
            || intPrice == "" || frameList == "" || statusList==""){
            Swal.fire("Error","Todos los campos son obligatorios","error");
            return false;
        }


        //Request
        let formData = new FormData(form);
        let url = base_url+"/Galeria/setProducto";
        loading.style.display="flex";
        request(url,formData,1).then(function(objData){
            loading.style.display="none";
            if(objData.status){
                Swal.fire("Galeria",objData.msg,"success");
                setTimeout(function(){
                    location.reload();
                },2000);
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

/*************************Framing Page*******************************/

if(document.querySelector("#marqueteria")){

    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".item");
    let value = search.value.toLowerCase();
        for(let i = 0; i < elements.length; i++) {
            let element = elements[i];
            let strTitle = element.getAttribute("data-title").toLowerCase();
            let strTopic = element.getAttribute("data-topic").toLowerCase();
            if(!strTitle.includes(value) && !strTopic.includes(value)){
                element.classList.add("d-none");
            }else{
                element.classList.remove("d-none");
            }
        }
    })

    

    let item = new Marqueteria();
    item.interface();
    let element = document.querySelector("#listItem");
    let img = [document.querySelector("#txtImg"),document.querySelector("#txtImg2")];
    let imgLocation = ["#img","#img2"];
    for (let i = 0; i < 2; i++) {
        let image = img[i];
        let imageLocation = imgLocation[i];
        image.addEventListener("change",function(){
            uploadImg(image,imageLocation);
        })
    }

    let orderBy = document.querySelector("#orderBy");
    orderBy.addEventListener("change",function(){
        item.orderItem(element,orderBy.value);
    });

    window.addEventListener("DOMContentLoaded",function() {
        item.showItems(element);
    })
    let form = document.querySelector("#formItem");
    form.addEventListener("submit",function(e){
        e.preventDefault();

        let strName = document.querySelector("#txtName").value;
        let topicList = document.querySelector("#topicList").value;
        let statusList = document.querySelector("#statusList").value;
        let intWaste = document.querySelector("#intWaste").value;
        let intPrice = document.querySelector("#intPrice").value;
        let idProduct = document.querySelector("#idProduct").value;

        if(strName == "" ||  topicList == "" || intPrice == "" || statusList=="" || intWaste == ""){
            Swal.fire("Error","Todos los campos son obligatorios","error");
            return false;
        }


        //Request
        let formData = new FormData(form);
        let url = base_url+"/Marqueteria/setProducto";
        loading.style.display="flex";
        request(url,formData,1).then(function(objData){
            loading.style.display="none";
            if(objData.status){
                Swal.fire("Marqueteria",objData.msg,"success");
                setTimeout(function(){
                    location.reload();
                },2000);
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