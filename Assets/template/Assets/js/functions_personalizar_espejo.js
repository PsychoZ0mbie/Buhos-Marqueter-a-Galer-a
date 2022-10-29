const DIMENSIONDEFAULT = 200;
const rangeZoom = document.querySelector("#zoomRange");
const minusZoom = document.querySelector("#zoomMinus");
const plusZoom = document.querySelector("#zoomPlus");
const intHeight = document.querySelector("#intHeight");
const intWidth = document.querySelector("#intWidth");
const layoutImg = document.querySelector(".layout--img");
const layoutMargin = document.querySelector(".layout--margin");
const sliderLeft = document.querySelector(".slider--control-left");
const sliderRight = document.querySelector(".slider--control-right");
const sliderInner = document.querySelector(".slider--inner");
const optionsCustom = document.querySelectorAll(".option--custom");
const btnBack = document.querySelector("#btnBack");
const btnNext = document.querySelector("#btnNext");
const pages = document.querySelectorAll(".page");
const containerFrames = document.querySelector(".select--frames");
const searchFrame = document.querySelector("#searchFrame");
const sortFrame = document.querySelector("#sortFrame");
const addFrame = document.querySelector("#addFrame");

let page = 0;

//----------------------------------------------
//[Change Pages]
btnNext.addEventListener("click",function(){
    for (let i = 0; i < pages.length; i++) {
        pages[i].classList.add("d-none");
    }
    page++;
    if(page == pages.length-1){
        btnNext.classList.add("d-none");
        btnBack.classList.remove("d-none");
    }else{
        btnBack.classList.add("d-none");
        btnNext.classList.remove("d-none");
    }
    if(page>0){
        btnBack.classList.remove("d-none");
    }
    pages[page].classList.remove("d-none");
});
btnBack.addEventListener("click",function(){
    for (let i = 0; i < pages.length; i++) {
        pages[i].classList.add("d-none");
    }
    page--;
    if(page == pages.length-1){
        btnNext.classList.add("d-none");
        btnBack.classList.remove("d-none");
    }else{
        btnBack.classList.add("d-none");
        btnNext.classList.remove("d-none");
    }
    if(page>0){
        btnBack.classList.remove("d-none");
    }
    pages[page].classList.remove("d-none");
});

//----------------------------------------------
//[Dimensions]
intHeight.addEventListener("change",function(){
    if(intHeight.value <= 10.0){
        intHeight.value = 10.0;
    }else if(intHeight.value >= 500.0){
        intHeight.value = 500.0;
    }
    calcularMarco();
    resizeFrame(intWidth.value, intHeight.value);
    if(intHeight.value !="" && intWidth.value!=""){
        btnNext.classList.remove("d-none");
    }
    if(intWidth.value !="" && intHeight.value!=""){
        let formData = new FormData();
        formData.append("height",intHeight.value);
        formData.append("width",intWidth.value);
        request(base_url+"/enmarcar/filterProducts",formData,"post").then(function(objData){
            if(objData.status){
                containerFrames.innerHTML = objData.data;
            }
        });
    }
});
intWidth.addEventListener("change",function(){
    if(intWidth.value <= 10.0){
        intWidth.value = 10.0;
    }else if(intWidth.value >= 500.0){
        intWidth.value = 500.0;
    }
    calcularMarco();
    resizeFrame(intWidth.value, intHeight.value);
    if(intHeight.value !="" && intWidth.value!=""){
        btnNext.classList.remove("d-none");
    }
    if(intWidth.value !="" && intHeight.value!=""){
        let formData = new FormData();
        formData.append("height",intHeight.value);
        formData.append("width",intWidth.value);
        request(base_url+"/enmarcar/filterProducts",formData,"post").then(function(objData){
            if(objData.status){
                containerFrames.innerHTML = objData.data;
            }
        });
    }
});
//----------------------------------------------
//[Zoom events]
rangeZoom.addEventListener("input",function(){
    layoutMargin.style.transform = "translate(-50%,-50%) scale("+(rangeZoom.value/100)+")";
    layoutImg.style.transform = "translate(-50%,-50%) scale("+(rangeZoom.value/100)+")";
}); 
minusZoom.addEventListener("click",function(){
    rangeZoom.value = parseInt(rangeZoom.value)-10;
    layoutMargin.style.transform = "translate(-50%,-50%) scale("+(rangeZoom.value/100)+")";
    layoutImg.style.transform = "translate(-50%,-50%) scale("+(rangeZoom.value/100)+")";
});
plusZoom.addEventListener("click",function(){
    rangeZoom.value = parseInt(rangeZoom.value)+10;
    layoutMargin.style.transform = "translate(-50%,-50%) scale("+(rangeZoom.value/100)+")";
    layoutImg.style.transform = "translate(-50%,-50%) scale("+(rangeZoom.value/100)+")";
});
//----------------------------------------------
//[Slider controls]
/*sliderLeft.addEventListener("click",function(){
    sliderInner.scrollBy(-100,0);
});
sliderRight.addEventListener("click",function(){
    sliderInner.scrollBy(100,0);
});*/

