
$(function(){
    var gallery = new SimpleLightbox('.gallery a', { 
    });
})

document.addEventListener('DOMContentLoaded',function(){
    totalPrice();
    btnIncrement();
    btnDecrement();
    addCar();
    
},false);

window.addEventListener('load',function() {
    newCant();
})
/******************************Total price************************************/
function totalPrice(){
    if(document.querySelectorAll(".num_dimension")){
        let inputDimension = document.querySelectorAll(".num_dimension");
        let price = parseInt(document.querySelector("#num_price").value);
        let attributePrice =0;
        if(document.querySelector("#listAtributo")){
            let atributo = document.querySelector("#listAtributo");
            atributo.onchange = function(){
                let idAtributo = atributo.value;
                if(idAtributo !="Seleccione un tipo"){
                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url+"/marqueteria/getAtributo/"+idAtributo;
        
                    request.open("GET",ajaxUrl,true);
                    request.send();
                    request.onreadystatechange = function(){
                        let objData = JSON.parse(request.responseText);
                        for (let i = 0; i < inputDimension.length; i++) {
                            let input = inputDimension[i];
                            input.value = 0;
                        }
                        document.querySelector(".price").innerHTML =`<strong>Precio: </strong>${ms}${formatNum(price,".")} ${md}`;
                        if(objData.status){
                            attributePrice = parseInt(objData.data.price);
                            for (let i = 0; i < inputDimension.length; i++) {
                                let input = inputDimension[i];
                                input.onchange=function(e){
                                    let inp = e.target;
                                    if(inp.value < 40){
                                        inp.value= 0;
                                        Swal.fire("Error","lo mínimo son 40 cm");
                                        return false;
                                    }
                                    let arrDimensions = getTotal();
                                    let perimeter = arrDimensions[0];
                                    let area = arrDimensions[1];
    
                                    total = (perimeter*price)+(area*attributePrice);
                                    total = formatNum(total,".");
    
    
                                    let html =`<strong>Precio: </strong>${ms}${total} ${md}`;
                                    document.querySelector("#num_price").value = total;
                                    document.querySelector(".price").innerHTML = html;
                                }
                            }
                        }
                    }
                }
    
            }
        }
        for (let i = 0; i < inputDimension.length; i++) {
            let input = inputDimension[i];
            input.onchange=function(e){
                let inp = e.target;
                if(inp.value < 40){
                    inp.value= 0;
                    Swal.fire("Error","lo mínimo son 40 cm");
                    return false;
                }
                let arrDimensions = getTotal();
                let perimeter = arrDimensions[0];
    
                total = perimeter*price;
                total = formatNum(total,".");
    
    
                let html =`<strong>Precio: </strong>${ms}${total} ${md}`;
                document.querySelector("#num_price").value = total;
                document.querySelector(".price").innerHTML = html;
            }
        }
        
    }
    
    
}
/******************************Quantity************************************/
function btnIncrement(){
    if(document.querySelector("#btn_increment")){
        let btn = document.querySelector("#btn_increment");
        btn.onclick = function(){
            let qty = document.querySelector("#num_cant").value;
            if(qty > 99){
                Swal.fire("Error","Has superado el límite","error");
                document.querySelector("#num_cant").value = qty;
            }else if(qty < 1){
                Swal.fire("Error","La cantidad debe ser mayor a cero","error");
                document.querySelector("#num_cant").value = 0;
            }else{
                qty++;
                document.querySelector("#num_cant").value = qty;
            }
    
        }
    }
}
function btnDecrement(){
    if(document.querySelector("#btn_decrement")){
        let btn = document.querySelector("#btn_decrement");
        btn.onclick = function(){
            let qty = document.querySelector("#num_cant").value;
            if(qty < 1){
                Swal.fire("Error","La cantidad debe ser mayor a cero","error");
                document.querySelector("#num_cant").value = 0;
            }else{
                qty--;
                document.querySelector("#num_cant").value = qty;
            }
    
        }
    }
}

