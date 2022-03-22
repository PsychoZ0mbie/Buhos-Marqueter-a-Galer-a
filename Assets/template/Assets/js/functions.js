let divLoading = document.querySelector("#divLoading");
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
    if(document.querySelector("#listDepartamento")){
        let dep = document.querySelector("#listDepartamento");
        dep.onchange= function(){
            let id = document.querySelector("#listDepartamento").value;
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
            let ajaxUrl = base_url+"/Usuarios/getSelectCity/"+id;

            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    document.querySelector("#listCiudad").innerHTML = request.responseText;
                }
            }
        }
    }
    getDepartamento();
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
                    let ajaxUrl = base_url+"/catalogo/getProductAtributo/"+idAtributo;
        
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
    
            
            divLoading.style.display = "flex";
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
                divLoading.style.display = "none";
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
                    window.location.reload(false);
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
                window.location.reload(false);
            }
        }else{
            Swal.fire("",objData.msg,"error");
        }
    }
}
function getDepartamento(){
    if(document.querySelector('#listDepartamento')){

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl  = base_url+'/Usuarios/getSelectDepartamentos';
        request.open("GET",ajaxUrl ,true);
        request.send(); 
        request.onreadystatechange = function(){
            if(request.readyState ==4 && request.status ==200){
                let objData = JSON.parse(request.responseText);
                document.querySelector('#listDepartamento').innerHTML = objData.department;
                document.querySelector('#listCiudad').innerHTML = objData.city;
            }
        }
    }
}
/******************************Register************************************/
if(document.querySelector("#formRegister")){
    let formRegister = document.querySelector("#formRegister");
    formRegister.onsubmit = function(e){
        e.preventDefault();

        let strNombre = document.querySelector("#txtNombreCliente").value;
        let strApellido = document.querySelector("#txtApellidoCliente").value;
        let strEmail = document.querySelector("#txtEmailCliente").value;
        let strPassword = document.querySelector("#txtPasswordCliente").value;

        if(strNombre == "" || strApellido == "" || strEmail == "" || strPassword == ""){
            Swal.fire("Error","Todos los campos son obligatorios.","error");
            return false;
        }
        if(!fntEmailValidate(strEmail)){
            Swal.fire("Error","El correo electrónico ingresado no es valido.","error");
            return false;
        }
        if(strPassword.length < 8){
            Swal.fire("Error","La contraseña debe tener mínimo 8 carácteres.","error");
            return false;
        }
        divLoading.style.display = "flex";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+"/Catalogo/setCliente";
        let formData = new FormData(formRegister);

        request.open("POST",ajaxUrl,true);
        request.send(formData);

        request.onreadystatechange = function(){
            if(request.status == 200 && request.readyState == 4){
                let objData = JSON.parse(request.responseText);
                if(objData.status){
                    Swal.fire({
                        icon: 'success',
                        title: objData.msg,
                        confirmButtonText: 'Ok'
                      }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload(false);
                        }
                      })
                }else{
                    Swal.fire("Error",objData.msg,"error");
                } 
            }
            divLoading.style.display = "none";
        }

    }
}
/******************************Form Order************************************/
if(document.querySelector("#formOrden")){
    let formOrden = document.querySelector("#formOrden");
    formOrden.onsubmit = function(e){
        e.preventDefault();

        let strNombre = document.querySelector("#txtNombreOrden").value;
        let strApellido = document.querySelector("#txtApellidoOrden").value;
        let strIdentificacion = document.querySelector("#txtIdentificacion").value;
        let strEmail = document.querySelector("#txtEmailOrden").value;
        let intDepartamento = document.querySelector("#listDepartamento").value;
        let intCiudad = document.querySelector("#listCiudad").value;
        let strDireccion = document.querySelector("#txtDireccion").value;
        let intTelefono = document.querySelector("#txtTelefono").value;
        let strComentario = document.querySelector("#txtComentario").value;
        let intTotal = document.querySelector("#txtPrecio").value;

        if(strNombre == "" || strApellido == "" || strEmail == "" || strIdentificacion==""
            || intDepartamento == "" || intCiudad == "" || strDireccion == "" || intTelefono==""){
            Swal.fire("Error","Por favor, revisa los campos a completar.","error");
            return false;
        }
        if(!fntEmailValidate(strEmail)){
            Swal.fire("Error","El correo electrónico ingresado no es valido.","error");
            return false;
        }
        if(intTelefono.length < 10){
            Swal.fire("Error","El número de teléfono debe tener máximo 10 dígitos","error");
            return false;
        }
        divLoading.style.display = "flex";
        request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        ajaxUrl = base_url+"/catalogo/setPedido";
        formData = new FormData(formOrden);

        request.open("POST",ajaxUrl,true);
        request.send(formData);
        
        request.onreadystatechange=function(){
            if(request.status == 200 && request.readyState == 4){
                let objData = JSON.parse(request.responseText);
                if(objData.status){
                    window.location = base_url+"/catalogo/confirmarPedido";
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            }
            divLoading.style.display = "none";
        }
    }
}
/******************************Contact************************************/
if(document.querySelector("#formContacto")){
    let formContacto = document.querySelector("#formContacto");
    formContacto.onsubmit=function(e){
        e.preventDefault();

        let strNombre = document.querySelector("#txtNombre").value;
        let strApellido = document.querySelector("#txtApellido").value;
        let strEmail = document.querySelector("#txtEmail").value;
        let intTelefono = document.querySelector("#txtTelefono").value;
        let strComentario = document.querySelector("#txtComentario").value;

        if(strNombre == "" || strApellido == "" || strEmail == "" || intTelefono=="" || strComentario==""){
            Swal.fire("Error","Todos los campos son obligatorios","error");
            return false;
        }
        if(!fntEmailValidate(strEmail)){
            Swal.fire("Error","El correo electrónico ingresado no es valido.","error");
            return false;
        }
        if(intTelefono.length < 10){
            Swal.fire("Error","El número de teléfono debe tener máximo 10 dígitos","error");
            return false;
        }
        divLoading.style.display = "flex";
        request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        ajaxUrl = base_url+"/contacto/setContacto";
        formData = new FormData(formContacto);

        request.open("POST",ajaxUrl,true);
        request.send(formData);
        
        request.onreadystatechange=function(){
            if(request.status == 200 && request.readyState == 4){
                let objData = JSON.parse(request.responseText);
                if(objData.status){
                    Swal.fire("",objData.msg,"success");
                    formContacto.reset();
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            }
            divLoading.style.display = "none";
        }
    }
}