//----------------------------------------------
//[Frame custom]

searchFrame.addEventListener('input',function() {
    if(intWidth.value !="" && intHeight.value!=""){
        let formData = new FormData();
        formData.append("height",intHeight.value);
        formData.append("width",intWidth.value);
        formData.append("search",searchFrame.value);
        request(base_url+"/enmarcar/search",formData,"post").then(function(objData){
            if(objData.status){
                containerFrames.innerHTML = objData.data;
            }
        });
    }
});
sortFrame.addEventListener("change",function(){
    if(intWidth.value !="" && intHeight.value!=""){
        let formData = new FormData();
        formData.append("height",intHeight.value);
        formData.append("width",intWidth.value);
        formData.append("sort",sortFrame.value);
        request(base_url+"/enmarcar/sort",formData,"post").then(function(objData){
            if(objData.status){
                containerFrames.innerHTML = objData.data;
            }
        });
    }
});
containerFrames.addEventListener("click",function(e){
    let id = e.target.parentElement.getAttribute("data-id");
    calcularMarco(id);
    
});
//----------------------------------------------
//[Add frame]
addFrame.addEventListener("click",function(){
    let popup = document.querySelector(".popup");
    let popupClose = document.querySelector(".popup-close"); 
    let timer;
    let formData = new FormData();

    if(intHeight.value =="" || intWidth.value==""){
        Swal.fire("Error","Por favor, ingresa las medidas","error");
        return false;
    }

    if(!document.querySelector(".frame--item.element--active")){
        Swal.fire("Error","Por favor, seleccione la moldura","error");
        return false;
    }

    let margin = 0;
    let styleFrame = 1;
    let height = intHeight.value;
    let width = intWidth.value;
    let id = document.querySelector(".frame--item.element--active").getAttribute("data-id");
    let colorMargin = 0;
    let colorBorder = 0;
    let route = document.querySelector("#enmarcarTipo").getAttribute("data-route");
    let type = document.querySelector("#enmarcarTipo").getAttribute("data-name");
    let orientation = document.querySelector(".orientation.element--active").getAttribute("data-name");
    let idType = document.querySelector("#enmarcarTipo").getAttribute("data-id");
    formData.append("height",height);
    formData.append("width",width);
    formData.append("styleValue",styleFrame);
    formData.append("styleName","Directo");
    formData.append("margin",margin);
    formData.append("qty",1);
    formData.append("id",id);
    formData.append("colorMargin",colorMargin);
    formData.append("colorBorder",colorBorder);
    formData.append("type",type);
    formData.append("idType",idType);
    formData.append("route",route);
    formData.append("orientation",orientation);

    window.clearTimeout(timer);
    if(popup.classList.length>1){
        popup.classList.remove("active");
        setTimeout(function(){
            popup.classList.add("active");
        },100);
    }else{
        popup.classList.add("active");
    }
    const runTime = function(){
        timer = window.setTimeout(function(){
            popup.classList.remove("active");
        },6000);
    };

    runTime();

    request(base_url+"/enmarcar/addCart",formData,"post").then(function(objData){
        if(objData.status){
            document.querySelector("#qtyCart").innerHTML=objData.qty;
            document.querySelector("#qtyCartbar").innerHTML=objData.qty;

            popup.children[1].children[0].src=objData.data.image;
            popup.children[1].children[0].alt=objData.data.name;
            popup.children[1].children[1].children[0].innerHTML=objData.data.name;
            popup.children[1].children[1].children[0].setAttribute("href",objData.data.route);
            popup.children[1].children[1].children[1].innerHTML=objData.msg;
            popup.addEventListener("mouseover",function(){
                window.clearTimeout(timer);
                runTime();
            })
            popupClose.addEventListener("click",function(){
                popup.classList.remove("active");
            });
        }else{

            popup.children[1].children[0].src=objData.data.image;
            popup.children[1].children[0].alt=objData.data.name;
            popup.children[1].children[1].children[0].innerHTML=objData.data.name;
            popup.children[1].children[1].children[0].setAttribute("href",objData.data.route);
            popup.children[1].children[1].children[1].innerHTML=`<strong class="text-danger">${objData.msg}</strong>`;
            popup.addEventListener("mouseover",function(){
                window.clearTimeout(timer);
                runTime();
            });
            popupClose.addEventListener("click",function(){
                popup.classList.remove("active");
            });
        }
    });
}); 

