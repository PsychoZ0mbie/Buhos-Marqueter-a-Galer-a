'use strict'
let loading = document.querySelector("#divLoading");

/*********************************************************************Home page************************************************************************ */
if(document.querySelector("#home")){
    let url = base_url+"/tienda/getCuadrosAl";
    request(url,"","get").then(function(objData){
        //loading.style.display ="none";
        let parent = document.querySelector("#itemsGallery").parentElement;
        let child = document.querySelector("#itemsGallery");
        let fragment = document.createDocumentFragment();

        child.innerHTML = objData.html;
        fragment.appendChild(child);
        parent.appendChild(fragment); 
    });
}

/*********************************************************************Frame page************************************************************************ */

if(document.querySelector("#marqueteria")){
    /******************************Dimensions frame******************************** */
    let dimensionDefault = 200;
    let img = document.querySelector("#measuresImg");
    let picture = document.querySelector("#printImg");
    let imgLocation = ".measures__frame img";
    let tamaño = "";
    let flag =false;

    img.addEventListener("change",function(){
        uploadImg(img,imgLocation);
        setTimeout(function() {
            flag = true;
            let height = document.querySelector("#intHeight").value;
            let width = document.querySelector("#intWidth").value;
            let resolution = resolutionImg(height,width,picture);
            if(!resolution){
                document.querySelector("#quality").innerHTML = `<div class="bg-danger p-2 border border-1 border-dark rounded">
                <strong class="text-white">Nota:</strong>
                <p class="text-white">La imagen no tiene resolución suficiente para esas medidas. La impresión podría quedar pixelada o poco nítida. 
                Prueba con un tamaño más pequeño, o con una imagen de mayor resolución</p>
                </div>`;
            }else{
                document.querySelector("#quality").innerHTML = "";
            }
        }, 100);
    });

    let inputMeasure = document.querySelectorAll(".btn_number div.d-flex");
    let measureFrame = document.querySelector(".measures__frame");
    let measureMargin = document.querySelector(".measures__margin");
    //let measureContainer = document.querySelector(".measures__container");
    let rangeFrame = document.querySelector("#rangeFrame");
    let selectBorder = document.querySelector("#selectBorder");
    let selectMargin = document.querySelector("#selectMargin");
    let btnNext = document.querySelector("#btnNext");
    let btnPrevious = document.querySelector("#btnPrevious");

    for (let i = 0; i < inputMeasure.length; i++) {
    
        let event = inputMeasure[i];
        event.addEventListener("change",function(e){

            measureFrame.style.border="none";
            measureMargin.style.border ="none";
            measureMargin.style.background ="none";

            let height = document.querySelector("#intHeight").value;
            let width = document.querySelector("#intWidth").value;

            if(e.target.value < 10 || e.target.value > 200){
                Swal.fire("Error","Las dimensiones deben ser mínimo de 10 cm o máximo 200 cm!","error");
                e.target.value = 10;
                return false;
            }
            document.querySelector("#txtMedidasImg").innerHTML = height+"cm X "+width+"cm";
            if(flag){
                let resolution = resolutionImg(height,width,picture);
                if(!resolution){
                    document.querySelector("#quality").innerHTML = `<div class="bg-danger p-2 border border-1 border-dark rounded">
                    <strong class="text-white">Nota:</strong>
                    <p class="text-white">La imagen no tiene resolución suficiente para esas medidas. La impresión podría quedar pixelada o poco nítida. 
                    Prueba con un tamaño más pequeño, o con una imagen de mayor resolución</p>
                    </div>`;
                }else{
                    document.querySelector("#quality").innerHTML = "";
                }

            }

            let inputValue = String(parseFloat(e.target.value)+dimensionDefault)+"px";
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
            let search = document.querySelector("#search");
            let orderBy = document.querySelector("#orderBy");

            search.addEventListener('input',function() {
                let measureItems = document.querySelectorAll(".measures__item");
                let value = search.value.toLowerCase();
                    for(let i = 0; i < measureItems.length; i++) {
                        let element = measureItems[i];
                        let strTitle = element.getAttribute("title").toLowerCase();
                        if(!strTitle.includes(value)){
                            element.classList.add("d-none");
                        }else{
                            element.classList.remove("d-none");
                        }
                    }
                })
            measureFrame.style.border="none";
            measureMargin.style.border ="none";
            measureMargin.style.background ="none";

            document.querySelector(".measures__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$0 COP`;
            document.querySelector(".measures__margin__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$0 COP`;
            document.querySelector(".measures__border__custom .price").innerHTML = `<strong class="text__color">Precio: </strong>$0 COP`;
            document.querySelector("#txtPrice").innerHTML = "$0 COP";
            document.querySelector("#txtMolduras").innerHTML = textType;
            document.querySelector("#selectMoldura").classList.remove("d-none");

            
            loading.style.display="flex";
            request(url,"","get").then(function(objData){
                loading.style.display="none";
                if(objData.status){
                    let parent = document.querySelector(".scroll_list").parentElement;
                    let child = document.querySelector(".scroll_list");
                    let fragment = document.createDocumentFragment();
                    

                    child.innerHTML = objData.html;
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
                            let border = parseFloat(measureItem.getAttribute("data-border"));
                            document.querySelector("#selectFrame").innerHTML = textType+" - "+reference;
                            if(image != null){
        
                                let urlRequest = base_url+"/tienda/calcularMarco";
                                let formData = new FormData();
                                let height = parseFloat(document.querySelector("#intHeight").value);
                                let width = parseFloat(document.querySelector("#intWidth").value);
                    
                                
        
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
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            });

            if(selectType.value == 2){
                orderBy.classList.remove("d-none");
                orderBy.addEventListener("change",function(){
                    let urlBy = base_url+"/tienda/getMuestrasTipo/"+orderBy.value;
                    let formData = new FormData;
                    formData.append("order",orderBy.value);
                    loading.style.display = "flex";
                    request(urlBy,formData,"get").then(function(objData){
                        loading.style.display = "none";
                        let parent = document.querySelector(".scroll_list").parentElement;
                        let child = document.querySelector(".scroll_list");
                        let fragment = document.createDocumentFragment();

                        child.innerHTML = objData.html;
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
                                let border = parseFloat(measureItem.getAttribute("data-border"));
                                document.querySelector("#selectFrame").innerHTML = textType+" - "+reference;
                                if(image != null){
            
                                    let urlRequest = base_url+"/tienda/calcularMarco";
                                    let formData = new FormData();
                                    let height = parseFloat(document.querySelector("#intHeight").value);
                                    let width = parseFloat(document.querySelector("#intWidth").value);
                        
                                    
            
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
                });
            }else if(selectType.value==1){
                orderBy.classList.add("d-none");
            }
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
        let height = parseFloat(document.querySelector("#intHeight").value);
        let width = parseFloat(document.querySelector("#intWidth").value);

        document.querySelector("#txtMargen").innerHTML= textType;

        if(selectMargin.value == 1){
            
            let selectedElement = document.querySelector(".measures__item.active");
            let id = selectedElement.getAttribute("id");
            let margin = parseFloat(rangeFrame.value);
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

                if(document.querySelector(".measures__item.active")){
                    let selectedElement = document.querySelector(".measures__item.active");
                    let id = selectedElement.getAttribute("id");
                    let margin = parseFloat(rangeFrame.value);
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
                    document.querySelector(".color_border").classList.add("d-none");
                    document.querySelector("#txtBorde").innerHTML = "Sin borde";
                }else{
                    Swal.fire("Error","No ha elegido la moldura","error");
                }
            })

        }else if(selectMargin.value == 3){

            measureMargin.style.height = String(height+dimensionDefault)+"px";
            measureMargin.style.width = String(width+dimensionDefault)+"px";
            measureMargin.style.background ="#FFF";
            rangeFrame.value = 0;
            selectBorder.value = 1;
            selectGlass.value= 1;

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
            
            document.querySelector("#txtPrice").innerHTML =  document.querySelector(".measures__custom .price").innerHTML;
            document.querySelector("#rangeData").innerHTML = "0 cm";
            document.querySelector("#txtMargen").innerHTML = textType;
            document.querySelector("#txtMargenMedida").innerHTML = "0 cm";
            document.querySelector(".rangeInfo").classList.remove("d-none");
            document.querySelector(".color_border").classList.add("d-none");
            document.querySelector(".color_margin").classList.remove("d-none");
            document.querySelector("#txtBorde").innerHTML = selectBorder.options[selectBorder.selectedIndex].text;
            document.querySelector("#txtVidrio").innerHTML = selectGlass.options[selectGlass.selectedIndex].text;
            document.querySelector("#border").classList.remove("d-none");
            document.querySelector(".measures__margin__custom .price").innerHTML = document.querySelector(".measures__custom .price").innerHTML;
            document.querySelector(".measures__border__custom .price").innerHTML = document.querySelector(".measures__custom .price").innerHTML;

            rangeFrame.addEventListener("input",function(){
                if(document.querySelector(".measures__item.active")){
                    let selectedElement = document.querySelector(".measures__item.active");
                    let idP = selectedElement.getAttribute("id");
                    let margin = parseFloat(rangeFrame.value);
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
                    document.querySelector(".color_border").classList.add("d-none");
                    //document.querySelector("#txtVidrio").innerHTML = "Sin Vidrio";
                }else{
                    Swal.fire("Error","No ha elegido la moldura","error");
                }
            })
        }

        selectBorder.addEventListener("change",function(){
            
            let textBorder = selectBorder.options[selectBorder.selectedIndex].text;
            
            if(selectBorder.value == 1){

                measureFrame.style.border = "none";

                let selectedElement = document.querySelector(".measures__item.active");
                let id = selectedElement.getAttribute("id");
                let margin = parseFloat(rangeFrame.value);
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
                        let margin = parseFloat(rangeFrame.value);
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
        let margin = parseFloat(rangeFrame.value);
        let height = parseFloat(document.querySelector("#intHeight").value);
        let width = parseFloat(document.querySelector("#intWidth").value);
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
            let formData = new FormData();
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
            if(intAddCant < 0){
                return false;
            }

            loading.style.display="flex";
            addCart.setAttribute("disabled","");
            if(flag){
                let height = document.querySelector("#intHeight").value;
                let width = document.querySelector("#intWidth").value;
                let resolution = resolutionImg(height,width,picture);
                if(resolution){

                    let url = base_url+"/tienda/calcularImpresion";
                    loading.style.display = "flex";
                    request(url,formData,"post").then(function(objData){
                        let html = `¿Desea incluir la impresión de la imágen por <strong>${objData}</strong>?`;
                        loading.style.display = "none";
                        Swal.fire({
                            title:"Impresión de imágen",
                            html: html,
                            showCancelButton:true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText:"Sí",
                            cancelButtonText:"No"
                        }).then(function(result){
                            if(result.isConfirmed){
                                let url = base_url+"/tienda/agregarCarrito";
                                formData.append("boolPrint",true);
                                formData.append("archivo",img.files[0]);
                                loading.style.display = "flex";
                                request(url,formData,"post").then(function(objData){
                                    addCart.removeAttribute("disabled");
                                    loading.style.display = "none";
                                    if(objData.status){
                                        document.querySelector("#cantCarrito i").innerHTML = " ("+objData.cantidad+")";
                                        Swal.fire("Agregado",objData.msg,"success");
                                    }else{
                                        Swal.fire("Error",objData.msg,"error");
                                    }
                                });
                            }else{
                                let url = base_url+"/tienda/agregarCarrito";
                                request(url,formData,"post").then(function(objData){
                                    addCart.removeAttribute("disabled");
                                    loading.style.display="none";
                                    if(objData.status){
                                        document.querySelector("#cantCarrito i").innerHTML = " ("+objData.cantidad+")";
                                        Swal.fire("Agregado",objData.msg,"success");
                                        
                                    }else{
                                        Swal.fire("Error",objData.msg,"error");
                                    }
                                });
                            }
                        });
                    });
                }else{
                    let url = base_url+"/tienda/calcularImpresion";
                    loading.style.display = "flex";
                    request(url,formData,"post").then(function(objData){
                        let html = `
                                    <p class="text-center">La imagen no tiene resolución suficiente para esas medidas. La impresión podría quedar pixelada o poco nítida. 
                                    Prueba con un tamaño más pequeño, o con una imagen de mayor resolución</p>
                                    <p>¿Desea incluir la impresión de la imágen de todas formas por <strong>${objData}</strong>?</p>`;
                        loading.style.display = "none";
                        Swal.fire({
                            title:"Impresión de imágen",
                            html: html,
                            showDenyButton: true,
                            showCancelButton:true,
                            confirmButtonColor: '#3085d6',
                            denyButtonColor:'#d33',
                            confirmButtonText:"Sí",
                            denyButtonText:"No",
                            cancelButtonText:"Cancelar"
                        }).then(function(result){
                            if(result.isConfirmed){
                                let url = base_url+"/tienda/agregarCarrito";
                                formData.append("boolPrint",true);
                                formData.append("archivo",img.files[0]);
                                loading.style.display = "flex";
                                request(url,formData,"post").then(function(objData){
                                    addCart.removeAttribute("disabled");
                                    loading.style.display = "none";
                                    if(objData.status){
                                        document.querySelector("#cantCarrito i").innerHTML = " ("+objData.cantidad+")";
                                        Swal.fire("Agregado",objData.msg,"success");
                                    }else{
                                        Swal.fire("Error",objData.msg,"error");
                                    }
                                });
                            }else if(result.isDenied){
                                let url = base_url+"/tienda/agregarCarrito";
                                request(url,formData,"post").then(function(objData){
                                    addCart.removeAttribute("disabled");
                                    loading.style.display="none";
                                    if(objData.status){
                                        document.querySelector("#cantCarrito i").innerHTML = " ("+objData.cantidad+")";
                                        Swal.fire("Agregado",objData.msg,"success");
                                        
                                    }else{
                                        Swal.fire("Error",objData.msg,"error");
                                    }
                                });
                            }else{
                                addCart.removeAttribute("disabled");
                            }
                        });
                    });
                }
            }else{
                let url = base_url+"/tienda/agregarCarrito";
                request(url,formData,"post").then(function(objData){
                    addCart.removeAttribute("disabled");
                    loading.style.display="none";
                    if(objData.status){
                        document.querySelector("#cantCarrito i").innerHTML = " ("+objData.cantidad+")";
                        Swal.fire("Agregado",objData.msg,"success");
                        
                    }else{
                        Swal.fire("Error",objData.msg,"error");
                    }
                });
            }
            
            
        }else{
            Swal.fire("Error","No has elegido el marco.","error");
        }
        
        
    });

    /******************************Guide******************************** */
    let btnSpanGuide = document.querySelectorAll(".guide");
    let btnGuide = document.querySelector(".btn__guide");
    let btnClose = document.querySelector(".guide__panel__close");
    
    btnClose.addEventListener("click",function(){
        document.querySelector(".guide__panel").classList.remove("active");
    })
    for (let i = 0; i < btnSpanGuide.length; i++) {
        let btn = btnSpanGuide[i];
        btn.addEventListener("click",function(){
            document.querySelector(".guide__panel").classList.toggle("active");
        });
        
    }
    btnGuide.addEventListener("click",function(){
        document.querySelector(".guide__panel").classList.toggle("active");
    });

}

/*********************************************************************Gallery page************************************************************************ */
if(document.querySelector("#galeria")){
    let url = base_url+"/tienda/getCuadros";
    loading.style.display = "flex";
    request(url,"","get").then(function(objData){
        loading.style.display ="none";
        let parent = document.querySelector("#itemsGallery").parentElement;
        let child = document.querySelector("#itemsGallery");
        let fragment = document.createDocumentFragment();

        child.innerHTML = objData.html;
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
                loading.style.display = "flex";
                request(url,formData,"post").then(function(objData){
                    loading.style.display = "none";
                    let parent = document.querySelector("#itemsGallery").parentElement;
                    let child = document.querySelector("#itemsGallery");
                    let fragment = document.createDocumentFragment();
                    
                    child.innerHTML = objData.html;
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
                loading.style.display = "flex";
                request(url,formData,"post").then(function(objData){
                    loading.style.display = "none";
                    let parent = document.querySelector("#itemsGallery").parentElement;
                    let child = document.querySelector("#itemsGallery");
                    let fragment = document.createDocumentFragment();
            
                    child.innerHTML = objData.html;
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
        loading.style.display = "flex";
        request(url,formData,"post").then(function(objData){
            loading.style.display = "none";
            let parent = document.querySelector("#itemsGallery").parentElement;
            let child = document.querySelector("#itemsGallery");
            let fragment = document.createDocumentFragment();
            
            child.innerHTML = objData.html;
            fragment.appendChild(child);
            parent.appendChild(fragment);
        });
    });

}

/*********************************************************************Product page************************************************************************ */
if(document.querySelector("#producto")){
    let formData = new FormData();
    let autor = document.querySelector("#autor").innerHTML;
    let url = base_url+"/tienda/getCuadrosAl";
    formData.append("autor",autor);
    request(url,"","get").then(function(objData){
        //loading.style.display ="none";
        let parent = document.querySelector("#itemsGallery").parentElement;
        let child = document.querySelector("#itemsGallery");
        let fragment = document.createDocumentFragment();

        child.innerHTML = objData.html;
        fragment.appendChild(child);
        parent.appendChild(fragment); 
    });
    
    if(document.querySelector(".addCart")){
        let button = document.querySelector(".addCart");
        button.addEventListener("click",function(){
            
            let id = button.getAttribute("id");
            let urlRequest = base_url+"/tienda/agregarCarrito";
            let formData = new FormData();

            formData.append("id",id);
            formData.append("intIdTopic",2);
            loading.style.display = "flex";
            button.setAttribute("disabled","");
            request(urlRequest,formData,"post").then(function(objData){
                button.removeAttribute("disabled");
                loading.style.display = "none";
                if(objData.status){
                    document.querySelector("#cantCarrito i").innerHTML = " ("+objData.cantidad+")";
                    Swal.fire("Agregado",objData.msg,"success");
                    
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            });
        })
    }
}

/*********************************************************************Shopping page************************************************************************ */
if(document.querySelector("#carrito")){
    let url = base_url+"/tienda/carritoInfo";
    
    request(url,"","get").then(function(objData){
        if(objData.status){
            document.querySelector("#with").classList.remove("d-none");
            document.querySelector("#without").classList.add("d-none");
            document.querySelector("tbody").innerHTML = objData.html;
            document.querySelector("#subtotal").innerHTML = objData.subtotal;
            document.querySelector("#iva").innerHTML = objData.iva;
            document.querySelector("#total").innerHTML = objData.total;
        }else{
            document.querySelector("#with").classList.add("d-none");
            document.querySelector("#without").classList.remove("d-none");
        }
    })

    if(document.querySelector("#with table")){
        let tabla = document.querySelector("#with table");
        tabla.addEventListener("click",function(e){
            if(e.target.getAttribute("name") == "eliminar"){
                let element = e.target.parentElement.parentElement;
                let id =  element.getAttribute("id");
                let idCategoria =  element.getAttribute("idc");
                let tipoMargen =  element.getAttribute("tm");
                let tipoBorde =  element.getAttribute("tb");
                let tipoVidrio =  element.getAttribute("tv");
                let margen =  element.getAttribute("m");
                let medidasImagen =  element.getAttribute("mi");
                let medidasMarco =  element.getAttribute("mm");
                let url = base_url+"/tienda/eliminarCarrito"
                let formData = new FormData();
                formData.append("id",id);
                formData.append("idCategoria",idCategoria);
                formData.append("tipoMargen",tipoMargen);
                formData.append("tipoBorde",tipoBorde);
                formData.append("tipoVidrio",tipoVidrio);
                formData.append("margen",margen);
                formData.append("medidasImagen",medidasImagen);
                formData.append("medidasMarco",medidasMarco);
                
                request(url,formData,"post").then(function(objData){
                    if(objData.status){
                        document.querySelector("#subtotal").innerHTML = objData.subtotal;
                        document.querySelector("#iva").innerHTML = objData.iva;
                        document.querySelector("#total").innerHTML = objData.total;
                        document.querySelector("#cantCarrito i").innerHTML = " ("+objData.cantidad+")";
                        element.remove();
                        if(objData.cantidad == 0){
                            document.querySelector("#with").classList.add("d-none");
                            document.querySelector("#without").classList.remove("d-none");
                        }
                    }else{
                        Swal.fire("Error",objData.msg,"error");
                    }
                });
            }
            if(e.target.getAttribute("name") == "actualizar"){
                let input = e.target;
                input.addEventListener("change",function(){
                    let cantidad = input.value;
                    if(cantidad > 0){
                        let element = input.parentElement.parentElement;
                        let id =  element.getAttribute("id");
                        let idCategoria =  element.getAttribute("idc");
                        let tipoMargen =  element.getAttribute("tm");
                        let tipoBorde =  element.getAttribute("tb");
                        let tipoVidrio =  element.getAttribute("tv");
                        let margen =  element.getAttribute("m");
                        let medidasImagen =  element.getAttribute("mi");
                        let medidasMarco =  element.getAttribute("mm");
                        let impresion= element.getAttribute("imp");
                        let url = base_url+"/tienda/actualizarCarrito"
                        let formData = new FormData();
    
                        formData.append("id",id);
                        formData.append("idCategoria",idCategoria);
                        formData.append("tipoMargen",tipoMargen);
                        formData.append("tipoBorde",tipoBorde);
                        formData.append("tipoVidrio",tipoVidrio);
                        formData.append("margen",margen);
                        formData.append("medidasImagen",medidasImagen);
                        formData.append("medidasMarco",medidasMarco);
                        formData.append("cantidad",cantidad);
                        formData.append("impresion",impresion);
                        
                        request(url,formData,"post").then(function(objData){
                            if(objData.status){
                                document.querySelector("#subtotal").innerHTML = objData.subtotal;
                                document.querySelector("#iva").innerHTML = objData.iva;
                                document.querySelector("#total").innerHTML = objData.total;
                                document.querySelector("#cantCarrito i").innerHTML = " ("+objData.cantidad+")";
                                element.children[3].innerHTML = objData.precio;
                            }else{
                                Swal.fire("Error",objData.msg,"error");
                                input.value = 1;
                            }
                        });
                    }else{
                        input.value = 1;
                        Swal.fire("Error","La cantidad debe ser mayor a cero, inténtelo de nuevo.","error"); 
                    }
                });
            }
        });
    }

}

/*********************************************************************Order process page************************************************************************ */
if(document.querySelector("#procesarpedido")){
    let url = base_url+"/tienda/totalCarrito";
    request(url,"","get").then(function(objData){
        document.querySelector("#subtotal").innerHTML = objData.subtotal;
        document.querySelector("#iva").innerHTML = objData.iva;
        document.querySelector("#total").innerHTML = objData.total;
    });
    if(document.querySelector("#formOrden")){
        let formOrden = document.querySelector("#formOrden");
        let url = base_url+"/tienda/getSelectDepartamentos";
        let listDepartamento = document.querySelector("#listDepartamento");
        let btnOrder = document.querySelector("#btnOrder");
        request(url,"","get").then(function(objData){
            listDepartamento.innerHTML = objData.department;
        });
        listDepartamento.addEventListener("change",function(){
            let url = base_url+"/tienda/getSelectCity/"+listDepartamento.value;
            request(url,"","get").then(function(objData){
                document.querySelector("#listCiudad").innerHTML = objData.html;
            });
        });
        btnOrder.addEventListener("click",function(e){
            e.preventDefault();
            let strNombre = document.querySelector("#txtNombreOrden").value;
            let strApellido = document.querySelector("#txtApellidoOrden").value;
            let strEmail = document.querySelector("#txtEmailOrden").value;
            let intTelefono = document.querySelector("#txtTelefono").value;
            let intDepartamento = document.querySelector("#listDepartamento").value;
            let intCiudad = document.querySelector("#listCiudad").value;
            let intCedula = document.querySelector("#txtIdentificacion").value;
            let strDireccion = document.querySelector("#txtDireccion").value;
            let strComentario = document.querySelector("#txtComentario").value;

            if(strNombre =="" || strApellido =="" || strEmail =="" || intTelefono=="" || intDepartamento ==""
            || intCiudad =="" || intCedula =="" || strDireccion==""){
                Swal.fire("Error","todos los campos con (*) son obligatorios","error");
                return false;
            }
            if(intTelefono.length < 10){
                Swal.fire("Error","El número de teléfono debe tener 10 dígitos","error");
                return false;
            }
            if(intCedula.length < 8 || intCedula.length > 10){
                Swal.fire("Error","La cédula debe tener de 8 a 10 dígitos","error");
                return false;
            }
            if(!fntEmailValidate(strEmail)){
                let html = `
                <br>
                <br>
                <p>micorreo@hotmail.com</p>
                <p>micorreo@outlook.com</p>
                <p>micorreo@yahoo.com</p>
                <p>micorreo@live.com</p>
                <p>micorreo@gmail.com</p>
                `;
                Swal.fire("Error","El correo ingresado es inválido, solo permite los siguientes correos: "+html,"error");
                return false;
            }
            //btnOrder.setAttribute("onclick","checkout.open()");
            let formData = new FormData(formOrden);
            let url=base_url+"/tienda/setPedido";
            btnOrder.setAttribute("disabled","");
            loading.style.display = "flex";
            request(url,formData,"post").then(function(objData){
                loading.style.display = "none";
                btnOrder.removeAttribute("disabled");
                if(objData.status){
                    checkout.open();
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            });
        });
    }
    if( document.querySelector("#formLogin")){

        let formLogin = document.querySelector("#formLogin");
        let btnLogin = document.querySelector("#btnLogin");
        let btnForget = document.querySelector("#btnForget");
        let btnBack = document.querySelector("#btnBack");
        let formRecovery = document.querySelector("#formRecovery");
        let changeTitle = document.querySelector("#changeTitle");
        

        btnForget.addEventListener("click",function(e){
            formLogin.classList.add("d-none");
            formRecovery.classList.remove("d-none");
            changeTitle.innerHTML="Recuperar contraseña";
        });
        btnBack.addEventListener("click",function(e){
            formLogin.classList.remove("d-none");
            formRecovery.classList.add("d-none");
            changeTitle.innerHTML="Soy cliente";
        });

        formLogin.addEventListener("submit",function(e){
            e.preventDefault();
            let strEmail = document.querySelector('#txtEmail').value;
            let strPassword = document.querySelector('#txtPassword').value;
    
            if(strEmail == "" || strPassword ==""){
                Swal.fire("Por favor", "Escribe usuario y contraseña.", "error");
                return false;
            }else{
                let url = base_url+'/Login/loginUser'; 
                let formData = new FormData(formLogin);
                loading.style.display = "flex";
                btnLogin.setAttribute("disabled","");
                request(url,formData,"post").then(function(objData){
                    btnLogin.removeAttribute("disabled");
                    loading.style.display = "none";
                    if(objData.status){
                        window.location.reload(false);
                    }else{
                        Swal.fire("Atención", objData.msg, "error");
                        document.querySelector('#txtPassword').value = "";
                    }
                });
            }
        });

        formRecovery.addEventListener("submit",function(e){
            e.preventDefault();
    
            let strEmail = document.querySelector("#txtEmailRecovery").value;
            let url = base_url+'/tienda/resetPass'; 
            let formData = new FormData(formRecovery);
            if(strEmail == ""){
                swal("Por favor", "Escribe tu correo electrónico.","error");
                return false;
            }
            if(!fntEmailValidate(strEmail)){
                let html = `
                <br>
                <br>
                <p>micorreo@hotmail.com</p>
                <p>micorreo@outlook.com</p>
                <p>micorreo@yahoo.com</p>
                <p>micorreo@live.com</p>
                <p>micorreo@gmail.com</p>
                `;
                Swal.fire("Error","El correo ingresado es inválido, solo permite los siguientes correos: "+html,"error");
                return false;
            }
    
            loading.style.display = "flex";
            request(url,formData,"post").then(function(objData){
                if(objData.status){
                    Swal.fire({
                        title: "Recuperar contraseña",
                        text: objData.msg,
                        icon: "success",
                        confirmButtonText: 'Ok',
                        showCancelButton: true,
                    }).then(function(result){
                        if(result.isConfirmed){
                            window.location = base_url+"/tienda/procesarPedido";
                        }
                    });
                }else{
                    swal("Atención",objData.msg,"error");
                }
                loading.style.display = "none";
            });
        });
    }
    if(document.querySelector("#formRegister")){
        let formRegister = document.querySelector("#formRegister");
        let btnRegister = document.querySelector("#btnRegister");
        let btnSendCode = document.querySelector("#btnSendCode");

        btnSendCode.addEventListener("click",function(){
            let strNombre = document.querySelector("#txtNombreCliente").value;
            let strApellido = document.querySelector("#txtApellidoCliente").value;
            let strEmail = document.querySelector("#txtEmailCliente").value;
            let strPassword = document.querySelector("#txtPasswordCliente").value;
            let estado = document.querySelector("#checkBox").checked;
            
    
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
            if(!estado){
                Swal.fire("Error","Debes aceptar los términos y condiciones!","error");
                return false;
            }
            loading.style.display = "flex";
            let url = base_url+"/Tienda/confirmCliente";
            let formData = new FormData(formRegister);
            btnSendCode.setAttribute("disabled","");
            request(url,formData,"post").then(function(objData){
                btnSendCode.removeAttribute("disabled");
                loading.style.display = "none";
                if(objData.status){
                    Swal.fire("",objData.msg,"success");
                    document.querySelector("#sendCode").classList.remove("d-none");
                    formRegister.classList.add("d-none");
                }else{
                    Swal.fire("Error",objData.msg,"error");
                } 
            });
        });

        btnRegister.addEventListener("click",function(){
            let strNombre = document.querySelector("#txtNombreCliente").value;
            let strApellido = document.querySelector("#txtApellidoCliente").value;
            let strEmail = document.querySelector("#txtEmailCliente").value;
            let strPassword = document.querySelector("#txtPasswordCliente").value;
            let intCodigo = document.querySelector("#intCodigo").value;

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

            if(intCodigo == ""){
                Swal.fire("Error","Debes introducir el código que se te envió al correo.","error");
                return false;
            }

            loading.style.display = "flex";
            let url = base_url+"/Tienda/setCliente";
            let formData = new FormData(formRegister);
            formData.append("codigo",intCodigo);

            btnRegister.setAttribute("disabled","");
            request(url,formData,"post").then(function(objData){
                btnRegister.removeAttribute("disabled");
                loading.style.display = "none";
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
            });
        })
    }
}

/*********************************************************************Account page************************************************************************ */
if(document.querySelector("#cuenta")){
    if( document.querySelector("#formLogin")){

        let formLogin = document.querySelector("#formLogin");
        let btnLogin = document.querySelector("#btnLogin");
        let btnForget = document.querySelector("#btnForget");
        let btnBack = document.querySelector("#btnBack");
        let formRecovery = document.querySelector("#formRecovery");
        let changeTitle = document.querySelector("#changeTitle");
        

        btnForget.addEventListener("click",function(e){
            formLogin.classList.add("d-none");
            formRecovery.classList.remove("d-none");
            changeTitle.innerHTML="Recuperar contraseña";
        });
        btnBack.addEventListener("click",function(e){
            formLogin.classList.remove("d-none");
            formRecovery.classList.add("d-none");
            changeTitle.innerHTML="Soy cliente";
        });

        formLogin.addEventListener("submit",function(e){
            e.preventDefault();
            let strEmail = document.querySelector('#txtEmail').value;
            let strPassword = document.querySelector('#txtPassword').value;
    
            if(strEmail == "" || strPassword ==""){
                Swal.fire("Por favor", "Escribe usuario y contraseña.", "error");
                return false;
            }else{
                let url = base_url+'/Login/loginUser'; 
                let formData = new FormData(formLogin);
                loading.style.display = "flex";
                btnLogin.setAttribute("disabled","");
                request(url,formData,"post").then(function(objData){
                    btnLogin.removeAttribute("disabled");
                    loading.style.display = "none";
                    if(objData.status){
                        window.location.reload(false);
                    }else{
                        Swal.fire("Atención", objData.msg, "error");
                        document.querySelector('#txtPassword').value = "";
                    }
                });
            }
        });

        formRecovery.addEventListener("submit",function(e){
            e.preventDefault();
    
            let strEmail = document.querySelector("#txtEmailRecovery").value;
            let url = base_url+'/tienda/resetPass'; 
            let formData = new FormData(formRecovery);
            if(strEmail == ""){
                swal("Por favor", "Escribe tu correo electrónico.","error");
                return false;
            }
            if(!fntEmailValidate(strEmail)){
                let html = `
                <br>
                <br>
                <p>micorreo@hotmail.com</p>
                <p>micorreo@outlook.com</p>
                <p>micorreo@yahoo.com</p>
                <p>micorreo@live.com</p>
                <p>micorreo@gmail.com</p>
                `;
                Swal.fire("Error","El correo ingresado es inválido, solo permite los siguientes correos: "+html,"error");
                return false;
            }
    
            loading.style.display = "flex";
            request(url,formData,"post").then(function(objData){
                if(objData.status){
                    Swal.fire({
                        title: "Recuperar contraseña",
                        text: objData.msg,
                        icon: "success",
                        confirmButtonText: 'Ok',
                        showCancelButton: true,
                    }).then(function(result){
                        if(result.isConfirmed){
                            window.location = base_url+"/cuenta";
                        }
                    });
                }else{
                    swal("Atención",objData.msg,"error");
                }
                loading.style.display = "none";
            });
        });
        
        
    }
    if(document.querySelector("#formRegister")){
        let formRegister = document.querySelector("#formRegister");
        let btnRegister = document.querySelector("#btnRegister");
        let btnSendCode = document.querySelector("#btnSendCode");

        btnSendCode.addEventListener("click",function(){
            let strNombre = document.querySelector("#txtNombreCliente").value;
            let strApellido = document.querySelector("#txtApellidoCliente").value;
            let strEmail = document.querySelector("#txtEmailCliente").value;
            let strPassword = document.querySelector("#txtPasswordCliente").value;
            let estado = document.querySelector("#checkBox").checked;
            
    
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
            if(!estado){
                Swal.fire("Error","Debes aceptar los términos y condiciones!","error");
                return false;
            }
            loading.style.display = "flex";
            let url = base_url+"/Tienda/confirmCliente";
            let formData = new FormData(formRegister);
            btnSendCode.setAttribute("disabled","");
            request(url,formData,"post").then(function(objData){
                btnSendCode.removeAttribute("disabled");
                loading.style.display = "none";
                if(objData.status){
                    Swal.fire("",objData.msg,"success");
                    document.querySelector("#sendCode").classList.remove("d-none");
                    formRegister.classList.add("d-none");
                }else{
                    Swal.fire("Error",objData.msg,"error");
                } 
            });
        });

        btnRegister.addEventListener("click",function(){
            let strNombre = document.querySelector("#txtNombreCliente").value;
            let strApellido = document.querySelector("#txtApellidoCliente").value;
            let strEmail = document.querySelector("#txtEmailCliente").value;
            let strPassword = document.querySelector("#txtPasswordCliente").value;
            let intCodigo = document.querySelector("#intCodigo").value;

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

            if(intCodigo == ""){
                Swal.fire("Error","Debes introducir el código que se te envió al correo.","error");
                return false;
            }

            loading.style.display = "flex";
            let url = base_url+"/Tienda/setCliente";
            let formData = new FormData(formRegister);
            formData.append("codigo",intCodigo);

            btnRegister.setAttribute("disabled","");
            request(url,formData,"post").then(function(objData){
                btnRegister.removeAttribute("disabled");
                loading.style.display = "none";
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
            });
        })
    }
}
if(document.querySelector("#recuperar")){
    let formReset = document.querySelector("#formReset");
    formReset.addEventListener("submit",function(e){
        e.preventDefault();
        
        let strPassword = document.querySelector("#txtPassword").value;
        let strPasswordConfirm = document.querySelector("#txtPasswordConfirm").value;
        let idUser = document.querySelector("#idUsuario").value;
        let strEmail = document.querySelector("#txtEmail").value;
        let strToken = document.querySelector("#txtToken").value;
        let url = base_url+'/tienda/setPassword'; 
        let formData = new FormData(formReset);
        
        formData.append("txtToken",strToken);
        formData.append("txtEmail",strEmail);
        formData.append("idUsuario",idUser);

        if(strPassword == "" || strPasswordConfirm==""){
            Swal.fire("Por favor", "Escribe la nueva contraseña.", "error");
            return false;
        }else{
            if(strPassword.length < 8){
                Swal.fire("Atención", "La contraseña debe tener un mínimo de 8 carácteres.","info");
                return false;
            }if(strPassword != strPasswordConfirm){
                Swal.fire("Atención", "Las contraseñas no coinciden.", "error");
                return false;
            }

            loading.style.display = "flex";
            request(url,formData,"post").then(function(objData){
                if(objData.status){
                    Swal.fire({
                        title: "Por favor, inicia sesión",
                        text: objData.msg,
                        icon: "success",
                        confirmButtonText: 'Ok',
                        showCancelButton: true,
                    }).then(function(result){
                        if(result.isConfirmed){
                            window.location = base_url+"/cuenta";
                        }
                    });
                }else{
                    Swal.fire("Atención",objData.msg,"error");
                }
                loading.style.display = "none";
            });
        }
    });
}
/*********************************************************************Contact page************************************************************************ */
if(document.querySelector("#contacto")){
    let formContacto = document.querySelector("#formContacto");
    let btnContact = document.querySelector("#btnContact");
    formContacto.addEventListener("submit",function(e){
        e.preventDefault();
        let strNombre = document.querySelector("#txtNombre").value;
        let strApellido = document.querySelector("#txtApellido").value;
        let strEmail = document.querySelector("#txtEmail").value;
        let intTelefono = document.querySelector("#txtTelefono").value;
        let strComentario = document.querySelector("#txtComentario").value;

        if(strNombre == "" || strApellido == "" || strEmail == "" || intTelefono == "" || strComentario == ""){
            Swal.fire("Error","Todos los campos son obligatorios.","error");
            return false;
        }
        if(!fntEmailValidate(strEmail)){
            let html = `
            <br>
            <br>
            <p>micorreo@hotmail.com</p>
            <p>micorreo@outlook.com</p>
            <p>micorreo@yahoo.com</p>
            <p>micorreo@live.com</p>
            <p>micorreo@gmail.com</p>
            `;
            Swal.fire("Error","El correo ingresado es inválido, solo permite los siguientes correos: "+html,"error");
            return false;
        }
        if(intTelefono.length < 10){
            Swal.fire("Error","El número de teléfono debe tener 10 dígitos","error");
            return false;
        }

        loading.style.display = "flex";
        let url = base_url+"/contacto/setContacto";
        let formData = new FormData(formContacto);
        btnContact.setAttribute("disabled","");
        request(url,formData,"post").then(function(objData){
            btnContact.removeAttribute("disabled");
            loading.style.display = "none";
            if(objData.status){
                formContacto.reset();
                Swal.fire("Mensaje",objData.msg,"success");
            }else{
                Swal.fire("Error",objData.msg,"error");
            } 
        });

    })
}
/*********************************************************************header************************************************************************ */
if(document.querySelector("#logout")){
    let logout = document.querySelector("#logout");
    logout.addEventListener("click",function(e){
        let url = base_url+"/logout";
        request(url,"","get").then(function(objData){
            window.location = base_url+"/cuenta";
        });
    });
}
