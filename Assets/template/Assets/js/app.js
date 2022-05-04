'use strict'
let loading = document.querySelector("#divLoading");

/*********************************************************************Frame page************************************************************************ */

if(document.querySelector("#marqueteria")){
    /******************************Dimensions frame******************************** */
    let dimensionDefault = 200;
    if(document.querySelector("#measuresImg")){
        let img = document.querySelector("#measuresImg");
        let imgLocation = ".measures__frame img";
        img.addEventListener("change",function(){
            uploadImg(img,imgLocation);
        });
    }

    let inputMeasure = document.querySelectorAll(".btn_number div.d-flex");
    let measureFrame = document.querySelector(".measures__frame");
    let measureMargin = document.querySelector(".measures__margin");
    let measureContainer = document.querySelector(".measures__container");
    let rangeFrame = document.querySelector("#rangeFrame");
    let selectBorder = document.querySelector("#selectBorder");
    let selectMargin = document.querySelector("#selectMargin");
    let btnNext = document.querySelector("#btnNext");
    let btnPrevious = document.querySelector("#btnPrevious");

    btnNext.classList.add("d-none");
    for (let i = 0; i < inputMeasure.length; i++) {
    
        let event = inputMeasure[i];
        event.addEventListener("change",function(e){

            btnNext.classList.remove("d-none");

            measureFrame.style.border="none";
            measureMargin.style.border ="none";
            measureMargin.style.background ="none";
            
            if(e.target.value < 10 || e.target.value > 200){
                Swal.fire("Error","Las dimensiones deben ser mínimo de 10 cm o máximo 200 cm!","error");
                e.target.value = 10;
                return false;
            }
            document.querySelector("#txtMedidasImg").innerHTML = document.querySelector("#intHeight").value+"cm X "+document.querySelector("#intWidth").value+"cm";
            
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

    
    /******************************Custom frame******************************** */
    let selectType = document.querySelector("#selectType");
    let selectGlass = document.querySelector("#selectGlass");
    selectType.addEventListener("change",function(){

        let textType = selectType.options[selectType.selectedIndex].text;
        

        if(selectType.value != 0){
            let url = base_url+"/tienda/getMuestras/"+selectType.value;

            measureFrame.style.border="none";
            measureMargin.style.border ="none";
            measureMargin.style.background ="none";

            document.querySelector(".measures__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$0 COP`;
            document.querySelector(".measures__margin__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$$0 COP`;
            document.querySelector(".measures__border__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$$0 COP`;
            document.querySelector("#txtPrice").innerHTML = "$0 COP";
            document.querySelector("#txtMolduras").innerHTML = textType;

            
            loading.style.display="flex";
            request(url,"","get").then(function(objData){
                loading.style.display="none";
                let parent = document.querySelector(".scroll_list").parentElement;
                let child = document.querySelector(".scroll_list");
                let fragment = document.createDocumentFragment();
    
                let html ="";
                for (let i = 0; i < objData.length; i++) {
                    html += `
                    <div class="measures__item" id="${objData[i]['idproduct']}" data-frame="${objData[i]['url'][1]}" data-border="${objData[i]['waste']}" title="${objData[i]['title']}">
                        <img src="${objData[i]['url'][0]}" alt="">
                    </div>
                    `
                }
                child.innerHTML = html;
                fragment.appendChild(child);
                parent.appendChild(fragment);

                let measureItems = document.querySelectorAll(".measures__item");
                for (let i = 0; i < measureItems.length; i++) {
                    let item = measureItems[i];
                    item.addEventListener("click",function(e){
                        let measureItem = e.target.parentElement;
                        for (let j = 0; j < measureItems.length; j++) {
                            if(measureItems[j].classList.length > 1){
                                if(measureItem != measureItems[j]){
                                    measureItems[j].classList.remove("active");
                                }
                            }else{
                                measureItem.classList.add("active");
                            }
                        }
                        let id = measureItem.getAttribute("id");
                        let image = measureItem.getAttribute("data-frame");
                        let reference = measureItem.getAttribute("title");
                        let border = parseInt(measureItem.getAttribute("data-border"));
                        document.querySelector("#selectFrame").innerHTML = textType+" - "+reference;
                        if(image != null){
    
                            let urlRequest = base_url+"/tienda/calcularMarco";
                            let formData = new FormData();
                            let height = parseInt(document.querySelector("#intHeight").value);
                            let width = parseInt(document.querySelector("#intWidth").value);
                
                            
    
                            let borderStyle = border*0.5; //Cálculo ancho de moldura
                            let borderOutset = borderStyle*1.01; // Cálculo separación entre el borde de imágen y el contenedor
                            borderOutset = String(borderOutset)+"px";
                            borderStyle = String(borderStyle)+"px";
            
                            document.querySelector("#txtRef").innerHTML = reference;
                            let url = base_url+"/Assets/images/uploads/"+image;
            
                            url= "url("+url+") 40% repeat";
                            
            
                            measureMargin.style.border = borderStyle+" solid #000";
                            measureMargin.style.borderImage= url;
                            measureMargin.style.borderImageOutset = borderOutset;

                            selectMargin.value = 1;
                            selectBorder.value = 1;
                            selectGlass.value = 1;
                            rangeFrame.value = 0;
                            //let selectedElement = document.querySelector(".measures__item.active");
                            let heightMargin = String(height+dimensionDefault)+"px";
                            let widthMargin = String(width+dimensionDefault)+"px";

                            measureFrame.style.border = "none";
                            measureFrame.style.border = "none";

                            measureMargin.style.background ="transparent";
                            measureMargin.style.height = heightMargin;
                            measureMargin.style.width = widthMargin;

                            document.querySelector("#txtMargen").innerHTML = "Sin margen";
                            document.querySelector("#txtBorde").innerHTML = "Sin borde";
                            document.querySelector("#txtVidrio").innerHTML = "Sin Vidrio";
                            document.querySelector("#txtMargenMedida").innerHTML = "0 cm";
                            document.querySelector("#txtMedidasMarco").innerHTML = height+"cm X "+width+"cm";
                            document.querySelector(".rangeInfo").classList.add("d-none");
                            document.querySelector(".color_margin").classList.add("d-none");
                            document.querySelector("#border").classList.add("d-none");

                            formData.append("id",id);
                            formData.append("height",height);
                            formData.append("width",width);
                            formData.append("glass",selectGlass);
                
                            request(urlRequest,formData,"post").then(function(objData){
                                document.querySelector(".measures__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$`+formatNum(objData,".")+" COP";
                                document.querySelector(".measures__margin__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$`+formatNum(objData,".")+" COP";
                                document.querySelector(".measures__border__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$`+formatNum(objData,".")+" COP";
                                document.querySelector("#txtPrice").innerHTML = "$"+formatNum(objData,".")+" COP";
                            });
                        }
    
                    });
                }
            });
        }

    })

    /******************************Margin selection******************************** */


    document.querySelector("#txtMargen").innerHTML = "Sin margen";
    document.querySelector("#txtBorde").innerHTML = "Sin borde";
    document.querySelector("#txtMedidasMarco").innerHTML = document.querySelector("#intHeight").value+"cm X "+document.querySelector("#intWidth").value+"cm";

    selectMargin.addEventListener("change",function(){

        let textType = selectMargin.options[selectMargin.selectedIndex].text;
        //let textGlass = selectGlass.options[selectGlass.selectedIndex].text;
        let urlRequest = base_url+"/tienda/calcularMarco";
        let height = parseInt(document.querySelector("#intHeight").value);
        let width = parseInt(document.querySelector("#intWidth").value);

        document.querySelector("#txtMargen").innerHTML= textType;

        if(selectMargin.value == 1){
            
            let selectedElement = document.querySelector(".measures__item.active");
            let id = selectedElement.getAttribute("id");
            let margin = parseInt(rangeFrame.value);
            let heightMargin = String(height+dimensionDefault)+"px";
            let widthMargin = String(width+dimensionDefault)+"px";
            selectBorder.value = 1;
            selectGlass.value= 1;
            rangeFrame.value = 0;
            
            measureFrame.style.border = "none";
            measureFrame.style.border = "none";

            measureMargin.style.background ="transparent";
            measureMargin.style.height = heightMargin;
            measureMargin.style.width = widthMargin;

            
            
            
            let formData = new FormData();
            formData.append("id",id);
            formData.append("height",height);
            formData.append("width",width);
            formData.append("margin",margin);
            formData.append("glass",selectGlass.value);

            request(urlRequest,formData,"post").then(function(objData){
                document.querySelector(".measures__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$`+formatNum(objData,".")+" COP";
                document.querySelector(".measures__margin__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$`+formatNum(objData,".")+" COP";
                document.querySelector(".measures__border__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$`+formatNum(objData,".")+" COP";
                document.querySelector("#txtPrice").innerHTML = "$"+formatNum(objData,".")+" COP";
            });

            document.querySelector(".rangeInfo").classList.add("d-none");
            document.querySelector(".color_margin").classList.add("d-none");
            document.querySelector("#border").classList.add("d-none");
            document.querySelector("#txtBorde").innerHTML = selectBorder.options[selectBorder.selectedIndex].text;
            document.querySelector("#txtVidrio").innerHTML = selectGlass.options[selectGlass.selectedIndex].text;

        }else if(selectMargin.value == 2){
            selectBorder.value = 1;
            selectGlass.value= 1;
            measureMargin.style.height = String(height+dimensionDefault)+"px";
            measureMargin.style.width = String(width+dimensionDefault)+"px";
            measureFrame.style.border = "none";
            measureMargin.style.background ="#fff";
            rangeFrame.value = 0;

            
            document.querySelector("#txtMedidasMarco").innerHTML = height+"cm X "+width+"cm";
            document.querySelector("#rangeData").innerHTML = 0+" cm";
            document.querySelector(".rangeInfo").classList.remove("d-none");
            document.querySelector(".color_margin").classList.remove("d-none");
            document.querySelector(".color_border").classList.add("d-none");
            document.querySelector("#txtBorde").innerHTML = selectBorder.options[selectBorder.selectedIndex].text;
            document.querySelector("#txtVidrio").innerHTML = selectGlass.options[selectGlass.selectedIndex].text;
            document.querySelector(".measures__margin__custom .price").innerHTML = document.querySelector(".measures__custom .price").innerHTML;
            document.querySelector(".measures__border__custom .price").innerHTML = document.querySelector(".measures__custom .price").innerHTML;
            document.querySelector("#txtPrice").innerHTML =  document.querySelector(".measures__custom .price").innerHTML;
            document.querySelector("#border").classList.remove("d-none");

            let url = base_url+"/tienda/getColor";
            request(url,"","get").then(function(objData){
                let parentMargin = document.querySelector(".color_margin");
                let childMargin = document.querySelector(".color_margin .scroll_listX");
                let fragmentMargin = document.createDocumentFragment();
                let htmlMargin ="";

                for (let i = 0; i < objData.length; i++) {
                    htmlMargin += `
                    <div class="color_block color_margin_item" style="background: #${objData[i]['hex']};" data-id="${objData[i]['id']}" 
                    title="${objData[i]['title']}" data-color="${objData[i]['hex']}">
                    </div>
                    `
                }
                childMargin.innerHTML = htmlMargin;
                fragmentMargin.appendChild(childMargin);
                parentMargin.appendChild(fragmentMargin);

            });
            
            rangeFrame.addEventListener("input",function(){

                let selectedElement = document.querySelector(".measures__item.active");
                let id = selectedElement.getAttribute("id");
                let margin = parseInt(rangeFrame.value);
                let heightMargin = String(height+dimensionDefault+margin*10)+"px";
                let widthMargin = String(width+dimensionDefault+margin*10)+"px";

                

                measureMargin.style.height = heightMargin;
                measureMargin.style.width = widthMargin;
                measureFrame.style.border = "none";

                selectBorder.value = 1;
                selectGlass.value= 1;

                document.querySelector("#rangeData").innerHTML = margin+" cm";
                document.querySelector("#txtMargenMedida").innerHTML  = margin+" cm";
                document.querySelector("#txtMedidasMarco").innerHTML = (height+(margin*2))+"cm X "+(width+(margin*2))+"cm";

                let formData = new FormData();
                formData.append("id",id);
                formData.append("type",selectMargin.value);
                formData.append("height",height);
                formData.append("width",width);
                formData.append("margin",margin);
                formData.append("glass",selectGlass.value);
                request(urlRequest,formData,"post").then(function(objData){
                    document.querySelector(".measures__margin__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$`+formatNum(objData,".")+" COP";
                    document.querySelector(".measures__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$`+formatNum(objData,".")+" COP";
                    document.querySelector(".measures__border__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$`+formatNum(objData,".")+" COP";
                    document.querySelector("#txtPrice").innerHTML = "$"+formatNum(objData,".")+" COP";
                });
                
                let marginColor = document.querySelectorAll(".color_margin_item");
                for (let i = 0; i < marginColor.length; i++) {
                    let element = marginColor[i];
                    element.addEventListener("click",function(e){
                        //document.querySelector("#txtMargen").innerHTML = textType;
                        let color = "#"+element.getAttribute("data-color");
                        let title = element.getAttribute("title");
                        document.querySelector("#txtMargen").innerHTML = textType+" - "+title;
                        document.querySelector("#selectedMarginColor").innerHTML = title;
                        measureMargin.style.background = color;
                    })
                }
            })

        }else if(selectMargin.value == 3){

            measureMargin.style.height = String(height+dimensionDefault)+"px";
            measureMargin.style.width = String(width+dimensionDefault)+"px";
            measureMargin.style.background ="#f5f5dc";
            measureFrame.style.border = "none";
            rangeFrame.value = 0;
            selectBorder.value = 1;
            selectGlass.value= 1;

            document.querySelector("#txtPrice").innerHTML =  document.querySelector(".measures__custom .price").innerHTML;
            document.querySelector("#rangeData").innerHTML = "0 cm";
            document.querySelector("#txtMargen").innerHTML = "Passepartout";
            document.querySelector("#txtMargenMedida").innerHTML = "0 cm";
            document.querySelector(".rangeInfo").classList.remove("d-none");
            document.querySelector(".color_margin").classList.add("d-none");
            document.querySelector(".color_border").classList.add("d-none");
            document.querySelector("#txtBorde").innerHTML = selectBorder.options[selectBorder.selectedIndex].text;
            document.querySelector("#txtVidrio").innerHTML = selectGlass.options[selectGlass.selectedIndex].text;
            document.querySelector("#border").classList.remove("d-none");
            document.querySelector(".measures__margin__custom .price").innerHTML = document.querySelector(".measures__custom .price").innerHTML;
            document.querySelector(".measures__border__custom .price").innerHTML = document.querySelector(".measures__custom .price").innerHTML;

            rangeFrame.addEventListener("input",function(){

                let selectedElement = document.querySelector(".measures__item.active");
                let idP = selectedElement.getAttribute("id");
                let margin = parseInt(rangeFrame.value);
                let heightMargin = String(height+dimensionDefault+margin*10)+"px";
                let widthMargin = String(width+dimensionDefault+margin*10)+"px";
                let formData = new FormData();

                measureMargin.style.height = heightMargin;
                measureMargin.style.width = widthMargin;
                measureFrame.style.border = "none";

                selectBorder.value = 1;
                selectGlass.value = 1;

                formData.append("id",idP);
                formData.append("type",selectMargin.value);
                formData.append("height",height);
                formData.append("width",width);
                formData.append("margin",margin);
                formData.append("glass",selectGlass.value);
                
                
                request(urlRequest,formData,"post").then(function(objData){
                    document.querySelector(".measures__margin__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$`+formatNum(objData,".")+" COP";
                    document.querySelector(".measures__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$`+formatNum(objData,".")+" COP";
                    document.querySelector(".measures__border__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$`+formatNum(objData,".")+" COP";
                    document.querySelector("#txtPrice").innerHTML = "$"+formatNum(objData,".")+" COP";
                });

                document.querySelector("#rangeData").innerHTML = margin+" cm";
                document.querySelector("#txtMargenMedida").innerHTML  = margin+" cm";
                document.querySelector("#txtMedidasMarco").innerHTML = (height+(margin*2))+"cm X "+(width+(margin*2))+"cm";
                document.querySelector("#txtBorde").innerHTML = "Sin borde";
                //document.querySelector("#txtVidrio").innerHTML = "Sin Vidrio";
    
            })
        }

        selectBorder.addEventListener("change",function(){
            
            let textBorder = selectBorder.options[selectBorder.selectedIndex].text;
            
            if(selectBorder.value == 1){

                measureFrame.style.border = "none";

                let selectedElement = document.querySelector(".measures__item.active");
                let id = selectedElement.getAttribute("id");
                let margin = parseInt(rangeFrame.value);
                let formData = new FormData();

                formData.append("id",id);
                formData.append("type",selectMargin.value);
                formData.append("height",height);
                formData.append("width",width);
                formData.append("margin",margin);
                formData.append("glass",selectGlass.value);
                    
                request(urlRequest,formData,"post").then(function(objData){
                    document.querySelector(".measures__border__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$`+formatNum(objData,".")+" COP";
                    document.querySelector(".measures__margin__custom .price").innerHTML = document.querySelector(".measures__border__custom .price").innerHTML;
                    document.querySelector(".measures__custom .price").innerHTML = document.querySelector(".measures__border__custom .price").innerHTML;
                    document.querySelector("#txtPrice").innerHTML = "$"+formatNum(objData,".")+" COP";
                });

                document.querySelector("#txtBorde").innerHTML = textBorder;
                document.querySelector(".color_border").classList.add("d-none");

            }else{

                let url = base_url+"/tienda/getColor";

                measureFrame.style.border = "none";

                document.querySelector(".color_border").classList.remove("d-none");

                request(url,"","get").then(function(objData){
                    loading.style.display="none";
                    let parentBorder = document.querySelector(".color_border");
                    let childBorder = document.querySelector(".color_border .scroll_listX");
                    let fragmentBorder = document.createDocumentFragment();
                    let htmlBorder="";
    
                    for (let i = 0; i < objData.length; i++) {
    
                        htmlBorder += `
                        <div class="color_block color_border_item" style="background: #${objData[i]['hex']};" data-id="${objData[i]['id']}" 
                        title="${objData[i]['title']}" data-color="${objData[i]['hex']}">
                        </div>
                        `
                    }
                    childBorder.innerHTML = htmlBorder;
                    fragmentBorder.appendChild(childBorder);
                    parentBorder.appendChild(fragmentBorder);

                    if(document.querySelectorAll(".color_border_item")){
                        let selectedElement = document.querySelector(".measures__item.active");
                        let id = selectedElement.getAttribute("id");
                        let borderColor = document.querySelector(".color_border .scroll_listX");
                        let margin = parseInt(rangeFrame.value);
                        let formData = new FormData();
        
                        formData.append("id",id);
                        formData.append("type",selectMargin.value);
                        formData.append("height",height);
                        formData.append("width",width);
                        formData.append("margin",margin);
                        formData.append("border",selectBorder.value);
                        formData.append("glass",selectGlass.value);
                            
                        request(urlRequest,formData,"post").then(function(objData){
                            document.querySelector(".measures__border__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$`+formatNum(objData,".")+" COP";
                            document.querySelector(".measures__margin__custom .price").innerHTML = document.querySelector(".measures__border__custom .price").innerHTML;
                            document.querySelector(".measures__custom .price").innerHTML = document.querySelector(".measures__border__custom .price").innerHTML;
                            document.querySelector("#txtPrice").innerHTML = "$"+formatNum(objData,".")+" COP";
                        });
        
                        borderColor.addEventListener("click",function(e){
                            let element = e.target;
                            let color = "#"+element.getAttribute("data-color");
                            let title = element.getAttribute("title");
                            document.querySelector("#txtBorde").innerHTML = textBorder+" - "+title;
                            document.querySelector("#selectedBorderColor").innerHTML = title;
                            if(selectBorder.value==2){
                                measureFrame.style.border = "3px solid "+color;
                            }else{
                                measureFrame.style.border = "8px solid "+color;
                            }
                        })
                        
                        document.querySelector("#txtBorde").innerHTML = textBorder;
                        document.querySelector(".color_border").classList.remove("d-none");
                        document.querySelector("#txtBorde").innerHTML = "Sin borde";
                        //document.querySelector("#txtVidrio").innerHTML = "Sin Vidrio";
                    }
                });
                
            }
        });
    });

    selectGlass.addEventListener("change",function(){
        let urlRequest = base_url+"/tienda/calcularMarco";
        let textGlass = selectGlass.options[selectGlass.selectedIndex].text;
        let selectedElement = document.querySelector(".measures__item.active");
        let id = selectedElement.getAttribute("id");
        let margin = parseInt(rangeFrame.value);
        let height = parseInt(document.querySelector("#intHeight").value);
        let width = parseInt(document.querySelector("#intWidth").value);
        let formData = new FormData();

        formData.append("id",id);
        formData.append("type",selectMargin.value);
        formData.append("height",height);
        formData.append("width",width);
        formData.append("margin",margin);
        formData.append("border",selectBorder.value);
        formData.append("glass",selectGlass.value);

        request(urlRequest,formData,"post").then(function(objData){
            document.querySelector(".measures__border__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$`+formatNum(objData,".")+" COP";
            document.querySelector(".measures__margin__custom .price").innerHTML = document.querySelector(".measures__border__custom .price").innerHTML;
            document.querySelector(".measures__custom .price").innerHTML = document.querySelector(".measures__border__custom .price").innerHTML;
            document.querySelector("#txtPrice").innerHTML = "$"+formatNum(objData,".")+" COP";
        });

        document.querySelector("#txtVidrio").innerHTML = textGlass;

    });

    
    /******************************Zoom in & Zoom out******************************** */

    let rangeZoom = document.querySelector("#rangeZoom")
    rangeZoom.addEventListener("input",function(){
        let rangeValue = rangeZoom.value;
        measureMargin.style.transform = "translate(-50%,-50%) scale("+(rangeValue/100)+")";
        measureFrame.style.transform = "translate(-50%,-50%) scale("+(rangeValue/100)+")";
        document.querySelector("#rangeZoomData").innerHTML = rangeValue+"%";
    }); 

    /*measureContainer.addEventListener("mousemove",function(e){
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
    })*/

    /******************************Next & Previous buttons******************************** */

    btnNext.addEventListener("click",function(){
        if( document.querySelectorAll(".page.active")){
            let pages = document.querySelectorAll(".page.active");
            for (let i = 0; i < pages.length; i++) {
    
                let nextPage = pages[i].nextElementSibling;
                let previousPage = nextPage.previousElementSibling;
                if(nextPage.classList[0] =="measures__description" ){
                    btnNext.classList.add("d-none");
                    btnPrevious.classList.remove("d-none");
                }else{
                    btnPrevious.classList.remove("d-none");
                    btnNext.classList.remove("d-none");
                }
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

                if(previousPage.classList[0] =="measures__dimensions" ){
                    btnPrevious.classList.add("d-none");
                    btnNext.classList.remove("d-none");
                }else{
                    btnPrevious.classList.remove("d-none");
                    btnNext.classList.remove("d-none");
                }

                previousPage.classList.add("active");
                previousPage.classList.remove("d-none");

                nextPage.classList.remove("active");
                nextPage.classList.add("d-none");
                
            }
        }
    })

    /******************************Add cart******************************** */
    let addCart = document.querySelector(".addCart");
    addCart.addEventListener("click",function(){
        if(document.querySelector(".measures__item.active")){
            
            let selectedElement = document.querySelector(".measures__item.active");
            let intId = selectedElement.getAttribute("id");
            let intHeight = document.querySelector("#intHeight").value;
            let intWidth = document.querySelector("#intWidth").value;
            let intMargin = document.querySelector("#rangeFrame").value;
            let intAddCant = document.querySelector("#addCant").value;
            let intMarginType = selectMargin.value;
            let intBorderType = selectBorder.value;
            let intGlassType = selectGlass.value;
            let strMargin = document.querySelector("#txtMargen").innerHTML;
            let strBorder = document.querySelector("#txtBorde").innerHTML;
            let strGlass = document.querySelector("#txtVidrio").innerHTML;
            
            let urlRequest = base_url+"/tienda/agregarCarrito";
            let formData = new FormData();

            if(intAddCant < 0){
                return false;
            }

            formData.append("intId",intId);
            formData.append("strMargin",strMargin);
            formData.append("strBorder",strBorder);
            formData.append("strGlass",strGlass);
            formData.append("intHeight",intHeight);
            formData.append("intWidth",intWidth);
            formData.append("intMargin",intMargin);
            formData.append("intAddCant",intAddCant);
            formData.append("intMarginType",intMarginType);
            formData.append("intBorderType",intBorderType);
            formData.append("intGlassType",intGlassType);
            formData.append("intIdTopic",1);

            
            

            request(urlRequest,formData,"post").then(function(objData){
                if(objData.status){
                    document.querySelector("#cantCarrito i").innerHTML = " ("+objData.cantidad+")";
                    Swal.fire("Agregado",objData.msg,"success");
                    
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            });
            
        }else{
            Swal.fire("Error","No has elegido el marco.","error");
        }
        
        
    });
}

/*********************************************************************Gallery page************************************************************************ */
if(document.querySelector("#galeria")){
    
    let url = base_url+"/tienda/getCuadros";
    request(url,"","get").then(function(objData){
        let html="";
        let parent = document.querySelector("#itemsGallery").parentElement;
        let child = document.querySelector("#itemsGallery");
        let fragment = document.createDocumentFragment();
        for (let i = 0; i < objData.length; i++) {
            let price = "$"+formatNum(parseInt(objData[i]['price']),".")+" COP";
            let route = base_url+"/tienda/producto/"+objData[i]['route'];
            html+=`
            <div class="card ms-1 mb-3 me-1" style="width: 18rem;" data-title="${objData[i]['title']}" data-author="${objData[i]['author']}">
                <img src="${objData[i]['url']}" class="card-img-top " alt="${objData[i]['title']}">
                <div class="card-body text-center">
                    <h5 class="card-title">${objData[i]['title']}</h5>
                    <p class="card-text m-0">${objData[i]['height']}cm x ${objData[i]['width']}cm</p>
                    <p class="card-text text-secondary">Artista - ${objData[i]['author']}</p>
                    <p class="card-text">${price}</p>
                    <a href="${route}" class="btn_content"><i class="fas fa-shopping-cart"></i> Agregar</a>
                </div>
            </div>
            `;
            
        }
        child.innerHTML = html;
        fragment.appendChild(child);
        parent.appendChild(fragment); 
    });

    if(document.querySelectorAll("#collapseOne ul li")){
        let topics = document.querySelectorAll("#collapseOne ul li");
        for (let i = 0; i < topics.length; i++) {
            let topic = topics[i];
            topic.addEventListener("click",function(e){
                let id = e.target.getAttribute("id");
                let formData = new FormData;
                id = id.replace("topic","");
                
                formData.append("topic",id);
                request(url,formData,"post").then(function(objData){
                    let html="";
                    let parent = document.querySelector("#itemsGallery").parentElement;
                    let child = document.querySelector("#itemsGallery");
                    let fragment = document.createDocumentFragment();
                    for (let i = 0; i < objData.length; i++) {
                        let price = "$"+formatNum(parseInt(objData[i]['price']),".")+" COP";
                        let route = base_url+"/tienda/producto/"+objData[i]['route'];
                        html+=`
                        <div class="card ms-1 mb-3 me-1" style="width: 18rem;" data-title="${objData[i]['title']}" data-author="${objData[i]['author']}">
                            <img src="${objData[i]['url']}" class="card-img-top " alt="${objData[i]['title']}">
                            <div class="card-body text-center">
                                <h5 class="card-title">${objData[i]['title']}</h5>
                                <p class="card-text m-0">${objData[i]['height']}cm x ${objData[i]['width']}cm</p>
                                <p class="card-text text-secondary">Artista - ${objData[i]['author']}</p>
                                <p class="card-text">${price}</p>
                                <a href="${route}" class="btn_content"><i class="fas fa-shopping-cart"></i> Agregar</a>
                            </div>
                        </div>
                        `;
                        
                    }
                    child.innerHTML = html;
                    fragment.appendChild(child);
                    parent.appendChild(fragment);
                });
    
            });
        }
    }
    if(document.querySelectorAll("#collapseTwo ul li")){
        let techs = document.querySelectorAll("#collapseTwo ul li");
        for (let i = 0; i < techs.length; i++) {
            let tech = techs[i];
            tech.addEventListener("click",function(e){
                let id = e.target.getAttribute("id");
                let formData = new FormData;
                id = id.replace("tech","");
                
                formData.append("tech",id);
                request(url,formData,"post").then(function(objData){
                    let html="";
                    let parent = document.querySelector("#itemsGallery").parentElement;
                    let child = document.querySelector("#itemsGallery");
                    let fragment = document.createDocumentFragment();
                    for (let i = 0; i < objData.length; i++) {
                        let price = "$"+formatNum(parseInt(objData[i]['price']),".")+" COP";
                        let route = base_url+"/tienda/producto/"+objData[i]['route'];
                        html+=`
                        <div class="card ms-1 mb-3 me-1" style="width: 18rem;" data-title="${objData[i]['title']}" data-author="${objData[i]['author']}">
                            <img src="${objData[i]['url']}" class="card-img-top " alt="${objData[i]['title']}">
                            <div class="card-body text-center">
                                <h5 class="card-title">${objData[i]['title']}</h5>
                                <p class="card-text m-0">${objData[i]['height']}cm x ${objData[i]['width']}cm</p>
                                <p class="card-text text-secondary">Artista - ${objData[i]['author']}</p>
                                <p class="card-text">${price}</p>
                                <a href="${route}" class="btn_content"><i class="fas fa-shopping-cart"></i> Agregar</a>
                            </div>
                        </div>
                        `;
                        
                    }
                    child.innerHTML = html;
                    fragment.appendChild(child);
                    parent.appendChild(fragment);
                });
    
            });
        }
    }

    let search = document.querySelector("#search");
    search.addEventListener('input',function() {
    let elements = document.querySelectorAll(".card");
    let value = search.value.toLowerCase();
        for(let i = 0; i < elements.length; i++) {
            let element = elements[i];
            let strTitle = element.getAttribute("data-title").toLowerCase();
            let strAutor = element.getAttribute("data-author").toLowerCase();
            if(!strTitle.includes(value) && !strAutor.includes(value)){
                element.classList.add("d-none");
            }else{
                element.classList.remove("d-none");
            }
        }
    })

    let orderBy = document.querySelector("#orderBy");
    orderBy.addEventListener("change",function(){
        let formData = new FormData;
        formData.append("order",orderBy.value);
        request(url,formData,"post").then(function(objData){
            let html="";
            let parent = document.querySelector("#itemsGallery").parentElement;
            let child = document.querySelector("#itemsGallery");
            let fragment = document.createDocumentFragment();
            for (let i = 0; i < objData.length; i++) {
                let price = "$"+formatNum(parseInt(objData[i]['price']),".")+" COP";
                let route = base_url+"/tienda/producto/"+objData[i]['route'];
                html+=`
                <div class="card ms-1 mb-3 me-1" style="width: 18rem;" data-title="${objData[i]['title']}" data-author="${objData[i]['author']}">
                    <img src="${objData[i]['url']}" class="card-img-top " alt="${objData[i]['title']}">
                    <div class="card-body text-center">
                        <h5 class="card-title">${objData[i]['title']}</h5>
                        <p class="card-text m-0">${objData[i]['height']}cm x ${objData[i]['width']}cm</p>
                        <p class="card-text text-secondary">Artista - ${objData[i]['author']}</p>
                        <p class="card-text">${price}</p>
                        <a href="${route}" class="btn_content"><i class="fas fa-shopping-cart"></i> Agregar</a>
                    </div>
                </div>
                `;
            }
            child.innerHTML = html;
            fragment.appendChild(child);
            parent.appendChild(fragment);
        });
    });

}

/*********************************************************************Product page************************************************************************ */
if(document.querySelector("#producto")){
    console.log("hola");
}