'use strict';
import Interface from "./interfaceClass.js";
let loading = document.querySelector("#divLoading");
export default class Galeria extends Interface{
    constructor(){
        super();
    }
    interface(){ 
    }
    addItem(){
    }
    orderItem(element,value){
        let url = base_url+"/Pedidos/getPedidos"
        let formData = new FormData();
        formData.append("orderBy",value);
        request(url,formData,"post").then(function(objData){
            let div = document.querySelector("div.scroll_list");
            let fragment = document.createDocumentFragment();
            let html=""
    
            for (let i = 0; i < objData.data.length; i++) {
                let price = formatNum(parseInt(objData.data[i]['price']),".");
                let url = base_url+"/Assets/images/uploads/pedido.png";
                let status="";
                let name = objData.data[i]['firstname']+" "+objData.data[i]['lastname'];

                if(objData.data[i]['status'] == "approved"){
                    status = `<span class="badge badge-success">${objData.data[i]['status']}</span>`;
                }else if(objData.data[i]['status'] == "pendent"){
                    status = `<span class="badge badge-warning">${objData.data[i]['status']}</span>`;
                }else{
                    status = `<span class="badge badge-danger">${objData.data[i]['status']}</span>`;
                }

                if(objData.admin){
                    html += `
                    
                    <div class="row mt-2 bg-body rounded item" data-name="${name}" data-email="${objData.data[i]['email']}" data-phone="${objData.data[i]['phone']}" data-status="${objData.data[i]['status']}">
                        <hr>
                        <div class="col-md-2">
                            <img src="${url}" alt="">
                        </div>
                        <div class="col-md-7">
                            <p><strong>Nombre: </strong>${objData.data[i]['firstname']} ${objData.data[i]['lastname']}</p>
                            <ul>
                                <li class="text-secondary"><strong>Correo: </strong>${objData.data[i]['email']}</li>
                                <li class="text-secondary"><strong>Teléfono: </strong>${objData.data[i]['phone']}</li>
                                <li class="text-secondary"><strong>Fecha: </strong>${objData.data[i]['date']}</li>
                                <li class="text-secondary"><strong>Monto: </strong>$${price}</li>
                                <li class="text-secondary"><strong>Estado: </strong>${status}</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-info w-100 text-white" title="Ver" name="btnView" data-id="${objData.data[i]['personid']}" data-order="${objData.data[i]['idorderdata']}">Ver</button>
                            <a href="#formItem" class="btn btn-success w-100 text-white" title="Editar" name="btnEdit"  data-id="${objData.data[i]['personid']}" data-order="${objData.data[i]['idorderdata']}">Editar</a>
                            <button class="btn btn-danger w-100 text-white" title="Eliminar" name="btnDelete"  data-id="${objData.data[i]['personid']}" data-order="${objData.data[i]['idorderdata']}">Eliminar</button>
                        </div>
                        <hr>
                    </div>
                    `;
                }else{
                    html += `
                    
                    <div class="row mt-2 bg-body rounded item" data-name="${name}" data-email="${objData.data[i]['email']}" data-phone="${objData.data[i]['phone']}" data-status="${objData.data[i]['status']}">
                        <hr>
                        <div class="col-md-2">
                            <img src="${url}" alt="">
                        </div>
                        <div class="col-md-7">
                            <p><strong>Nombre: </strong>${objData.data[i]['firstname']} ${objData.data[i]['lastname']}</p>
                            <ul>
                                <li class="text-secondary"><strong>Correo: </strong>${objData.data[i]['email']}</li>
                                <li class="text-secondary"><strong>Teléfono: </strong>${objData.data[i]['phone']}</li>
                                <li class="text-secondary"><strong>Fecha: </strong>${objData.data[i]['date']}</li>
                                <li class="text-secondary"><strong>Monto: </strong>$${price}</li>
                                <li class="text-secondary"><strong>Estado: </strong>${status}</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-info w-100 text-white" title="Ver" name="btnView" data-id="${objData.data[i]['personid']}" data-order="${objData.data[i]['idorderdata']}">Ver</button>
                        </div>
                        <hr>
                    </div>
                    `;
                }
            }
            div.innerHTML = html;
            fragment.appendChild(div);
            element.appendChild(fragment);
        });
    }
    showItems(element){
        let url = base_url+"/Pedidos/getPedidos";
        request(url,"","get").then(function(objData){
            let div = document.createElement("div");
            let fragment = document.createDocumentFragment();
            let html="";
    
            for (let i = 0; i < objData.data.length; i++) {
                let price = formatNum(parseInt(objData.data[i]['price']),".");
                let url = base_url+"/Assets/images/uploads/pedido.png";
                let status="";
                let name = objData.data[i]['firstname']+" "+objData.data[i]['lastname'];

                if(objData.data[i]['status'] == "approved"){
                    status = `<span class="badge badge-success">${objData.data[i]['status']}</span>`;
                }else if(objData.data[i]['status'] == "pendent"){
                    status = `<span class="badge badge-warning">${objData.data[i]['status']}</span>`;
                }else{
                    status = `<span class="badge badge-danger">${objData.data[i]['status']}</span>`;
                }

                if(objData.admin){

                    

                    html += `
                    
                    <div class="row mt-2 bg-body rounded item" data-name="${name}" data-email="${objData.data[i]['email']}" data-phone="${objData.data[i]['phone']}" data-status="${objData.data[i]['status']}">
                        <hr>
                        <div class="col-md-2">
                            <img src="${url}" alt="">
                        </div>
                        <div class="col-md-7">
                            <p><strong>Nombre: </strong>${objData.data[i]['firstname']} ${objData.data[i]['lastname']}</p>
                            <ul>
                                <li class="text-secondary"><strong>Correo: </strong>${objData.data[i]['email']}</li>
                                <li class="text-secondary"><strong>Teléfono: </strong>${objData.data[i]['phone']}</li>
                                <li class="text-secondary"><strong>Fecha: </strong>${objData.data[i]['date']}</li>
                                <li class="text-secondary"><strong>Monto: </strong>$${price}</li>
                                <li class="text-secondary"><strong>Estado: </strong>${status}</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-info w-100 text-white" title="Ver" name="btnView" data-id="${objData.data[i]['personid']}" data-order="${objData.data[i]['idorderdata']}">Ver</button>
                            <a href="#formItem" class="btn btn-success w-100 text-white" title="Editar" name="btnEdit"  data-id="${objData.data[i]['personid']}" data-order="${objData.data[i]['idorderdata']}">Editar</a>
                            <button class="btn btn-danger w-100 text-white" title="Eliminar" name="btnDelete"  data-id="${objData.data[i]['personid']}" data-order="${objData.data[i]['idorderdata']}">Eliminar</button>
                        </div>
                        <hr>
                    </div>
                    `;
                }else{
                    html += `
                    
                    <div class="row mt-2 bg-body rounded item" data-name="${name}" data-email="${objData.data[i]['email']}" data-phone="${objData.data[i]['phone']}" data-status="${objData.data[i]['status']}">
                        <hr>
                        <div class="col-md-2">
                            <img src="${url}" alt="">
                        </div>
                        <div class="col-md-7">
                            <p><strong>Nombre: </strong>${objData.data[i]['firstname']} ${objData.data[i]['lastname']}</p>
                            <ul>
                                <li class="text-secondary"><strong>Correo: </strong>${objData.data[i]['email']}</li>
                                <li class="text-secondary"><strong>Teléfono: </strong>${objData.data[i]['phone']}</li>
                                <li class="text-secondary"><strong>Fecha: </strong>${objData.data[i]['date']}</li>
                                <li class="text-secondary"><strong>Monto: </strong>$${price}</li>
                                <li class="text-secondary"><strong>Estado: </strong>${status}</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-info w-100 text-white" title="Ver" name="btnView" data-id="${objData.data[i]['personid']}" data-order="${objData.data[i]['idorderdata']}">Ver</button>
                        </div>
                        <hr>
                    </div>
                    `;
                }
            }
            div.innerHTML = html;
            div.classList.add("scroll_list");
            fragment.appendChild(div);
            element.appendChild(fragment);
        });
    }
    viewItem(id,idorder){
        let url = base_url+"/Pedidos/getPedidoDetalle";
        let formData = new FormData();
        formData.append("idpedido",idorder);
        formData.append("idpersona",id);

        request(url,formData,"post").then(function(objData){
            if(objData.status){ 
                let productos = objData.detalle;
                let html ="";
                
                for (let i = 0; i < productos.length; i++) {
                    if(productos[i]['topicid'] == 1){
                        let img="";
                        if(productos[i]['picture']!=""){
                            img = `<img src="${base_url+"/Assets/images/uploads/"+productos[i]['picture']}" class="mb-2" style="height:100px; width:100px;"><br>`;
                        }
                        html+=`
                        <tr>
                            <td>
                                ${img}
                                <strong>Referencia: </strong>${productos[i]['title']}<br>
                                <strong>Tipo de margen: </strong>${productos[i]['margintype']}<br>
                                <strong>Tipo de borde: </strong>${productos[i]['bordertype']}<br>
                                <strong>Tipo de vidrio: </strong>${productos[i]['glasstype']}<br>
                                <strong>Margen: </strong>${productos[i]['margin']}<br>
                                <strong>Medidas de la imágen: </strong>${productos[i]['measureimage']}<br>
                                <strong>Medidas del marco: </strong>${productos[i]['measureframe']}<br>
                                <strong>Impresión: </strong>${productos[i]['print']}
                            </td>
                            <td>${productos[i]['quantity']}</td>
                            <td>${productos[i]['price']}</td>
                            <td class="text-right">${productos[i]['total']}</td>
                        </tr>
                        `;
                    }else if(productos[i]['topicid'] == 2){
                        html+=`
                        <tr>
                            <td>
                                <strong>Título: </strong>${productos[i]['title']}<br>
                                <strong>Dimensiones: </strong>${productos[i]['dimensions']}<br>
                                <strong>Técnica: </strong>${productos[i]['technique']}<br>
                                <strong>Autor: </strong>${productos[i]['author']}<br>
                            </td>
                            <td>${productos[i]['quantity']}</td>
                            <td>${productos[i]['price']}</td>
                            <td class="text-right">${productos[i]['total']}</td>
                        </tr>
                        `;
                    }
                }
                document.querySelector("#listItem").classList.add("d-none");
                document.querySelector("#detailItem").classList.remove("d-none");
                document.querySelector("#fecha").innerHTML=objData.orden.date;
                document.querySelector("#orden").innerHTML=objData.orden.idorderdata;
                document.querySelector("#nombre").innerHTML=`<strong>Nombre: </strong>`+objData.orden.firstname+" "+objData.orden.lastname;
                document.querySelector("#identificacion").innerHTML=`<strong>CC: </strong>`+objData.orden.identification;
                document.querySelector("#email").innerHTML=`<strong>Email: </strong>`+objData.orden.email;
                document.querySelector("#telefono").innerHTML=`<strong>Teléfono: </strong>`+objData.orden.phone;
                document.querySelector("#lugar").innerHTML=`<strong>Departamento/ciudad: </strong>`+objData.orden.departamento+"/"+objData.orden.ciudad;
                document.querySelector("#direccion").innerHTML=`<strong>Dirección: </strong>`+objData.orden.address;
                document.querySelector("#comentario").innerHTML= objData.orden.comment;
                document.querySelector("#subtotal").innerHTML=objData.orden.price;
                document.querySelector("#total").innerHTML=objData.orden.price;
                document.querySelector("#productos").innerHTML = html;

            }else{
                Swal.fire("Error",objData.msg,"error");
            }
        })
    }
    editItem(id,idorder){
        let url = base_url+"/Pedidos/getPedido";
        let formData = new FormData();
        formData.append("idpedido",idorder);
        formData.append("idpersona",id);
        loading.style.display="flex";
        request(url,formData,"post").then(function(objData){
            loading.style.display="none";
            let modalItem = document.querySelector("#modalItem");
            let modal=`
            <div class="modal fade" tabindex="-1" id="modalElement">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><strong>Datos de pedido</strong></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="formOrder">
                                <input type="hidden" id="idpedido" value="${objData.orden.idorderdata}">
                                <input type="hidden" id="idpersona" value="${objData.orden.personid}">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Orden: </td>
                                            <td>${objData.orden.idorderdata}</td>
                                        </tr>
                                        <tr>
                                            <td>Nombre: </td>
                                            <td>${objData.orden.firstname+" "+objData.orden.lastname}</td>
                                        </tr>
                                        <tr>
                                            <td>Fecha: </td>
                                            <td>${objData.orden.date}</td>
                                        </tr>
                                        <tr>
                                            <td>Monto: </td>
                                            <td>${objData.orden.price}</td>
                                        </tr>
                                        <tr>
                                            <td>Tipo de pago: </td>
                                            <td>${objData.orden.paymenttype}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <label for="status" class="form-label">Estado</label>
                                <select class="form-control" aria-label="Default select example" id="status" name="status">
                                    ${objData.estado}
                                </select>
                                
                            </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info" id="updateBtn">Actualizar</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;

            modalItem.innerHTML = modal;
            let modalView = new bootstrap.Modal(document.querySelector("#modalElement"));
            modalView.show();
            if(document.querySelector("#updateBtn")){
                let updateBtn = document.querySelector("#updateBtn");
                updateBtn.addEventListener("click",function(){
                    let idorden = document.querySelector("#idpedido").value;
                    let idpersona = document.querySelector("#idpersona").value;
                    let select = document.querySelector("#status");
                    let status = select.options[select.selectedIndex].text;

                    let url = base_url+"/pedidos/updatePedido";
                    let formData = new FormData();

                    formData.append("idpedido",idorden);
                    formData.append("idpersona",idpersona);
                    formData.append("estado",status);
                    loading.style.display="flex";
                    request(url,formData,"post").then(function(objData){
                        loading.style.display="none";
                        if(objData.status){
                            document.querySelector("div.scroll_list").innerHTML = document.querySelector("div.scroll_list").innerHTML;
                            Swal.fire("Pedidos",objData.msg,"success");
                            modalView.hide();
                            setTimeout(function(){
                                location.reload();
                            },2000);
                        }else{
                            Swal.fire("Error",objData.msg,"error");
                        }
                    });
                });
            }
        });

        
    }
    deleteItem(element,id,idorder){
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
                    let url = base_url+"/Pedidos/delPedido"
                    let formData = new FormData();
                    formData.append("idpedido",idorder);
                    formData.append("idpersona",id);
                    loading.style.display = "flex";
                    request(url,formData,"post").then(function(objData){
                        loading.style.display = "none";
                        Swal.fire("Pedidos",objData.msg,"success");
                        element.parentElement.parentElement.remove();
                    });
                }
            });
        }
    }
    
}