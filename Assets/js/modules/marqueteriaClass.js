'use strict';
import Interface from "./interfaceClass.js";


export default class Marqueteria extends Interface{
    constructor(){
        super();
        this.strImg;
        this.strName;
        this.intPrice;
        this.intStock;
        this.strType;
    }
    interface(){
        let form = `
        <form id="formItem" name="formItem">
            <div class="mb-3 uploadImg">
                <img src="Assets/images/uploads/subirfoto.png">
                <label for="txtImg"><a class="btn btn-primary text-white">Subir foto</a></label>
                <input type="file" id="txtImg" name="txtImg"> 
            </div>
            <div class="mb-3">
                <label for="txtName" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="txtName" name="txtName">
            </div>
            <div class="mb-3">
                <label for="typeList" class="form-label">Tipo</label>
                <select class="form-control form-control" aria-label="Default select example" id="typeList" name="typeList">
                    <option value="1">Moldura en madera</option>
                    <option value="2">Moldura importada</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="intPrice" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="intPrice" name="intPrice">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="intStock" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="intStock" name="intStock">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="txtDescription" class="form-label">Descripción</label>
                <textarea class="form-control" id="txtDescription" name="txtDescription" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" id="btnAdd"><i class="fas fa-plus-circle"></i> Agregar</button>
            <button type="button" class="btn btn-secondary" onclick="location.reload()"><i class="fa fa-times-circle"></i> Cancelar</button>
        </form>
        `;
        document.querySelector("#interface").innerHTML=form;
    }
    addItem(element,strImg,strName,intPrice,intStock,strType){
        this.strImg = strImg;
        this.strName = strName;
        this.intPrice = intPrice;
        this.intStock = intStock;
        this.strType = strType;

        let div = document.createElement("div");
        div.innerHTML = `
        <hr>
        <div class="row mt-2 bg-body rounded item">
            <div class="col-md-2">
                <img src="${this.strImg}" alt="">
            </div>
            <div class="col-md-7">
                <p><strong>Nombre: </strong>${this.strName}</p>
                <ul>
                    <li class="text-secondary"><strong>Categoria: </strong>${this.strType}</li>
                    <li class="text-secondary"><strong>Cantidad: </strong>${this.intStock}</li>
                    <li class="text-secondary"><strong>Precio: </strong>${this.intPrice}</li>
                </ul>
            </div>
            <div class="col-md-3">
                <button class="btn btn-info w-100 text-white" title="Ver" name="btnView">Ver</button>
                <a href="#formItem" class="btn btn-success w-100 text-white" title="Editar" name="btnEdit">Editar</a>
                <button class="btn btn-danger w-100 text-white" title="Eliminar" name="btnDelete">Eliminar</button>
            </div>
        </div>
        <hr>
        `;
        div.setAttribute("data-name",this.strName);
        div.setAttribute("data-type",this.strType);
        div.setAttribute("data-img",this.strImg);
        element.appendChild(div);
    }
    viewItem(element){
        let elementData = element.parentElement.parentElement.parentElement;
        let name =elementData.getAttribute("data-name");
        let type = elementData.getAttribute("data-type");
        let img = elementData.getAttribute("data-img");

        let modalItem = document.querySelector("#modalItem");
        let modal=`
        <div class="modal fade" tabindex="-1" id="modalElement">
            <div class="modal-dialog modal-dialog-centered modal-lg">
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
                                                <div class="modal_img">
                                                    <img src="${img}" alt="">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr scope="row">
                                            <td>Nombre: </td>
                                            <td> ${name}</td>
                                        </tr>
                                        <tr scope="row">
                                            <td>Categoria: </td>
                                            <td> ${type}</td>
                                        </tr>
                                        <tr scope="row"">
                                            <td>Precio: </td>
                                            <td></td>
                                        </tr>
                                        <tr scope="row">
                                            <td>Cantidad: </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Descripción: </td>
                                            <td></td>
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
    }
    editItem(element){

        let elementData = element.parentElement.parentElement.parentElement;
        let name =elementData.getAttribute("data-name");
        let type = elementData.getAttribute("data-type");
        let img = elementData.getAttribute("data-img");

        document.querySelector(".uploadImg img").setAttribute("src",img);
        document.querySelector("#txtName").value = name; 
        document.querySelector("#btnAdd").textContent = "Actualizar"

    }
    deleteItem(element){
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
                element.parentElement.parentElement.remove();
            }
        });
    }
}
