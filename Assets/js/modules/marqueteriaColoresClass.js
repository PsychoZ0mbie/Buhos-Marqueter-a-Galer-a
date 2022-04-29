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
            <input type="hidden" id="idColor" name="idColor" value="">
            <div class="mb-3">
                <label for="txtName" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="txtName" name="txtName">
            </div>
            <div class="mb-3">
                <label for="txtHexa" class="form-label">Código hexadecimal</label>
                <input type="text" class="form-control" id="txtHexa" name="txtHexa">
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
        let url = base_url+"/Marqueteria/getColores"
        let formData = new FormData();
        let fragment = document.createDocumentFragment();
        formData.append("orderBy",value);
        request(url,formData,"post").then(function(objData){
            let div = document.querySelector("div.scroll_list");
            let html=""
            let statusList = document.querySelectorAll("#statusList option");
            let status="";

            for (let i = 0; i < objData.length; i++) {
                
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
                
                <div class="row mt-2 bg-body rounded item" data-title="${objData[i]['title']}">
                    <hr>
                    <div class="col-md-2">
                        <div class="item_color" style="background: #${objData[i]['hex']};"></div>
                    </div>
                    <div class="col-md-7">
                        <p><strong>Nombre: </strong>${objData[i]['title']}</p>
                        <ul>
                            <li class="text-secondary"><strong>Código hexadecimal: </strong>#${objData[i]['hex']}</li>
                            <li class="text-secondary"><strong>Disponibilidad: </strong>${status}</li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <a href="#formItem" class="btn btn-success w-100 text-white" title="Editar" name="btnEdit"  data-id="${objData[i]['id']}">Editar</a>
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
        let url = base_url+"/Marqueteria/getColores";
        request(url,"","get").then(function(objData){

            let div = document.createElement("div");
            let fragment = document.createDocumentFragment();
            let html=""
            let statusList = document.querySelectorAll("#statusList option");
            let status="";

            for (let i = 0; i < objData.length; i++) {
                
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
                
                <div class="row mt-2 bg-body rounded item" data-title="${objData[i]['title']}">
                    <hr>
                    <div class="col-md-2">
                        <div class="item_color" style="background: #${objData[i]['hex']};"></div>
                    </div>
                    <div class="col-md-7">
                        <p><strong>Nombre: </strong>${objData[i]['title']}</p>
                        <ul>
                            <li class="text-secondary"><strong>Código hexadecimal: </strong>#${objData[i]['hex']}</li>
                            <li class="text-secondary"><strong>Disponibilidad: </strong>${status}</li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <a href="#formItem" class="btn btn-success w-100 text-white" title="Editar" name="btnEdit"  data-id="${objData[i]['id']}">Editar</a>
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
        })
    }
    viewItem(){
        
    }
    editItem(id){

        let url = base_url+"/Marqueteria/getColor";
        let formData = new FormData();
        formData.append("idcolor",id);
        request(url,formData,"post").then(function(objData){
            if(objData.status){

                let statusList = document.querySelectorAll("#statusList option");

                for (let l = 0; l < statusList.length; l++) {
                    if(statusList[l].value == objData.data.status){
                        statusList[l].setAttribute("selected","selected")
                        break;
                    }
                }

                document.querySelector("#txtName").value = objData.data.title;
                document.querySelector("#txtHexa").value = objData.data.hex;
                document.querySelector("#idColor").value = objData.data.id;


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
                    let url = base_url+"/Marqueteria/delColor"
                    let formData = new FormData();
                    formData.append("idcolor",id);
                    loading.style.display = "flex";
                    request(url,formData,"post").then(function(objData){
                        loading.style.display = "none";
                        Swal.fire("Marqueteria",objData.msg,"success");
                        element.parentElement.parentElement.remove();
                    });
                }
            });
        }
    }
}
