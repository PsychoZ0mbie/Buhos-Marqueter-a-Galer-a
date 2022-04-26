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
    let measureMargin = document.querySelector(".measures__margin");
    let measureContainer = document.querySelector(".measures__container");

    let intHeight;
    let intWidth;
    
    for (let i = 0; i < inputMeasure.length; i++) {
    
        let event = inputMeasure[i];
        event.addEventListener("change",function(e){

            if(e.target.value < 10 || e.target.value > 200){
                Swal.fire("Error","Las dimensiones deben ser mínimo de 10 cm o máximo 200 cm!","error");
                e.target.value = 10;
                return false;
            }

            let inputValue = String(parseInt(e.target.value)+dimensionDefault)+"px";
            if(i==0){
                measureFrame.style.height = inputValue;
                measureMargin.style.height = inputValue;
            }else{
                measureFrame.style.width = inputValue;
                measureMargin.style.width = inputValue;
            }
        })
    }
    
    //Pages

    let btnNext = document.querySelector("#btnNext");
    let btnPrevious = document.querySelector("#btnPrevious");

    btnNext.addEventListener("click",function(){
        if( document.querySelectorAll(".page.active")){
            let pages = document.querySelectorAll(".page.active");
    
            for (let i = 0; i < pages.length; i++) {
    
                let nextPage = pages[i].nextElementSibling;
                let previousPage = nextPage.previousElementSibling;
                
                nextPage.classList.add("active");
                nextPage.classList.remove("d-none");

                previousPage.classList.remove("active");
                previousPage.classList.add("d-none");
                
            }
        }
    })
    
    btnPrevious.addEventListener("click",function(){
        if( document.querySelectorAll(".page.active")){
            let pages = document.querySelectorAll(".page.active");
    
            for (let i = 0; i < pages.length; i++) {

                let previousPage = pages[i].previousElementSibling;
                let nextPage = previousPage.nextElementSibling;
                
                previousPage.classList.add("active");
                previousPage.classList.remove("d-none");

                nextPage.classList.remove("active");
                nextPage.classList.add("d-none");
                
            }
        }
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
    let selectFrame = document.querySelector("#selectFrames");
    selectFrame.addEventListener("click",function(e){
        
        //let idimage = e.target.parentElement.getAttribute("data-id");
        let image = e.target.parentElement.getAttribute("data-frame");
        let border = parseInt(e.target.parentElement.getAttribute("data-border"));
        if(image != null){

            let borderStyle = border*0.5; //Cálculo ancho de moldura
            let borderOutset = borderStyle*1.01; // Cálculo separación entre el borde de imágen y el contenedor
            
            borderOutset = String(borderOutset)+"px";
            borderStyle = String(borderStyle)+"px";

            let url = base_url+"/Assets/images/uploads/"+image;
            url= "url("+url+") 40% repeat";
            

            measureMargin.style.border = borderStyle+" solid #000";
            measureMargin.style.borderImage= url;
            measureMargin.style.borderImageOutset = borderOutset;
            
        }
    })

    //Selección de margen entre la imágen y el marco

    let selectMargin = document.querySelector("#selectMargin");
    selectMargin.addEventListener("change",function(){

        let rangeFrame = document.querySelector("#rangeFrame");
        let height = document.querySelector("#intHeight").value;
        let width = document.querySelector("#intWidth").value;
        let selectBorder = document.querySelector("#selectBorder");

        intHeight = height;
        intWidth = width;
        console.log(intHeight)
        console.log(intWidth);

        if(selectMargin.value == 1){

            measureMargin.style.background ="transparent";
            measureFrame.style.border = "none";
            let heightMargin = String(parseInt(height)+dimensionDefault)+"px";
            let widthMargin = String(parseInt(width)+dimensionDefault)+"px";

            measureMargin.style.height = heightMargin;
            measureMargin.style.width = widthMargin;

            document.querySelector(".rangeInfo").classList.add("d-none");
            document.querySelector(".color_margin").classList.add("d-none");

            selectBorder.classList.add("d-none");
            document.querySelector(".color_border").classList.add("d-none");

        }else if(selectMargin.value == 2){
            
            measureMargin.style.background ="#fff";
            document.querySelector(".rangeInfo").classList.remove("d-none");
            document.querySelector(".color_margin").classList.remove("d-none");

            selectBorder.classList.remove("d-none");
            

            rangeFrame.addEventListener("input",function(){

                let rangeValue = parseInt(rangeFrame.value);
                document.querySelector("#rangeData").innerHTML = rangeValue+" cm";

                let heightMargin = String(parseInt(height)+dimensionDefault+rangeValue*10)+"px";
                let widthMargin = String(parseInt(width)+dimensionDefault+rangeValue*10)+"px";

                measureMargin.style.height = heightMargin;
                measureMargin.style.width = widthMargin;

                let marginColor = document.querySelectorAll(".color_margin_item");
                for (let i = 0; i < marginColor.length; i++) {
                    let element = marginColor[i];
                    element.addEventListener("click",function(e){
                        let color = window.getComputedStyle(element).backgroundColor;
                        measureMargin.style.background = color;
                    })
                }
            })

            selectBorder.addEventListener("change",function(){
                if(selectBorder.value == 1){
                    document.querySelector(".color_border").classList.add("d-none");
                    measureFrame.style.border = "none";
                }else{

                    document.querySelector(".color_border").classList.remove("d-none");
                    let borderColor = document.querySelectorAll(".color_border_item");
                    for (let i = 0; i < borderColor.length; i++) {
                        let element = borderColor[i];
                        element.addEventListener("click",function(e){
                            let color = window.getComputedStyle(element).backgroundColor;
                            measureFrame.style.border = "5px solid "+color;
                        })
                    }

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
    })
    measureContainer.addEventListener("mouseleave",function(){
        measureMargin.style.transform = "translate(-50%,-50%) scale(1)";
        measureFrame.style.transform = "translate(-50%,-50%) scale(1)";
    })

}


