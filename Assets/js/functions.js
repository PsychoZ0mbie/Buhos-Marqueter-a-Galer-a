'use strict'
function uploadImg(img,location){
    let imgUpload = img.value;
    let fileUpload = img.files;
    let type = fileUpload[0].type;
    if(type != "image/png" && type != "image/jpg" && type != "image/jpeg" && type != "image/gif"){
        imgUpload ="";
        Swal.fire("Error","El archivo es incorrecto.","error");
    }else{
        let objectUrl = window.URL || window.webkitURL;
        let route = objectUrl.createObjectURL(fileUpload[0]);
        document.querySelector(location).setAttribute("src",route);
    }
}

function resolutionImg(height,width,picture){

    let realHeight = picture.naturalHeight;
    let realWidth = picture.naturalWidth;

    height = Math.round(height * 300 * 0.393701);
    width = Math.round(width * 300 * 0.393701);

    let mpxCustom = Math.round((height*width)/1000000);
    let mpx = Math.round((realHeight * realWidth)/1000000);
    let data = "";

    if(mpx >= mpxCustom){
        data = true;
    }else{
        data = false
    }

    return data;
}

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

async function request(url,requestData,option){
    let data ="";
    option.toLowerCase();
    if(option=='post'){
        option = {
            cors: 'same-origin',
            method: 'post',
            body:requestData
        }
    }else{
        option = {
            method: 'get',
        }
    }
    try {
        let request = await fetch(url,option);
        data = await request.json();
        return data;
    } catch (error) {
        console.log("Hubo un problema con la petición: "+error.message);
    }
}

function controlTag(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true; 
    else if (tecla==0||tecla==9)  return true;
    patron =/[0-9\s]/;
    n = String.fromCharCode(tecla);
    return patron.test(n); 
}

function testText(txtString){
    var stringText = new RegExp(/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/);
    if(stringText.test(txtString)){
        return true;
    }else{
        return false;
    }
}
function testEntero(intCant){
    var intCantidad = new RegExp(/^([0-9])*$/);
    if(intCantidad.test(intCant)){
        return true;
    }else{
        return false;
    }
}
function fntEmailValidate(email){
    var stringEmail = new RegExp(/^\w+([\.-]?\w+)*@(""?:|hotmail|outlook|yahoo|live|gmail)+\.+(""?:|com|co)+$/);
    if (stringEmail.test(email) == false){
        return false;
    }else{
        return true;
    }
}

function fntValidText(){
	let validText = document.querySelectorAll(".validText");
    validText.forEach(function(validText) {
        validText.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testText(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}				
		});
	});
}

function fntValidNumber(){
	let validNumber = document.querySelectorAll(".validNumber");
    validNumber.forEach(function(validNumber) {
        validNumber.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testEntero(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}				
		});
	});
}

function fntValidEmail(){
	let validEmail = document.querySelectorAll(".validEmail");
    validEmail.forEach(function(validEmail) {
        validEmail.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!fntEmailValidate(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}				
		});
	});
}

window.addEventListener('load', function() {
	fntValidText();
	fntValidEmail(); 
	fntValidNumber();
}, false);