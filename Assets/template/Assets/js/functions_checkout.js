document.querySelector("#btnCart").classList.add("d-none");
let intCountry = document.querySelector("#listCountry");
let intState = document.querySelector("#listState");
let intCity = document.querySelector("#listCity");
let formOrder = document.querySelector("#formOrder");
let checkData = document.querySelector("#checkData");

request(base_url+"/pago/getCountries","","get").then(function(objData){
    intCountry.innerHTML = objData;
});

intCountry.addEventListener("change",function(){
    request(base_url+"/pago/getSelectCountry/"+intCountry.value,"","get").then(function(objData){
        intState.innerHTML = objData;
    });
    intCity.innerHTML = "";
});
intState.addEventListener("change",function(){
    request(base_url+"/pago/getSelectState/"+intState.value,"","get").then(function(objData){
        intCity.innerHTML = objData;
    });
});
/*
checkData.addEventListener("click",function(){
    let strName = document.querySelector("#txtNameOrder").value;
    let strLastName = document.querySelector("#txtLastNameOrder").value;
    let strEmail = document.querySelector("#txtEmailOrder").value;
    let strPhone = document.querySelector("#txtPhoneOrder").value;
    let strAddress = document.querySelector("#txtAddressOrder").value;
    let strPostalCode = document.querySelector("#txtPostCodeOrder").value;
    let strNote = document.querySelector("#txtNote");

    const countryList = document.querySelector("#listCountry");
    const stateList = document.querySelector("#listState");
    const cityList = document.querySelector("#listCity"); 
    const alertOrder = document.querySelector("#alertCheckData");
    const btnPaypal = document.querySelector("#paypal-button-container");
    
    
    if(strName=="" || strLastName=="" || strEmail =="" || strPhone =="" || strAddress=="" || countryList.value==0 || stateList.value ==0 || cityList.value==0){
        
        alertOrder.classList.remove("d-none");
        btnPaypal.classList.add("d-none");
        alertOrder.innerHTML =`Por favor, completa los campos con (<span class="text-danger">*</span>)`;

        return false;
    }
    if(!fntEmailValidate(strEmail)){
        alertOrder.innerHTML = "El correo es invalido";
        alertOrder.classList.remove("d-none");
        btnPaypal.classList.add("d-none");
        return false;
    }
    if(strPhone.length < 9){
        alertOrder.innerHTML = "El número de teléfono debe tener al menos 9 dígitos ";
        alertOrder.classList.remove("d-none");
        btnPaypal.classList.add("d-none");
        return false;
    }
    
    
    let formData = new FormData(formOrder);
    formData.append("country",countryList.options[countryList.selectedIndex].text);
    formData.append("state",stateList.options[stateList.selectedIndex].text);
    formData.append("city",cityList.options[cityList.selectedIndex].text);

    checkData.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
    
    
    checkData.setAttribute("disabled","");
    request(base_url+"/shop/checkData",formData,"post").then(function(objData){
        checkData.innerHTML = "Continuar";
        checkData.removeAttribute("disabled","");
        if(objData.status){
            alertOrder.classList.add("d-none");
            btnPaypal.classList.remove("d-none");
            checkData.classList.add("d-none");
        }else{
            alertOrder.classList.remove("d-none");
            checkData.classList.remove("d-none");
            btnPaypal.classList.add("d-none");
            alertOrder.innerHTML = objData.msg;
        }
    });
});*/
btnOrder.addEventListener("click",function(e){
    let urlSearch = window.location.search;
    let params = new URLSearchParams(urlSearch);
    let cupon = "";
    if(params.get("cupon")){
        cupon = params.get("cupon");
    }

    e.preventDefault();
    let strNombre = document.querySelector("#txtNameOrder").value;
    let strApellido = document.querySelector("#txtLastNameOrder").value;
    let strEmail = document.querySelector("#txtEmailOrder").value;
    let intTelefono = document.querySelector("#txtPhoneOrder").value;
    let intPais = document.querySelector("#listCountry");
    let intDepartamento = document.querySelector("#listState");
    let intCiudad = document.querySelector("#listCity");
    let strDireccion = document.querySelector("#txtAddressOrder").value;

    

    if(intPais =="" || strNombre =="" || strApellido =="" || strEmail =="" || intTelefono==""
    || intPais.value =="" || intDepartamento.value ==""
    || intCiudad.value =="" || strDireccion==""){
        Swal.fire("Error","todos los campos con (*) son obligatorios","error");
        return false;
    }
    if(intTelefono.length < 10){
        Swal.fire("Error","El número de teléfono debe tener 10 dígitos","error");
        return false;
    }
    if(!fntEmailValidate(strEmail)){
        Swal.fire("Error","El correo ingresado es inválido","error");
        return false;
    }
    let strCountry = intPais.options[intPais.selectedIndex].text;
    let strState = intDepartamento.options[intDepartamento.selectedIndex].text;
    let strCity = intCiudad.options[intCiudad.selectedIndex].text;

    let formOrden = document.querySelector("#formOrder");
    let formData = new FormData(formOrden);
    formData.append("cupon",cupon);
    formData.append("country",strCountry);
    formData.append("state",strState);
    formData.append("city",strCity);
    btnOrder.setAttribute("disabled","");
    btnOrder.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
    request(base_url+"/pago/checkInfo",formData,"post").then(function(objData){
        if(objData.status){
            window.location.href=btnOrder.getAttribute("red");
        }else{
            Swal.fire("Error",objData.msg,"error");
        }
    });
});
if(document.querySelector("#btnCoupon")){
    let btnCoupon = document.querySelector("#btnCoupon");
    btnCoupon.addEventListener("click",function(){
        let formCoupon = document.querySelector("#formCoupon");
        let strCoupon = document.querySelector("#txtCoupon").value;
        if(strCoupon ==""){
            alertCoupon.innerHTML="Por favor, ingresa el cupón.";
            alertCoupon.classList.remove("d-none");
            return false;
        }
        btnCoupon.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
        btnCoupon.setAttribute("disabled","");

        let formData = new FormData(formCoupon);
        request(base_url+"/carrito/setCouponCode",formData,"post").then(function(objData){
            btnCoupon.innerHTML=`+`;
            btnCoupon.removeAttribute("disabled");
            if(objData.status){
                window.location.href = base_url+"/pago?cupon="+objData.data.code;
            }else{
                alertCoupon.innerHTML=objData.msg;
                alertCoupon.classList.remove("d-none");
            }
        });
    })
}