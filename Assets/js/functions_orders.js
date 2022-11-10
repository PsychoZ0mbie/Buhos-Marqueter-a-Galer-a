'use strict';

if(document.querySelector("#quickSale")){
    window.addEventListener("load",function(){
        updateCart();
    })
    const moneyReceived = document.querySelector("#moneyReceived");
    const btnAddPos = document.querySelector("#btnAddPos");
    let searchProducts = document.querySelector("#searchProducts");
    let searchCustomers = document.querySelector("#searchCustomers");
    moneyReceived.addEventListener("input",function(){
        let total = document.querySelector("#total").getAttribute("data-total");
        let result = 0;
        result = moneyReceived.value - total ;
        if(result < 0){
            result = 0;
        }
    
        document.querySelector("#moneyBack").innerHTML = "Money back: "+MS+formatNum(result,".")+" "+MD;
    });
    btnAddPos.addEventListener("click",function(){
        let id = document.querySelector("#idCustomer").value;
        if(id <= 0){
            Swal.fire("Error","Por favor, añada un cliente para establecer el pedido","error");
            return false;
        }else{
            let products = document.querySelectorAll(".product");
            let arrProducts = [];
            for (let i = 0; i < products.length; i++) {
                let product = {
                    "id":products[i].children[0].getAttribute("data-id"),
                    "qty":products[i].children[1].children[0].children[0].children[1].children[1].getAttribute("data-value")
                };
                arrProducts.push(product);
            }
            let formData = new FormData();
            formData.append("id",id);
            formData.append("products",JSON.stringify(arrProducts));
            btnAddPos.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
            btnAddPos.setAttribute("disabled","");
            request(base_url+"/pedidos/setOrder",formData,"post").then(function(objData){
                btnAddPos.removeAttribute("disabled");
                btnAddPos.innerHTML="Guardar";
                if(objData.status){
                    location.reload();
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            });
        }
    });
    searchProducts.addEventListener('input',function() {
        request(base_url+"/pedidos/searchProducts/"+searchProducts.value,"","get").then(function(objData){
            if(objData.status){
                document.querySelector("#listProducts").innerHTML = objData.data;
            }else{
                document.querySelector("#listProducts").innerHTML = objData.data;
            }
        });
    });
    searchCustomers.addEventListener('input',function() {
        if(searchCustomers.value !=""){
            request(base_url+"/pedidos/searchCustomers/"+searchCustomers.value,"","get").then(function(objData){
                if(objData.status){
                    document.querySelector("#customers").innerHTML = objData.data;
                }else{
                    document.querySelector("#customers").innerHTML = objData.data;
                }
            });
        }else{
            document.querySelector("#customers").innerHTML = "";
        }
    });
}
if(document.querySelector("#pedidos")){
    let search = document.querySelector("#search");
    let sort = document.querySelector("#sortBy");
    let element = document.querySelector("#listItem");
    
    search.addEventListener('input',function() {
        request(base_url+"/pedidos/search/"+search.value,"","get").then(function(objData){
            if(objData.status){
                element.innerHTML = objData.data;
            }else{
                element.innerHTML = objData.msg;
            }
        });
    });
    
    sort.addEventListener("change",function(){
        request(base_url+"/pedidos/sort/"+sort.value,"","get").then(function(objData){
            if(objData.status){
                element.innerHTML = objData.data;
            }else{
                element.innerHTML = objData.msg;
            }
        });
    });
    element.addEventListener("click",function(e) {
        let element = e.target;
        let id = element.getAttribute("data-id");
        if(element.name == "btnDelete"){
            deleteItem(id);
        }
    });
    function deleteItem(id){
        Swal.fire({
            title:"¿Estás seguro de eliminarlo?",
            text:"Se eliminará para siempre...",
            icon: 'warning',
            showCancelButton:true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText:"Sí, eliminar",
            cancelButtonText:"No, cancelar"
        }).then(function(result){
            if(result.isConfirmed){
                let url = base_url+"/pedidos/delOrder"
                let formData = new FormData();
                formData.append("idOrder",id);
                request(url,formData,"post").then(function(objData){
                    if(objData.status){
                        Swal.fire("Eliminado",objData.msg,"success");
                        element.innerHTML = objData.data;
                    }else{
                        Swal.fire("Error",objData.msg,"error");
                    }
                });
            }
        });
    }
    
}
if(document.querySelector("#btnRefund")){
    let btn = document.querySelector("#btnRefund");
    btn.addEventListener("click",function(){
        refund(btn.getAttribute("data-id"));
    });
    function refund(id){
        let btn = document.querySelector("#btnRefund");
        btn.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
        btn.setAttribute("disabled","");
    
        request(base_url+"/pedidos/getTransaction/"+id,"","get").then(function(objData){
            btn.removeAttribute("disabled");
            btn.innerHTML=`<i class="fas fa-undo"></i> Reembolsar`;
    
            if(objData.status){
                
                let transaction = objData.data;
                let idTransaction = transaction.purchase_units[0].payments.captures[0].id;
                let payer = transaction.purchase_units[0].shipping.name.full_name+'<br>'+transaction.payer.email_address;
                let grossAmount = transaction.purchase_units[0].payments.captures[0].seller_receivable_breakdown.gross_amount.value;
                let feeAmount = transaction.purchase_units[0].payments.captures[0].seller_receivable_breakdown.paypal_fee.value;
                let netAmount = transaction.purchase_units[0].payments.captures[0].seller_receivable_breakdown.net_amount.value;
                let modalItem = document.querySelector("#modalItem");
                let modal= `
                <div class="modal fade" id="modalElement">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Reembolsar</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formItem" name="formItem" class="mb-4">
                                    <input type="hidden" id="idTransaction" name="idTransaction" value="${idTransaction}">
                                    <table class="table align-middle text-break">
                                        <tbody id="listItem">
                                            <tr>
                                                <td>Transaccion: </td>
                                                <td>${idTransaction}</td>
                                            </tr>
                                            <tr>
                                                <td>Pagador: </td>
                                                <td>${payer}</td>
                                            </tr>
                                            <tr>
                                                <td>Reembolso bruto: </td>
                                                <td>${grossAmount+" "+MD}</td>
                                            </tr>
                                            <tr>
                                                <td>Comisión de paypal: </td>
                                                <td>${feeAmount+" "+MD}</td>
                                            </tr>
                                            <tr>
                                                <td>Reembolso neto: </td>
                                                <td>${netAmount+" "+MD}</td>
                                            </tr>
                                            <tr>
                                                <td>Observación: </td>
                                                <td><textarea name="txtDescription" id="txtDescription" rows="3" class="w-100 form-control"></textarea></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success text-white" id="btnRefundConfirm"><i class="fas fa-undo"></i> Reembolsar</a>
                                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                `;
    
                modalItem.innerHTML = modal;
                let modalView = new bootstrap.Modal(document.querySelector("#modalElement"));
                modalView.show();
    
                let form = document.querySelector("#formItem");
                form.addEventListener("submit",function(e){
                    e.preventDefault();
                    
                    let strDescription = document.querySelector("#txtDescription").value;
                    let idTransaction = document.querySelector("#idTransaction").value;
                    let btnRefundConfirm = document.querySelector("#btnRefundConfirm");
                    
                    if(idTransaction == "" || strDescription == ""){
                        Swal.fire("Error","Por favor, rellene los campos ","error");
                        return false;
                    }
                    btnRefundConfirm.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
                    btnRefundConfirm.setAttribute("disabled","");
                    Swal.fire({
                        title:"Está seguro de hacer el reembolso?",
                        icon: 'warning',
                        showCancelButton:true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText:"Sí, reembolsar",
                        cancelButtonText:"No, cancelar"
                    }).then(function(result){
                        
                        let formData = new FormData(form);
                        if(result.isConfirmed){
                            request(base_url+"/pedidos/setRefund",formData,"post").then(function(objData){
                                btnRefundConfirm.innerHTML=`<i class="fas fa-undo"></i> Reembolsar`;
                                btnRefundConfirm.removeAttribute("disabled");
                                if(objData.status){
                                    window.location.reload();
                                }else{
                                    Swal.fire("Error",objData.msg,"error");
                                }
                            });
                        }else{
                            btnRefundConfirm.innerHTML=`<i class="fas fa-undo"></i> Reembolsar`;
                            btnRefundConfirm.removeAttribute("disabled");
                        }
                    });
                });
            }else{
                Swal.fire("Error",objData.msg,"error");
            }
        });
    }
}
if(document.querySelector("#btnPrint")){
    let btn = document.querySelector("#btnPrint");
    btn.addEventListener("click",function(){
        if(document.querySelector("#btnRefund"))document.querySelector("#btnRefund").classList.add("d-none");
        printDiv(document.querySelector("#orderInfo"));
    });
}
function addProduct(id=null, element){
    let formData = new FormData();
    const toastLiveExample = document.getElementById('liveToast');
    let topic = 0;
    if(id!=null){
        topic = 2;
    }else{
        id = 0;
        topic = 3;
        let strService = document.querySelector("#txtService").value;
        let intPrice = document.querySelector("#intPrice").value;
        formData.append("txtService",strService);
        formData.append("intPrice",intPrice);
    }
    let idProduct = id;
    let intQty = 1;

    formData.append("idProduct",idProduct);
    formData.append("topic",topic);
    formData.append("txtQty",intQty);

    element.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
    element.setAttribute("disabled","");
    request(base_url+"/pedidos/addCart",formData,"post").then(function(objData){
        element.innerHTML=`Agregar`;
        element.removeAttribute("disabled");
        document.querySelector(".toast-header img").src=objData.data.image;
        document.querySelector(".toast-header img").alt=objData.data.name;
        document.querySelector("#toastProduct").innerHTML=objData.data.name;
        document.querySelector(".toast-body").innerHTML=objData.msg;
        if(objData.status){
            document.querySelector("#total").innerHTML = objData.total;
            document.querySelector("#posProducts").innerHTML = objData.html;
            updateCart();
        }

        const toast = new bootstrap.Toast(toastLiveExample);
        toast.show();
    });
}
function delProduct(element){
    let formData = new FormData();
    let topic = element.parentElement.getAttribute("data-topic");
    let id = element.parentElement.getAttribute("data-id");
    formData.append("topic",topic);
    formData.append("id",id);
    if(topic == 1){
        let photo = element.parentElement.getAttribute("data-f");
        let height = element.parentElement.getAttribute("data-h");
        let width = element.parentElement.getAttribute("data-w");
        let margin = element.parentElement.getAttribute("data-m");
        let marginColor = element.parentElement.getAttribute("data-mc");
        let borderColor = element.parentElement.getAttribute("data-bc");
        let style = element.parentElement.getAttribute("data-s");
        let type = element.parentElement.getAttribute("data-t");
        let reference = element.parentElement.getAttribute("data-r");
        formData.append("height",height);
        formData.append("width",width);
        formData.append("margin",margin);
        formData.append("margincolor",marginColor);
        formData.append("bordercolor",borderColor);
        formData.append("style",style);
        formData.append("type",type);
        formData.append("photo",photo);
        formData.append("reference",reference);
    }else if(topic==3){
        let strService = element.parentElement.getAttribute("data-name");
        let intPrice = element.parentElement.getAttribute("data-price");
        formData.append("txtService",strService);
        formData.append("intPrice",intPrice);
    }
    element.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
    element.setAttribute("disabled","");
    request(base_url+"/pedidos/delCart",formData,"post").then(function(objData){
        element.innerHTML=`<i class="fas fa-times"></i>`;
        element.removeAttribute("disabled");
        if(objData.status){
            document.querySelector("#total").innerHTML = objData.total;
            document.querySelector("#posProducts").innerHTML = objData.html;
            element.parentElement.remove();
            updateCart();
        }
    });
}
function updateCart(){
    let decrement = document.querySelectorAll(".productDec");
    let increment = document.querySelectorAll(".productInc");
    for (let i = 0; i < increment.length; i++) {
        let minus = decrement[i];
        let plus = increment[i];
        let id = minus.parentElement.parentElement.parentElement.parentElement.getAttribute("data-id");
        let topic = minus.parentElement.parentElement.parentElement.parentElement.getAttribute("data-topic");

        minus.addEventListener("click",function(){
            let qty=parseInt(document.querySelectorAll(".qtyProduct")[i].innerHTML);
            if(qty <=1){
                qty = 1;
            }else{
                qty--;
            }
            let formData = new FormData();
            formData.append("id",id);
            formData.append("topic",topic);
            formData.append("qty",qty);
            
            if(topic == 1){
                let height = minus.parentElement.parentElement.parentElement.parentElement.getAttribute("data-h");
                let width = minus.parentElement.parentElement.parentElement.parentElement.getAttribute("data-w");
                let margin = minus.parentElement.parentElement.parentElement.parentElement.getAttribute("data-m");
                let style = minus.parentElement.parentElement.parentElement.parentElement.getAttribute("data-s");
                let colorMargin = minus.parentElement.parentElement.parentElement.parentElement.getAttribute("data-mc");
                let colorBorder = minus.parentElement.parentElement.parentElement.parentElement.getAttribute("data-bc");
                let idType = minus.parentElement.parentElement.parentElement.parentElement.getAttribute("data-t");
                let reference = minus.parentElement.parentElement.parentElement.parentElement.getAttribute("data-r");
                formData.append("height",height);
                formData.append("width",width);
                formData.append("margin",margin);
                formData.append("style",style);
                formData.append("colormargin",colorMargin);
                formData.append("colorborder",colorBorder);
                formData.append("idType",idType);
                formData.append("reference",reference);
            }
            document.querySelector("#total").innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
            document.querySelectorAll(".productTotal")[i].innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
            request(base_url+"/pedidos/updateCart",formData,"post").then(function(objData){
                if(objData.status){
                    document.querySelectorAll(".qtyProduct")[i].innerHTML = objData.qty;
                    document.querySelectorAll(".productTotal")[i].innerHTML = objData.totalprice;
                    document.querySelector("#total").innerHTML = objData.total;
                }
            });
        });
        plus.addEventListener("click",function(){
            let qty=parseInt(document.querySelectorAll(".qtyProduct")[i].innerHTML);
            let formData = new FormData();
            formData.append("id",id);
            formData.append("topic",topic);
            formData.append("qty",++qty);
            
            if(topic == 1){
                let height = minus.parentElement.parentElement.parentElement.parentElement.getAttribute("data-h");
                let width = minus.parentElement.parentElement.parentElement.parentElement.getAttribute("data-w");
                let margin = minus.parentElement.parentElement.parentElement.parentElement.getAttribute("data-m");
                let style = minus.parentElement.parentElement.parentElement.parentElement.getAttribute("data-s");
                let colorMargin = minus.parentElement.parentElement.parentElement.parentElement.getAttribute("data-mc");
                let colorBorder = minus.parentElement.parentElement.parentElement.parentElement.getAttribute("data-bc");
                let idType = minus.parentElement.parentElement.parentElement.parentElement.getAttribute("data-t");
                let reference = minus.parentElement.parentElement.parentElement.parentElement.getAttribute("data-r");

                formData.append("height",height);
                formData.append("width",width);
                formData.append("margin",margin);
                formData.append("style",style);
                formData.append("colormargin",colorMargin);
                formData.append("colorborder",colorBorder);
                formData.append("idType",idType);
                formData.append("reference",reference);
            }
            document.querySelector("#total").innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
            document.querySelectorAll(".productTotal")[i].innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
            request(base_url+"/pedidos/updateCart",formData,"post").then(function(objData){
                if(objData.status){
                    document.querySelectorAll(".qtyProduct")[i].innerHTML = objData.qty;
                    document.querySelectorAll(".productTotal")[i].innerHTML = objData.totalprice;
                    document.querySelector("#total").innerHTML = objData.total;
                }
            });
        })
    }
}
function calcTotal(){
    let data = document.querySelectorAll(".productData");
    let total = 0;
    
    for (let i = 0; i < data.length; i++) {
        total+= data[i].getAttribute("data-value")*data[i].getAttribute("data-price");
    }
    if(total > 0){
        document.querySelector("#btnPos").classList.remove("d-none");
        document.querySelector("#btnPos").removeAttribute("disabled");
    }else{
        document.querySelector("#btnPos").classList.add("d-none");
        document.querySelector("#btnPos").setAttribute("disabled","disabled");
    }
    document.querySelector("#total").innerHTML = MS+total+" "+MD;
    document.querySelector("#total").setAttribute("data-total",total);
}
function openModalOrder(){
    let modal = new bootstrap.Modal(document.querySelector("#modalPos"));
    moneyReceived.value = document.querySelector("#total").getAttribute("data-total");
    let total = document.querySelector("#total").getAttribute("data-total");
    document.querySelector("#saleValue").innerHTML = "Valor de venta: "+MS+formatNum(total,".")+" "+MD;
    document.querySelector("#moneyBack").innerHTML = "Dinero a devolver: "+MS+0+" "+MD;
    modal.show();
}
function addCustom(element){
    element.setAttribute("onclick","delCustom(this)");
    element.classList.add("border","border-primary");
    document.querySelector("#selectedCustomer").appendChild(element);
    document.querySelector("#customers").innerHTML = "";
    document.querySelector("#idCustomer").value = element.getAttribute("data-id");
    searchCustomers.parentElement.classList.add("d-none");
}
function delCustom(element){
    searchCustomers.parentElement.classList.remove("d-none");
    document.querySelector("#idCustomer").value = 0;
    element.remove();
}