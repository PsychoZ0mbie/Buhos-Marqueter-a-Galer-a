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
const marginRange = document.querySelector("#marginRange");
const colorMargin = document.querySelectorAll(".color--margin");
const colorBorder = document.querySelectorAll(".color--border");
const selectStyle = document.querySelector("#selectStyle");
const optionsCustom = document.querySelectorAll(".option--custom");
const btnBack = document.querySelector("#btnBack");
const btnNext = document.querySelector("#btnNext");
const pages = document.querySelectorAll(".page");
const containerFrames = document.querySelector(".select--frames");
const searchFrame = document.querySelector("#searchFrame");
const sortFrame = document.querySelector("#sortFrame");

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
    }else if(intHeight.value >= 200.0){
        intHeight.value = 200.0;
    }
    calcularMarco();
    resizeFrame(intWidth.value, intHeight.value);
    if(intHeight.value !="" && intWidth.value!=""){
        btnNext.classList.remove("d-none");
    }
});
intWidth.addEventListener("change",function(){
    if(intWidth.value <= 10.0){
        intWidth.value = 10.0;
    }else if(intWidth.value >= 200.0){
        intWidth.value = 200.0;
    }
    calcularMarco();
    resizeFrame(intWidth.value, intHeight.value);
    if(intHeight.value !="" && intWidth.value!=""){
        btnNext.classList.remove("d-none");
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
    request(base_url+"/enmarcar/search/"+searchFrame.value,"","get").then(function(objData){
        if(objData.status){
            containerFrames.innerHTML = objData.data;
        }
    });
});


sortFrame.addEventListener("change",function(){
    request(base_url+"/enmarcar/sort/"+sortFrame.value,"","get").then(function(objData){
        if(objData.status){
            containerFrames.innerHTML = objData.data;
        }
    });
});

containerFrames.addEventListener("click",function(e){
    let id = e.target.parentElement.getAttribute("data-id");
    calcularMarco(id);
    
});
marginRange.addEventListener("input",function(){
    customMargin(marginRange.value);
    calcularMarco();
});
//[Select style]
selectStyle.addEventListener("change",function(){
    selectStyleFrame(selectStyle.value);
    calcularMarco();
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
    let margin = parseInt(marginRange.value);
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
function customMargin(margin){
    marginRange.value = margin;
    let marginHeight = (parseFloat(intHeight.value)+DIMENSIONDEFAULT) + (margin*10);
    let marginWidth = (parseFloat(intWidth.value)+DIMENSIONDEFAULT) + (margin*10);
    layoutMargin.style.height = `${marginHeight}px`;
    layoutMargin.style.width = `${marginWidth}px`;
    document.querySelector("#marginData").innerHTML= margin+" cm";
}
function selectStyleFrame(option){
    document.querySelector(".borderColor").classList.remove("d-none");
    if(option == 1){
        optionsCustom[0].classList.add("d-none");
        optionsCustom[1].classList.add("d-none");
        customMargin(0);
        selectColors();
    }else if(option == 2 || option == 4){
        optionsCustom[0].classList.remove("d-none");
        optionsCustom[1].classList.add("d-none");
        customMargin(1);
        if(option==2){
            selectColors(1);
        }else{
            selectColors(2);
        }
    }else if(option == 3){
        optionsCustom[0].classList.remove("d-none");
        optionsCustom[1].classList.add("d-none");
        document.querySelector(".borderColor").classList.add("d-none");
        customMargin(1);
        selectColors(0);
    }else{
        customMargin(0);
        selectColors();
        optionsCustom[0].classList.add("d-none");
        optionsCustom[1].classList.remove("d-none");
    }
}
function selectColors(option = null){
    if(option == 1){
        layoutImg.style.border="5px solid #fff";
        layoutMargin.style.backgroundColor="#000";
    }else if(option == 2){
        layoutImg.style.border="10px solid #fff";
        layoutMargin.style.backgroundColor="#000";
    }else{
        layoutImg.style.border="none";
        layoutMargin.style.backgroundColor="#000";
    }

    for (let i = 0; i < colorMargin.length; i++) {
        let margin = colorMargin[i];
        let border = colorBorder[i];

        if(margin.className.includes("element--active")){
            margin.classList.remove("element--active");
        }
        
        if(border.className.includes("element--active")){
            border.classList.remove("element--active");
        }
        margin.addEventListener("click",function(){
            let bg = getComputedStyle(margin.children[0]).backgroundColor;
            layoutMargin.style.backgroundColor=bg;
        });
        border.addEventListener("click",function(){
            let bc = getComputedStyle(border.children[0]).backgroundColor;
            layoutImg.style.borderColor=bc;
        });
    }
}
function calcularMarco(id=null){
    if(!document.querySelector(".frame--item.element--active")){
        return false;
    }
    if(id == null){
        id = document.querySelector(".frame--item.element--active").getAttribute("data-id");
    }
    let margin = marginRange.value;
    let styleFrame = selectStyle.value;
    let height = intHeight.value;
    let width = intWidth.value;

    let formData = new FormData();
    formData.append("height",height);
    formData.append("width",width);
    formData.append("style",styleFrame);
    formData.append("margin",margin);
    formData.append("id",id);

    request(base_url+"/enmarcar/calcularMarcoTotal",formData,"post").then(function(objData){
        if(objData.status){
            let data = objData.data;
            let borderImage = `url(${base_url}/assets/images/uploads/${data.frame}) 40% repeat`;
            document.querySelector("#reference").innerHTML = "Ref: "+data.reference;
            document.querySelectorAll(".totalFrame")[0].innerHTML = data.total.format;
            document.querySelectorAll(".totalFrame")[1].innerHTML = data.total.format;
            layoutMargin.style.borderImage= borderImage;
            layoutMargin.style.borderWidth = (data.waste/1.5)+"px";
            layoutMargin.style.borderImageOutset = (data.waste/1.5)+"px";
        }
    });
}
function uploadImg(img,location){
    let imgUpload = img.value;
    let fileUpload = img.files;
    let type = fileUpload[0].type;
    if(type != "image/png" && type != "image/jpg" && type != "image/jpeg" && type != "image/gif"){
        imgUpload ="";
        Swal.fire("Error","Solo se permite imágenes.","error");
    }else{
        let objectUrl = window.URL || window.webkitURL;
        let route = objectUrl.createObjectURL(fileUpload[0]);
        document.querySelector(location).setAttribute("src",route);
    }
}