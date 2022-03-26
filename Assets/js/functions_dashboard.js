window.addEventListener("load",function(){
    if(document.querySelector("#ultimosPedidos")){
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject("Microsoft.XMLHTTP");
        let ajaxUrl = base_url+"/dashboard/getPedidos";

        request.open("POST",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.status == 200 && request.readyState == 4){
                let objData = JSON.parse(request.responseText);
                let html = "";
                if(objData.status){
                    let orden = objData.orden;
                    for (let i = 0; i < orden.length; i++) {
                        html += `
                                <tr>
                                    <td>${orden[i]['idorderdata']}</td>
                                    <td>${orden[i]['firstname']} ${orden[i]['lastname']}</td>
                                    <td>${orden[i]['status']}</td>
                                    <td>${orden[i]['price']}</td>
                                </tr>
                        
                                `;
                        
                    }
                }else{
                    html= `<p>${objData.msg}</p>`;
                }
                document.querySelector("#ultimosPedidos").innerHTML=html;
            }
        }
    }
},false);

/*
function fntViewInfo(idpedido,idpersona){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+"/pedidos/getPedidoDetalle";
    let formData =new FormData();
    formData.append("idpedido",idpedido);
    formData.append("idpersona",idpersona);

    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange=function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            console.log(objData);
            if(objData.status){
                document.querySelector("#fecha").innerHTML = objData.orden.date;
                document.querySelector("#numOrden").innerHTML = objData.orden.idorderdata;
                document.querySelector("#nombre").innerHTML = objData.orden.firstname+" "+objData.orden.lastname;
                document.querySelector("#identificacion").innerHTML = objData.orden.identification;
                document.querySelector("#email").innerHTML = objData.orden.email;
                document.querySelector("#telefono").innerHTML = objData.orden.phone;
                document.querySelector("#departamento").innerHTML = objData.orden.departamento;
                document.querySelector("#ciudad").innerHTML = objData.orden.ciudad;
                document.querySelector("#direccion").innerHTML = objData.orden.address;
                document.querySelector("#subtotal").innerHTML = objData.orden.price;
                document.querySelector("#totalprecio").innerHTML = objData.orden.price;
                let arrDetalle = objData.detalle;
                let html="";
                for (let i = 0; i < arrDetalle.length; i++) {
                    let largo = arrDetalle[i]['length'];
                    let ancho = arrDetalle[i]['width'];
                    let medidas="";
                    if( largo != 0 && ancho != 0){
                        medidas = `<p>${largo}cm X ${ancho}cm</p>`;
                    }
                    html+=` <tr>
                                <td>
                                    <p>${arrDetalle[i]['title']}</p>
                                    ${medidas}
                                    <p>${arrDetalle[i]['subtopic']}</p>
                                    <p>${arrDetalle[i]['type']}</p>
                                </td>
                                <td>${arrDetalle[i]['price']}</td>
                                <td>${arrDetalle[i]['quantity']}</td>
                                <td>${arrDetalle[i]['total']}</td>
                            </tr>`;
                }
                document.querySelector("#detalle").innerHTML = html;

            }
        }
    }

}*/