function selectOrientation(element){
    let items = document.querySelectorAll(".orientation");
    for (let i = 0; i < items.length; i++) {
        items[i].classList.remove("element--active");
    }
    element.classList.add("element--active");
    document.querySelectorAll(".measures--input")[0].removeAttribute("disabled");
    document.querySelectorAll(".measures--input")[1].removeAttribute("disabled");
}
function selectActive(element =null,elements=null){
    let items = document.querySelectorAll(`${elements}`);
    for (let i = 0; i < items.length; i++) {
        items[i].classList.remove("element--active");
    }
    element.classList.add("element--active");
}
function resizeFrame(width,height){

    height = parseFloat(height) +DIMENSIONDEFAULT;
    width = parseFloat(width) + DIMENSIONDEFAULT;

    let heightM = height;
    let widthM = width;
    let margin = 0;
    let styleMargin = getComputedStyle(layoutMargin).height;
    let styleImg = getComputedStyle(layoutImg).height;
    styleMargin = parseInt(styleMargin.replace("px",""));
    styleImg = parseInt(styleImg.replace("px",""));
    if(styleMargin > styleImg){
        heightM = heightM +(margin*10);
        widthM = widthM +(margin*10); 
    }

    layoutImg.style.height = `${height}px`;
    layoutImg.style.width = `${width}px`;
    layoutMargin.style.height = `${heightM}px`;
    layoutMargin.style.width = `${widthM}px`;
}
function calcularMarco(id=null){
    if(!document.querySelector(".frame--item.element--active")){
        return false;
    }
    if(id == null){
        id = document.querySelector(".frame--item.element--active").getAttribute("data-id");
    }
    let margin = 0;
    let styleFrame = 1;
    let height = intHeight.value;
    let width = intWidth.value;
    let type = document.querySelector("#enmarcarTipo").getAttribute("data-id");

    let formData = new FormData();
    formData.append("height",height);
    formData.append("width",width);
    formData.append("style",styleFrame);
    formData.append("margin",margin);
    formData.append("id",id);
    formData.append("type",type);

    request(base_url+"/enmarcar/calcularMarcoTotal",formData,"post").then(function(objData){
        if(objData.status){
            let data = objData.data;
            let borderImage = `url(${base_url}/assets/images/uploads/${data.frame}) 40% repeat`;
            document.querySelector("#reference").innerHTML = "Ref: "+data.reference;
            document.querySelector(".totalFrame").innerHTML = data.total.format;
            layoutMargin.style.borderImage= borderImage;
            layoutMargin.style.borderWidth = (data.waste/1.5)+"px";
            layoutMargin.style.borderImageOutset = (data.waste/1.5)+"px";
        }
    });
}