/******************************AddCar************************************/
function addCar(){
    if(document.querySelector(".addCart")){
        btn = document.querySelector(".addCart");
        btn.onclick = function(){
            let intPrice = document.querySelector("#num_price").value;
            let intLargo =0;
            let intAncho=0;
            let idAtributo =0;
            let intCant = parseInt(document.querySelector("#num_cant").value);
            let idProduct = this.getAttribute("id");
            intPrice = parseInt(intPrice.replace(".",""));
    
            if(document.querySelector("#txtLargo") && document.querySelector("#txtAncho") && document.querySelector("#listAtributo")){
                intLargo = parseInt(document.querySelector("#txtLargo").value);
                intAncho = parseInt(document.querySelector("#txtAncho").value);
                idAtributo = parseInt(document.querySelector("#listAtributo").value);
                if(intLargo == "" || intAncho ==""){
                    Swal.fire("Error", "Por favor, ingresa las medidas.","error");
                    return false;
                }
                if(isNaN(idAtributo) || idAtributo<=0){
                    Swal.fire("Error", "Por favor, selecciona el tipo.","error");
                    return false;
                }
            }
            
    
            if(isNaN(intCant)||intCant <=0 ){
                Swal.fire("Error", "Por favor, ingresa la cantidad que necesita.","error");
                return false;
            }
    
            
    
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+"/catalogo/addCarrito";
            let formData = new FormData();
            formData.append("intPrice",intPrice);
            formData.append("intLargo",intLargo);
            formData.append("intAncho",intAncho);
            formData.append("intCant",intCant);
            formData.append("idProduct",idProduct);
            formData.append("idAtributo",idAtributo);
    
            request.open("POST",ajaxUrl,true);
            request.send(formData);
    
            request.onreadystatechange = function(){
                if(request.readyState==4 && request.status ==200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status){
                        document.querySelector("#cantCarrito i").innerHTML =` (${objData.cantidad})`;
                        Swal.fire(objData.nombre,objData.msg,"success");
                    }else{
                        Swal.fire("Error",objData.msg,"error");
                    }
                }
            }
    
            /*console.log(intPrice)+"<br>";
            console.log(intLargo)+"<br>";
            console.log(intAncho)+"<br>";
            console.log(intCant)+"<br>";
            console.log(idProduct)+"<br>";
            console.log(idAtributo)+"<br>";*/
        }
    }
}
/******************************UpdateCar************************************/
function newCant(){
    if(document.querySelectorAll(".carCant")){
        btn = document.querySelectorAll(".carCant");
        for (let i = 0; i < btn.length; i++) {
            let input = btn[i];
            input.onchange=function(){
                let idproducto = this.getAttribute('idpr');
                let idatributo = this.getAttribute('idat');
                let largo = this.getAttribute('lar');
                let ancho = this.getAttribute('anc');
                let cant = this.value;
                if(idproducto !=null){
                    updateCant(idproducto,idatributo,largo,ancho,cant);
                }
            }
        }
    }
}

/******************************functions************************************/
function formatNum(num,mil){
    let numero = num;
    let format = mil;

    const noTruncarDecimales = {maximumFractionDigits: 20};

    if(format == ","){
        format = numero.toLocaleString('en-US', noTruncarDecimales);
    }else if(mil == "."){
        format  = numero.toLocaleString('es', noTruncarDecimales);
    }
    return format;   
}

function getTotal(){
    let arrInput = document.querySelectorAll(".num_dimension");
    let perimeter = 0;
    let area = 0;

    for (let i = 0; i < arrInput.length; i++) {
        perimeter+=parseInt(arrInput[i].value)*2;
        area=parseInt(arrInput[i].value)*parseInt(arrInput[i].value);
    }
    let arrDimensions = [perimeter,area];
    return arrDimensions;
}

function updateCant(idproducto,idatributo,largo,ancho,cant){

    if (cant <= 0) {
        document.querySelector("#btn_pedido").classList.add("d-none");
    }else{
        document.querySelector("#btn_pedido").classList.remove("d-none");
        request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        ajaxUrl = base_url+"/catalogo/updateCarrito";

        formData = new FormData();
        
        formData.append("idproducto",idproducto);
        formData.append("idatributo",idatributo);
        formData.append("largo",largo);
        formData.append("ancho",ancho);
        formData.append("intCant",cant);

        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange=function(){
            if(request.status == 200 && request.readyState == 4){
                let objData = JSON.parse(request.responseText);
                if(objData.status){
                    /*idatributo = "at"+idatributo;
                    largo = "l"+largo;
                    ancho ="a"+ancho;
                    idproducto =idatributo+largo+ancho+idproducto;
                    console.log(idproducto);
                    document.getElementsByClassName(idproducto).textContent = "hola";
                    //document.querySelector("."+idproducto).innerHTML = objData.subtotal;
                    document.querySelector("#resume_subtotal").innerHTML= objData.subtotal;
                    document.querySelector("#resume_envio").innerHTML = objData.envio;
                    document.querySelector("#resume_total").innerHTML = objData.total;*/
                    location.reload();
                }else{
                    Swal.fire("",objData.msg,"error");
                }
            }
        }

    }
}

function deleteCar(element){
    let idproducto = element.getAttribute('idpr');
    let idatributo = element.getAttribute('idat');
    let largo = element.getAttribute('lar');
    let ancho = element.getAttribute('anc');

    request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    ajaxUrl = base_url+"/catalogo/deleteCarrito";
    formData = new FormData();

    formData.append("idproducto",idproducto);
    formData.append("idatributo",idatributo);
    formData.append("largo",largo);
    formData.append("ancho",ancho);

    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status ==200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                location.reload();
            }
        }else{
            Swal.fire("",objData.msg,"error");
        }
    }
}

