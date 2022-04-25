'use strict';
import Interface from "./interfaceClass.js";
let loading = document.querySelector("#divLoading");
export default class Marqueteria extends Interface{
    constructor(){
        super();
    }
    interface(){
        let form = `
        <form id="formItem" name="formItem" class="mb-4">
            <input type="hidden" id="idProduct" name="idProduct" value="">
            <div class="d-flex justify-content-center">
                <div class="mb-3 uploadImg">
                    <img src="${base_url}/Assets/images/uploads/subirfoto.png" id="img">
                    <label for="txtImg"><a class="btn btn-info text-white">Subir foto</a></label>
                    <input class="d-none" type="file" id="txtImg" name="txtImg"> 
                </div>
                <div class="mb-3 uploadImg">
                    <img src="${base_url}/Assets/images/uploads/subirfoto.png" id="img2">
                    <label for="txtImg2"><a class="btn btn-info text-white">Subir foto</a></label>
                    <input class="d-none" type="file" id="txtImg2" name="txtImg2"> 
                </div>
            </div>
            <div class="mb-3">
                <label for="txtName" class="form-label">Referencia</label>
                <input type="text" class="form-control" id="txtName" name="txtName">
            </div>
            <div class="mb-3">
                <label for="topicList" class="form-label">Tipo de moldura</label>
                <select class="form-control form-control" aria-label="Default select example" id="topicList" name="topicList">
                    <option value="1">Moldura en madera</option>
                    <option value="2">Moldura importada</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="intWaste" class="form-label">Desperdicio</label>
                        <input type="number" class="form-control" id="intWaste" name="intWaste">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="intPrice" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="intPrice" name="intPrice">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="statusList" class="form-label">Disponibilidad</label>
                <select class="form-control" aria-label="Default select example" id="statusList" name="statusList">
                    <option value="1">Disponible</option>
                    <option value="2">No disponible</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" id="btnAdd"><i class="fas fa-plus-circle"></i> Agregar</button>
            <button type="button" class="btn btn-danger" onclick="location.reload()"><i class="fa fa-times-circle"></i> Cancelar</button>
        </form>
        `;
        document.querySelector("#interface").innerHTML=form;
    }

