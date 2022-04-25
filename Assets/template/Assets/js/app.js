'use strict'
let loading = document.querySelector("#divLoading");
if(document.querySelector("#medidas")){
    let dimensionDefault = 200;
    let img = document.querySelector("#measuresImg");
    let imgLocation = ".measures__frame img";
    img.addEventListener("change",function(){
        uploadImg(img,imgLocation);
    });

    let inputMeasure = document.querySelectorAll(".btn_number div.d-flex");
    let measureFrame = document.querySelector(".measures__frame");
    let measureImg = document.querySelector(".measures__frame img");
    let measureMargin = document.querySelector(".measures__margin");
    let measureContainer = document.querySelector(".measures__container");
    
    for (let i = 0; i < inputMeasure.length; i++) {
    
        let event = inputMeasure[i];
    
        event.addEventListener("click",function(e){
            
            let element = e.target;
            let inputValue = element.parentElement.children[1];
            let btn = element.getAttribute("name");
            let value = inputValue.value;
            if(value < 10 || value > 200){
                Swal.fire("Error","Las dimensiones deben ser mínimo de 20 cm o máximo 200 cm!","error");
                inputValue.value = 20;
                return false;
            }

            if(btn==="decrement"){
                inputValue.value--;
            }else if(btn==="increment"){
                inputValue.value++;
            }
            

            value = String(parseInt(inputValue.value)+dimensionDefault)+"px";
            if(i==0){
                //measureImg.style.height = value;
                measureFrame.style.height = value;
                measureMargin.style.height = value;
            }else{
                //measureImg.style.width = value;
                measureFrame.style.width = value;
                measureMargin.style.width = value;
            }
        })
    
        event.addEventListener("change",function(e){

            if(e.target.value < 10 || e.target.value > 200){
                Swal.fire("Error","Las dimensiones deben ser mínimo de 20 cm o máximo 200 cm!","error");
                e.target.value = 10;
                return false;
            }

            let inputValue = String(parseInt(e.target.value)+dimensionDefault)+"px";
            if(i==0){
                //measureImg.style.height = inputValue;
                measureFrame.style.height = inputValue;
                measureMargin.style.height = inputValue;
            }else{
                //measureImg.style.width = inputValue;
                measureFrame.style.width = inputValue;
                measureMargin.style.width = inputValue;
            }
        })
    }
    
    let btnContinue = document.querySelector("#btnCustom");
    btnContinue.addEventListener("click",function(){
        document.querySelector(".measures__dimensions").classList.add("d-none");
        document.querySelector(".measures__custom").classList.remove("d-none");
    })

    let selectType = document.querySelector("#selectType");
    selectType.addEventListener("change",function(){

        let url = base_url+"/tienda/getMuestras/"+selectType.value;
        loading.style.display="flex";
        request(url,"",2).then(function(objData){
            loading.style.display="none";
            let parent = document.querySelector(".accordion-body");
            let child = document.querySelector(".scroll_list");
            let fragment = document.createDocumentFragment();

            let html ="";
            for (let i = 0; i < objData.length; i++) {
                html += `
                <div class="measures__item" data-id="${objData[i]['idproduct']}" data-frame="${objData[i]['url'][1]}" data-border="${objData[i]['waste']}">
                    <img src="${objData[i]['url'][0]}" alt="">
                </div>
                `
            }
            child.innerHTML = html;
            fragment.appendChild(child);
            parent.appendChild(fragment);
        });
    })
    //let paddingImg;
    let selectFrame = document.querySelector("#selectFrames");
    selectFrame.addEventListener("click",function(e){
        
        //let idimage = e.target.parentElement.getAttribute("data-id");
        let image = e.target.parentElement.getAttribute("data-frame");
        let border = parseInt(e.target.parentElement.getAttribute("data-border"));
        if(image != null){

            let borderStyle = border*0.5; //Cálculo ancho de moldura
            let borderOutset = borderStyle*1.01; // Cálculo separación entre el borde de imágen y el contenedor
            //paddingImg = borderStyle*0.40; // Cálculo de relleno de imágen con respecto al borde
            
            borderOutset = String(borderOutset)+"px";
            borderStyle = String(borderStyle)+"px";
            //paddingImg = String(paddingImg)+"px";

            let url = base_url+"/Assets/images/uploads/"+image;
            url= "url("+url+") 40% repeat";
            

            measureMargin.style.border = borderStyle+" solid #000";
            measureMargin.style.borderImage= url;
            measureMargin.style.borderImageOutset = borderOutset;
            //measureImg.style.padding = paddingImg;
            
        }
    })

    //Selección de margen entre la imágen y el marco

    let selectMargin = document.querySelector("#selectMargin");
    selectMargin.addEventListener("change",function(){

        let rangeFrame = document.querySelector("#rangeFrame");
        let height = document.querySelector("#intHeight").value;
        let width = document.querySelector("#intWidth").value;
        
        if(selectMargin.value == 1){

            measureMargin.style.background ="transparent";
            let heightMargin = String(parseInt(height)+dimensionDefault)+"px";
            let widthMargin = String(parseInt(width)+dimensionDefault)+"px";

            measureMargin.style.height = heightMargin;
            measureMargin.style.width = widthMargin;
            
            document.querySelector(".rangeInfo").classList.add("d-none");
            document.querySelector(".color_margin").classList.add("d-none");

        }else if(selectMargin.value == 2){
            
            measureMargin.style.background ="#fff";
            document.querySelector(".rangeInfo").classList.remove("d-none");
            document.querySelector(".color_margin").classList.remove("d-none");
            rangeFrame.addEventListener("input",function(){

                let rangeValue = parseInt(rangeFrame.value);
                document.querySelector("#rangeData").innerHTML = rangeValue+" cm";

                let heightMargin = String(parseInt(height)+dimensionDefault+rangeValue*10)+"px";
                let widthMargin = String(parseInt(width)+dimensionDefault+rangeValue*10)+"px";

                measureMargin.style.height = heightMargin;
                measureMargin.style.width = widthMargin;

                let elementsColor = document.querySelectorAll(".color_margin_item");
                for (let i = 0; i < elementsColor.length; i++) {
                    let element = elementsColor[i];
                    element.addEventListener("click",function(e){
                        let colorBackground = window.getComputedStyle(element).backgroundColor;
                        measureMargin.style.background = colorBackground;
                    })
                }
            })

        }else if(selectMargin.value == 3){

            document.querySelector(".rangeInfo").classList.remove("d-none");
            document.querySelector(".color_margin").classList.add("d-none");
            measureMargin.style.background ="#F3E5AB";

            rangeFrame.addEventListener("input",function(){
                let rangeValue = parseInt(rangeFrame.value);
                document.querySelector("#rangeData").innerHTML = rangeValue+" cm";

                let heightMargin = String(parseInt(height)+dimensionDefault+rangeValue*10)+"px";
                let widthMargin = String(parseInt(width)+dimensionDefault+rangeValue*10)+"px";

                measureMargin.style.height = heightMargin;
                measureMargin.style.width = widthMargin;
            })
        }
    });

    

    measureContainer.addEventListener("mousemove",function(e){
        let clientX = e.clientX-measureContainer.offsetLeft;
        let clientY = e.clientY-measureContainer.offsetTop;
        let mWidth = measureContainer.offsetWidth;
        let mheight = measureContainer.offsetHeight;

        clientX = clientX / mWidth * 100;
        clientY = clientY / mheight * 100;

        measureMargin.style.transform = "translate(-"+clientX+"%,-"+clientY+"%) scale(2)";
        measureFrame.style.transform = "translate(-"+clientX+"%,-"+clientY+"%) scale(2)";
        //measureImg.style.transform = "translate(-50%,-50%) scale(2)";
    })
    measureContainer.addEventListener("mouseleave",function(){
        measureMargin.style.transform = "translate(-50%,-50%) scale(1)";
        measureFrame.style.transform = "translate(-50%,-50%) scale(1)";
        //measureImg.style.transform = "translate(-50%,-50%) scale(1)";
    })

}


