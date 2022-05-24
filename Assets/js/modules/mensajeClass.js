'use strict';
import Interface from "./interfaceClass.js";
let loading = document.querySelector("#divLoading");
export default class Mensaje extends Interface{
    constructor(){
        super();
    }
    interface(){ 
    }
    addItem(){
    }
    orderItem(element,value){
        let url = base_url+"/Mensaje/getMensajes"
        let formData = new FormData();
        formData.append("orderBy",value);
        request(url,formData,"post").then(function(objData){
            let div = document.querySelector("div.scroll_list");
            let fragment = document.createDocumentFragment();
            let html=""
    
            for (let i = 0; i < objData.length; i++) {
                let url = base_url+"/Assets/images/uploads/mensaje.png";
                let name = objData[i]['firstname']+" "+objData[i]['lastname'];

                html += `
                
                <div class="row mt-2 bg-body rounded item" data-name="${name}" data-email="${objData[i]['email']}" data-phone="${objData[i]['phone']}">
                    <hr>
                    <div class="col-md-2">
                        <img src="${url}" alt="">
                    </div>
                    <div class="col-md-7">
                        <p><strong>Nombre: </strong>${objData[i]['firstname']} ${objData[i]['lastname']}</p>
                        <ul>
                            <li class="text-secondary"><strong>Correo: </strong>${objData[i]['email']}</li>
                            <li class="text-secondary"><strong>Teléfono: </strong>${objData[i]['phone']}</li>
                            <li class="text-secondary"><strong>Fecha: </strong>${objData[i]['date']}</li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-info w-100 text-white" title="Ver" name="btnView" data-id="${objData[i]['id']}">Ver</button>
                        <button class="btn btn-danger w-100 text-white" title="Eliminar" name="btnDelete"  data-id="${objData[i]['id']}">Eliminar</button>
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
        let url = base_url+"/Mensaje/getMensajes";
        request(url,"","get").then(function(objData){
            let div = document.createElement("div");
            let fragment = document.createDocumentFragment();
            let html="";
    
            for (let i = 0; i < objData.length; i++) {
                let url = base_url+"/Assets/images/uploads/mensaje.png";
                let name = objData[i]['firstname']+" "+objData[i]['lastname'];

                html += `
                
                <div class="row mt-2 bg-body rounded item" data-name="${name}" data-email="${objData[i]['email']}" data-phone="${objData[i]['phone']}">
                    <hr>
                    <div class="col-md-2">
                        <img src="${url}" alt="">
                    </div>
                    <div class="col-md-7">
                        <p><strong>Nombre: </strong>${objData[i]['firstname']} ${objData[i]['lastname']}</p>
                        <ul>
                            <li class="text-secondary"><strong>Correo: </strong>${objData[i]['email']}</li>
                            <li class="text-secondary"><strong>Teléfono: </strong>${objData[i]['phone']}</li>
                            <li class="text-secondary"><strong>Fecha: </strong>${objData[i]['date']}</li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-info w-100 text-white" title="Ver" name="btnView" data-id="${objData[i]['id']}">Ver</button>
                        <button class="btn btn-danger w-100 text-white" title="Eliminar" name="btnDelete"  data-id="${objData[i]['id']}">Eliminar</button>
                    </div>
                    <hr>
                </div>
                `;
                
            }
            div.innerHTML = html;
            div.classList.add("scroll_list");
            fragment.appendChild(div);
            element.appendChild(fragment);
        });
    }
    viewItem(id){
        let url = base_url+"/Mensaje/getMensaje";
        let formData = new FormData();
        formData.append("id",id);

        request(url,formData,"post").then(function(objData){
            if(objData.status){
                let modalItem = document.querySelector("#modalItem");
                let nombre = objData.data.firstname+" "+objData.data.lastname 
                let modal=`
                <div class="modal fade" tabindex="-1" id="modalElement">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><strong>Datos del mensaje</strong></h5>
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
                                                    <td>Nombre: </td>
                                                    <td> ${nombre}</td>
                                                </tr>
                                                <tr scope="row">
                                                    <td>Email: </td>
                                                    <td> ${objData.data.email}</td>
                                                </tr>
                                                <tr scope="row">
                                                    <td>Teléfono: </td>
                                                    <td> ${objData.data.phone}</td>
                                                </tr>
                                                <tr scope="row">
                                                    <td>Dirección IP: </td>
                                                    <td> ${objData.data.ip}</td>
                                                </tr>
                                                <tr scope="row">
                                                    <td>Dispositivo: </td>
                                                    <td> ${objData.data.device}</td>
                                                </tr>
                                                <tr scope="row">
                                                    <td>Navegador: </td>
                                                    <td> ${objData.data.useragent}</td>
                                                </tr>
                                                <tr scope="row"">
                                                    <td>Fecha: </td>
                                                    <td>${objData.data.date}</td>
                                                </tr>
                                                <tr scope="row">
                                                    <td>Mensaje: </td>
                                                    <td>${objData.data.message}</td>
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
                let modalView = new bootstrap.Modal(document.querySelector("#modalElement"));
                modalView.show();
            }else{
                Swal.fire("Error",objData.msg,"error");
            }
        })
    }
    editItem(){
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
                    let url = base_url+"/Mensaje/delMensaje"
                    let formData = new FormData();
                    formData.append("id",id);
                    loading.style.display = "flex";
                    request(url,formData,"post").then(function(objData){
                        loading.style.display = "none";
                        Swal.fire("Mensajes",objData.msg,"success");
                        element.parentElement.parentElement.remove();
                    });
                }
            });
        }
    }
    
}