    orderItem(element,value){
        let url = base_url+"/Marqueteria/getProductos"
        let formData = new FormData();
        let fragment = document.createDocumentFragment();
        formData.append("orderBy",value);
        request(url,formData,1).then(function(objData){
            let div = document.querySelector("div.scroll_list");
            let html=""
            
            let topicList = document.querySelectorAll("#topicList option");
            let statusList = document.querySelectorAll("#statusList option");
            let topic ="";
            let status="";

            for (let i = 0; i < objData.length; i++) {
                let price = formatNum(parseInt(objData[i]['price']),".");
                
                for (let j = 0; j < topicList.length; j++) {
                    if(topicList[j].value == objData[i]['subtopicid']){
                        topic = topicList[j].textContent;
                        break;
                    }
                    
                }
                for (let l = 0; l < statusList.length; l++) {
                    if(statusList[l].value == objData[i]['status']){
                        if(statusList[l].value == 1){
                            status = `<span class="badge badge-success">${statusList[l].textContent}</span>`
                        }else{
                            status = `<span class="badge badge-danger">${statusList[l].textContent}</span>`
                        }

                        break;
                    }
                }
                html += `
                
                <div class="row mt-2 bg-body rounded item" data-title="${objData[i]['title']}" data-topic="${topic}">
                    <hr>
                    <div class="col-md-2">
                        <img src="${objData[i]['url']}" alt="">
                    </div>
                    <div class="col-md-7">
                        <p><strong>Referencia: </strong>${objData[i]['title']}</p>
                        <ul>
                            <li class="text-secondary"><strong>Tipo de moldura: </strong>${topic}</li>
                            <li class="text-secondary"><strong>Precio: </strong>$${price} x cm</li>
                            <li class="text-secondary"><strong>Desperdicio: </strong>${objData[i]['waste']} cm</li>
                            <li class="text-secondary"><strong>Disponibilidad: </strong>${status}</li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-info w-100 text-white" title="Ver" name="btnView" data-id="${objData[i]['idproduct']}">Ver</button>
                        <a href="#formItem" class="btn btn-success w-100 text-white" title="Editar" name="btnEdit"  data-id="${objData[i]['idproduct']}">Editar</a>
                        <button class="btn btn-danger w-100 text-white" title="Eliminar" name="btnDelete"  data-id="${objData[i]['idproduct']}">Eliminar</button>
                    </div>
                    <hr>
                </div>
                `;
            }
            div.innerHTML = html;
            fragment.appendChild(div);
            element.appendChild(fragment);
        });
    }
    showItems(element){
        let url = base_url+"/Marqueteria/getProductos";
        request(url,"",2).then(function(objData){

            let div = document.createElement("div");
            let fragment = document.createDocumentFragment();
            let html=""
            let topicList = document.querySelectorAll("#topicList option");
            let statusList = document.querySelectorAll("#statusList option");
            let topic ="";
            let status="";

            for (let i = 0; i < objData.length; i++) {
                let price = formatNum(parseInt(objData[i]['price']),".");
                
                
                for (let j = 0; j < topicList.length; j++) {
                    if(topicList[j].value == objData[i]['subtopicid']){
                        topic = topicList[j].textContent;
                        break;
                    }
                    
                }
                for (let l = 0; l < statusList.length; l++) {
                    if(statusList[l].value == objData[i]['status']){

                        if(statusList[l].value == 1){
                            status = `<span class="badge badge-success">${statusList[l].textContent}</span>`
                        }else{
                            status = `<span class="badge badge-danger">${statusList[l].textContent}</span>`
                        }

                        break;
                        
                    }
                }
                html += `
                
                <div class="row mt-2 bg-body rounded item" data-title="${objData[i]['title']}" data-topic="${topic}">
                    <hr>
                    <div class="col-md-2">
                        <img src="${objData[i]['url']}" alt="">
                    </div>
                    <div class="col-md-7">
                        <p><strong>Referencia: </strong>${objData[i]['title']}</p>
                        <ul>
                            <li class="text-secondary"><strong>Tipo de moldura: </strong>${topic}</li>
                            <li class="text-secondary"><strong>Precio: </strong>$${price} x cm</li>
                            <li class="text-secondary"><strong>Desperdicio: </strong>${objData[i]['waste']} cm</li>
                            <li class="text-secondary"><strong>Disponibilidad: </strong>${status}</li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-info w-100 text-white" title="Ver" name="btnView" data-id="${objData[i]['idproduct']}">Ver</button>
                        <a href="#formItem" class="btn btn-success w-100 text-white" title="Editar" name="btnEdit"  data-id="${objData[i]['idproduct']}">Editar</a>
                        <button class="btn btn-danger w-100 text-white" title="Eliminar" name="btnDelete"  data-id="${objData[i]['idproduct']}">Eliminar</button>
                    </div>
                    <hr>
                </div>
                `;
            }
            div.innerHTML = html;
            div.classList.add("scroll_list");
            fragment.appendChild(div);
            element.appendChild(fragment);
        })
    }
    viewItem(id){
        let url = base_url+"/Marqueteria/getProducto";
        let formData = new FormData();
        formData.append("idProduct",id);

        request(url,formData,1).then(function(objData){
            if(objData.status){
                let topicList = document.querySelectorAll("#topicList option");
                let statusList = document.querySelectorAll("#statusList option");
                let topic ="";
                let status="";
                let images="";
                let price = formatNum(parseInt(objData.data.price),".");

                for (let j = 0; j < topicList.length; j++) {
                    if(topicList[j].value == objData.data.subtopicid){
                        topic = topicList[j].textContent;
                        break;
                    }
                    
                }
                for (let l = 0; l < statusList.length; l++) {
                    if(statusList[l].value == objData.data.status){
                        if(objData.data.status == 1){
                            status = `<span class="badge badge-success">${statusList[l].textContent}</span>`
                        }else{
                            status = `<span class="badge badge-danger">${statusList[l].textContent}</span>`
                        }
                        break;
                    }
                }

                for (let n = 0; n < objData.data.img.length; n++) {
                    images +=  `
                    <div class="modal_img m-1">
                        <img src="${objData.data.img[n]}" alt="">
                    </div>
                    `;
                }

                let modalItem = document.querySelector("#modalItem");
                //let fragment = document.createDocumentFragment();
                //let div = document.createElement("div");
                let modal=`
                <div class="modal fade" tabindex="-1" id="modalElement">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><strong>Datos de producto</strong></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table w-100">
                                            <tbody>
                                                <tr scope="row">
                                                    <td>Imágen: </td>
                                                    <td>
                                                        <div class="d-flex flex-wrap justify-content-center">
                                                        ${images}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr scope="row">
                                                    <td>Referencia: </td>
                                                    <td> ${objData.data.title}</td>
                                                </tr>
                                                <tr scope="row">
                                                    <td>Tipo de moldura: </td>
                                                    <td> ${topic}</td>
                                                </tr>
                                                <tr scope="row"">
                                                    <td>Disponibilidad: </td>
                                                    <td>${status}</td>
                                                </tr>
                                                <tr scope="row">
                                                    <td>Desperdicio: </td>
                                                    <td>${objData.data.waste} cm</td>
                                                </tr>
                                                <tr scope="row">
                                                    <td>Precio: </td>
                                                    <td>$${price} x cm</td>
                                                </tr>
                                                <tr scope="row">
                                                    <td>Fecha de creación: </td>
                                                    <td>${objData.data.date}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                `;
    
                modalItem.innerHTML = modal;
                //fragment.appendChild(div);
                //modalItem.appendChild(fragment);
                let modalView = new bootstrap.Modal(document.querySelector("#modalElement"));
                modalView.show();
            }else{
                Swal.fire("Error",objData.msg,"error");
            }
        })
    }
    editItem(id){

        let url = base_url+"/Marqueteria/getProducto";
        let formData = new FormData();
        formData.append("idProduct",id);
        request(url,formData,1).then(function(objData){
            if(objData.status){

                let topicList = document.querySelectorAll("#topicList option");
                let statusList = document.querySelectorAll("#statusList option");

                for (let j = 0; j < topicList.length; j++) {
                    if(topicList[j].value == objData.data.subtopicid){
                        topicList[j].setAttribute("selected","selected");
                        break;
                    }
                    
                }
                for (let l = 0; l < statusList.length; l++) {
                    if(statusList[l].value == objData.data.status){
                        statusList[l].setAttribute("selected","selected")
                        break;
                    }
                }

                document.querySelector("#txtName").value = objData.data.title;
                document.querySelector("#intPrice").value = objData.data.price;
                document.querySelector("#intWaste").value = objData.data.waste;
                document.querySelector("#idProduct").value = objData.data.idproduct;

                let images = document.querySelectorAll(".uploadImg img");
                for (let i = 0; i < images.length; i++) {
                    images[i].setAttribute("src",objData.data.img[i]);
                }

            }else{
                Swal.fire("Error",objData.msg,"error");
            }
        });
        document.querySelector("#btnAdd").textContent = "Actualizar";

    }
    deleteItem(element,id){
        if(element.name == "btnDelete"){
            Swal.fire({
                title:"¿Está segur@ de eliminar?",
                text:"Se eliminará para siempre",
                icon: 'warning',
                showCancelButton:true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText:"Sí, eliminar",
                cancelButtonText:"No, cancelar"
            }).then(function(result){
                if(result.isConfirmed){
                    let url = base_url+"/Marqueteria/delProducto"
                    let formData = new FormData();
                    formData.append("idProduct",id);
                    loading.style.display = "flex";
                    request(url,formData,1).then(function(objData){
                        loading.style.display = "none";
                        Swal.fire("Marqueteria",objData.msg,"success");
                        element.parentElement.parentElement.remove();
                    });
                }
            });
        }
    }
}
