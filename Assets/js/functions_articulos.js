let tableArticulo;
let rowTable;
let divLoading = document.querySelector("#divLoading");
$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});
tableArticulo = $('#tableArticulos').dataTable( {
    "aProcessing":true,
    "aServerSide":true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax":{
        "url": " "+base_url+"/Articulos/getArticulos",
        "dataSrc":""
    },
    "columns":[
        {"data":"title"},
        {"data":"categoria"},
        {"data":"status"},
        {"data":"date"},
        {"data":"options"}
    ],
    'dom': 'lBfrtip',
    'buttons': [
        {
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i> Copiar",
            "titleAttr":"Copiar",
            "className": "btn btn-secondary",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
        },{
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr":"Exportar a Excel",
            "className": "btn btn-success",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
        },{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr":"Exportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
        },{
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr":"Exportar a CSV",
            "className": "btn btn-info",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
        }
    ],
    "responsieve":"true",
    "bDestroy": true,
    "iDisplayLength": 10,
    "order":[[3,"desc"]]  
});

tablePapelera = $('#tablePaper').dataTable( {
    "aProcessing":true,
    "aServerSide":true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax":{
        "url": " "+base_url+"/Articulos/getPapelera",
        "dataSrc":""
    },
    "columns":[
        {"data":"title"},
        {"data":"categoria"},
        {"data":"date"},
        {"data":"options"}
    ],
    'dom': 'lBfrtip',
    'buttons': [
        {
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i> Copiar",
            "titleAttr":"Copiar",
            "className": "btn btn-secondary",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
        },{
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr":"Exportar a Excel",
            "className": "btn btn-success",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
        },{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr":"Exportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
        },{
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr":"Exportar a CSV",
            "className": "btn btn-info",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
        }
    ],
    "responsieve":"true",
    "bDestroy": true,
    "iDisplayLength": 10,
    "order":[[0,"asc"]]  
});

window.addEventListener('load',function(){
   /*if(document.querySelector("#fileImage")){
        let foto = document.querySelector("#fileImage");
        foto.onchange = function(e) {
            let uploadFoto = document.querySelector("#fileImage").value;
            let fileimg = document.querySelector("#fileImage").files;
            let nav = window.URL || window.webkitURL;

            if(uploadFoto !=''){
                let type = fileimg[0].type;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
                    swal("Error", "El archivo no es válido." , "error");
                    foto.value="";
                    return false;
                }else{  
                    //console.log(this.files[0]);
                    let objeto_url = nav.createObjectURL(this.files[0]);
                    console.log(objeto_url);
                    document.querySelector('#imgFile').setAttribute("src",objeto_url);
                }
            }else{
                swal("Error", "No seleccionó imágen." , "error");
            }
        }
    }

    if(document.querySelector("#urlImage")){
        let foto = document.querySelector("#urlImage");
        foto.onchange = function(e) {
            let url = document.querySelector("#urlImage").value;
            if(url !=''){
                /*if(url.match(/\.(jpeg|jpg|png)$/) !=null){
                    //swal("Error", "La url no contiene una imágen.","error");
                    return false;
                }else{
                    
                }
                document.querySelector('#imgUrl').setAttribute("src",url);
            }

        }
    }*/
    if(document.querySelector("#pills-make-tab")){
        let btn = document.querySelector("#pills-make-tab");
        btn.onclick = function(){
            document.querySelector('#pills-make-tab').classList.add("active");
            document.querySelector('#pills-make').classList.add("active","show");
            document.querySelector('#pills-articles').classList.add("d-none");
            document.querySelector('#pills-articles-tab').classList.add("d-none");
            document.querySelector('#pills-paper').classList.add("d-none");
            document.querySelector('#pills-paper-tab').classList.add("d-none");
        }
    }
    let formArticulo = document.querySelector("#formArticulo");
    document.querySelector("#containerGallery").classList.add("d-none");
    formArticulo.onsubmit = function(e) {
        e.preventDefault();

        let strNombre = document.querySelector('#txtNombre').value;
        let strTitulo = document.querySelector("#txtTitulo").value;
        let strDescripcion = document.querySelector('#txtDescripcion').value;
        //let urlImage = document.querySelector('#urlImage').value;
        let intCategoria = document.querySelector('#listCategoria').value;
        let intStatus = document.querySelector('#listStatus').value;        
        if(strNombre == '' || strDescripcion == '' || intStatus == '' || intCategoria == ''){
        
            swal("Atención", "Todos los campos son obligatorios." , "error");
            return false;
        }
        if(strNombre.length > 30){
            swal("Atención", "El título permite máximo 30 carácteres" , "error");
            return false;
        }
        if(strTitulo.length > 70){
            swal("Atención", "El título permite máximo 70 carácteres" , "error");
            return false;
        }

        divLoading.style.display = "flex";
        tinyMCE.triggerSave();
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Articulos/setArticulo'; 
        let formData = new FormData(formArticulo);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
           if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    document.querySelector("#containerGallery").classList.remove("d-none");
                    document.querySelector("#make").classList.remove("d-none");
                    document.querySelector("#list").classList.remove("d-none");

                    document.querySelector("#idArticulo").value = objData.idpost;
                    tableArticulo.api().ajax.reload();
                    //formArticulo.reset();
                    document.querySelector('#btnCancel').innerHTML ="Regresar";
                    document.querySelector("#btnCancel").classList.replace("btn-danger","btn-secondary");
                    
                    swal("Articulos", objData.msg ,"success");
                    
                    //removePhoto();
                }else{
                    swal("Error", objData.msg , "error");
                }              
            }
            divLoading.style.display = "none";
            return false; 
        }

    }

    if(document.querySelector("#btnTag")){
        let btnTag = document.querySelector("#btnTag");
        btnTag.onclick = function(){
            let nameTag = document.querySelector("#txtTag").value;
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
            let ajaxUrl = base_url+"/Articulos/setTag/"+nameTag;
            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if(request.status == 200 && request.readyState == 4){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status){
                        swal("Etiqueta",objData.msg,"success");
                        fntTags();
                        document.querySelector("#txtTag").value="";
                    }else{
                        swal("Error", objData.msg,"error");
                    }
                }
            }
        }
    }
    if(document.querySelector("#listTag")){
        let addtag = document.querySelector("#listTag");
        addtag.onchange = function(){
            let key = Date.now();
            let value = document.querySelector("#listTag").value;
            let idPost = document.querySelector("#idArticulo").value;
            
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
            let ajaxUrl = base_url+"/Articulos/setSelectTag";
            let formData = new FormData();

            formData.append("idtag",value);
            formData.append("idpost",idPost);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.status == 200 && request.readyState == 4){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status){
                        let text = $( "#listTag option:selected" ).text();
                        let newElement = document.createElement("div");
                        newElement.id = "div"+key;
                        newElement.innerHTML = `
                            <input type="hidden" value="${value}" id="tag${key}">
                            <button  class="btnDeleteTag btn-outline-secondary btn-sm" 
                            type="button" onclick="fntDelTag('#div${key}')">${text}</button>
                            `
                        document.querySelector("#containerTags").appendChild(newElement);
                    }else{
                        swal("Atención",objData.msg,"warning");
                    }
                }
            }
        }
    }

    if(document.querySelector(".btnAddImage")){
        let btnAddImage =  document.querySelector(".btnAddImage");
        btnAddImage.onclick = function(e){
         let key = Date.now();
         let newElement = document.createElement("div");
         newElement.id= "div"+key;
         newElement.innerHTML = `
             <div class="prevImage"></div>
             <input type="file" name="foto" id="img${key}" class="inputUploadfile">
             <label for="img${key}" class="btnUploadfile"><i class="fas fa-upload "></i></label>
             <button class="btnDeleteImage d-none" type="button" onclick="fntDelItem('#div${key}')"><i class="fas fa-trash-alt"></i></button>`;
         document.querySelector("#containerImages").appendChild(newElement);
         document.querySelector("#div"+key+" .btnUploadfile").click();
         fntInputFile();
        }
    }
    fntInputFile();
    fntCategorias();
    fntTags();
},false);

function fntInputFile(){
    let inputUploadfile = document.querySelectorAll(".inputUploadfile");
    inputUploadfile.forEach(function(inputUploadfile) {
        inputUploadfile.addEventListener('change', function(){
            let idArticulo = document.querySelector("#idArticulo").value;
            let parentId = this.parentNode.getAttribute("id");
            let idFile = this.getAttribute("id");            
            let uploadFoto = document.querySelector("#"+idFile).value;
            let fileimg = document.querySelector("#"+idFile).files;
            let prevImg = document.querySelector("#"+parentId+" .prevImage");
            let nav = window.URL || window.webkitURL;
            if(uploadFoto !=''){
                let type = fileimg[0].type;
                let name = fileimg[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
                    prevImg.innerHTML = "Archivo no válido";
                    uploadFoto.value = "";
                    return false;
                }else{
                    let objeto_url = nav.createObjectURL(this.files[0]);
                    prevImg.innerHTML = `<img class="loading" src="${base_url}/Assets/images/loading/loading.svg" >`;

                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url+'/Articulos/setImage'; 
                    let formData = new FormData();
                    formData.append('idArticulo',idArticulo);
                    formData.append("foto", this.files[0]);
                    request.open("POST",ajaxUrl,true);
                    request.send(formData);
                    request.onreadystatechange = function(){
                        if(request.readyState != 4) return;
                        if(request.status == 200){
                            let objData = JSON.parse(request.responseText);
                            if(objData.status){
                                prevImg.innerHTML = `<img src="${objeto_url}">`;
                                document.querySelector("#"+parentId+" .btnDeleteImage").setAttribute("imgname",objData.imgname);
                                document.querySelector("#"+parentId+" .btnUploadfile").classList.add("d-none");
                                document.querySelector("#"+parentId+" .btnDeleteImage").classList.remove("d-none");
                            }else{
                                swal("Error", objData.msg , "error");
                            }
                        }
                    }

                }
            }

        });
    });
}
function fntDelItem(element){
    let nameImg = document.querySelector(element+' .btnDeleteImage').getAttribute("imgname");
    let idArticulo = document.querySelector("#idArticulo").value;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Articulos/delFile'; 

    let formData = new FormData();
    formData.append('idarticulo',idArticulo);
    formData.append("file",nameImg);
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function(){
        if(request.readyState != 4) return;
        if(request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                let itemRemove = document.querySelector(element);
                itemRemove.parentNode.removeChild(itemRemove);
            }else{
                swal("", objData.msg , "error");
            }
        }
    }
}
function fntDelTag(element){
    let idTag = document.querySelector(element+' input').value;
    let idArticulo = document.querySelector("#idArticulo").value; 
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url+"/Articulos/delSelectTag";
    let formData = new FormData();

    formData.append("idtag",idTag);
    formData.append("idpost",idArticulo);
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function(){
        if(request.status == 200 && request.readyState == 4){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                let itemRemove = document.querySelector(element);
                itemRemove.parentNode.removeChild(itemRemove);
            }else{
                swal("", objData.msg , "error");
            }
        }
    }
}


/*if(document.querySelector(".methodImage")){
    let op = document.querySelectorAll(".methodImage");
    op.forEach(function(op){
        op.addEventListener('click',function(){
            if(this.value == "url"){
                document.querySelector("#cargaUrl").classList.remove("d-none");
                document.querySelector("#cargaArchivo").classList.add("d-none");
            }else{
                document.querySelector("#cargaArchivo").classList.remove("d-none");
                document.querySelector("#cargaUrl").classList.add("d-none");
            }
        });  
    });
}*/

tinymce.init({
    relative_urls: 0,
    remove_script_host: 0,
	selector: '#txtDescripcion',
	width: "100%",
    height: 400,    
    statubar: true,
    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table directionality emoticons template paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
});

function fntViewInfo(idcategoria){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl  = base_url+'/Articulos/getArticulo/'+idcategoria;
    request.open("GET",ajaxUrl ,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                let estado = objData.data.status == 1 ? 
                        '<span class="badge badge-success">Activo</span>' : 
                        '<span class="badge badge-danger">Inactivo</span>';
                
                let url = base_url+'/Publicaciones/articulo/'+objData.data.idpost+'/'+objData.data.route;
                document.querySelector('#link').setAttribute("href",url)
                document.querySelector("#celId").innerHTML = objData.data.idpost;
                document.querySelector("#celNombre").innerHTML = objData.data.title;
                document.querySelector("#celAutor").innerHTML = objData.data.autor;
                document.querySelector("#celCategoria").innerHTML = objData.data.categoria;
                //document.querySelector("#celDescripcion").innerHTML = objData.data.description;
                document.querySelector("#celEstado").innerHTML = estado;
                document.querySelector("#celFecha").innerHTML = objData.data.date;
                document.querySelector("#imgArticulo").innerHTML = '<img src="'+objData.data.image+'"></img>';
                $('#modalViewArticulo').modal('show');
                
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditInfo(idarticulo){

    //rowTable = element.parentNode.parentNode.parentNode;

    document.querySelector('#pills-make-tab').innerHTML ="Actualizar artículo";
    document.querySelector('#pills-make-tab').classList.add("active");
    document.querySelector('#pills-make').classList.add("active","show");
    document.querySelector('#pills-articles').classList.add("d-none");
    document.querySelector('#pills-articles-tab').classList.add("d-none");
    document.querySelector('#pills-paper').classList.add("d-none");
    document.querySelector('#pills-paper-tab').classList.add("d-none");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl  = base_url+'/Articulos/getArticulo/'+idarticulo;
    request.open("GET",ajaxUrl ,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){

                let objDataTag = objData.data;
                let objDataImg = objData.data;
                let htmlTags="";
                let htmlImage="";
                document.querySelector('#idArticulo').value = objData.data.idpost;
                document.querySelector("#txtNombre").value = objData.data.title;
                document.querySelector("#txtDescripcion").value = objData.data.description;
                document.querySelector('#listCategoria').value = objData.data.topics_id;
                tinymce.activeEditor.setContent(objData.data.description); 
                
                $('#listCategoria').selectpicker('render');

                if(objData.data.status == 1){
                    document.querySelector("#listStatus").value = 1;
                }else{
                    document.querySelector("#listStatus").value = 2;
                }
                $('#listStatus').selectpicker('render');

                if(objDataImg.img.length > 0){
                    let objDataImages = objDataImg.img;
                    for (let p = 0; p < objDataImages.length; p++) {
                        let key = Date.now()+p;
                        htmlImage +=`<div id="div${key}">
                            <div class="prevImage">
                            <img src="${objDataImages[p].url}"></img>
                            </div>
                            <button type="button" class="btnDeleteImage" onclick="fntDelItem('#div${key}')" imgname="${objDataImages[p].name}">
                            <i class="fas fa-trash-alt"></i></button></div>`;
                    }
                    
                }

                if(objDataTag.tags.length){
                    let objDataTags = objDataTag.tags;
                    for (let p = 0; p < objDataTags.length; p++) {
                        let key = Date.now()+p;
                        htmlTags += `<div id="div${key}">
                            <input type="hidden" value="${objDataTags[p].tag_id}" id="tag${key}">
                            <button  class="btnDeleteTag btn-outline-secondary btn-sm" 
                            type="button" onclick="fntDelTag('#div${key}')">#${objDataTags[p].tagtitle}</button></div>
                            `
                    }
                }

                document.querySelector("#containerTags").innerHTML = htmlTags;
                document.querySelector("#containerImages").innerHTML = htmlImage;
                document.querySelector("#containerGallery").classList.remove("d-none");
                /*if(document.querySelector("#btnActionForm")){
                    let btnAction = document.querySelector("#btnActionForm");
                    btnAction.onclick = function(){
                        
                    }
                }*/
                document.querySelector("#make").classList.remove("d-none");
                document.querySelector("#list").classList.remove("d-none");

            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}
function fntRecoveryInfo(idarticulo){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url+"/articulos/getRecoveryArticulo/"+idarticulo;
    //let strData = "idArticulo="+idarticulo;
     request.open("GET",ajaxUrl,true);
     //request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
     request.send();
     divLoading.style.display = "flex";
     request.onreadystatechange = function(){
         if(request.status == 200 && request.readyState == 4){
             let objData = JSON.parse(request.responseText);
             if(objData.status){
                 swal("Papelera",objData.msg, "success");
                 tableArticulo.api().ajax.reload();
                 tablePapelera.api().ajax.reload();
             }else{
                swal("Atención",objData.msg, "error");
             }
         }
         divLoading.style.display = "none";
     }
}

function fntDelfEver(idarticulo){

    swal({
        title: "Eliminar",
        text: "¿Estas segur@? Se eliminará para siempre...",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if(isConfirm){
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject("Microsoft.XMLHTTP");
            let ajaxUrl = base_url+"/articulos/deleteRecovery/"+idarticulo;
            request.open("GET",ajaxUrl,true);
            request.send();
            divLoading.style.display = "flex";
            request.onreadystatechange= function(){
                if(request.status == 200 && request.readyState == 4){
                    objData = JSON.parse(request.responseText);
                    if(objData.status){
                        swal("Eliminado",objData.msg,"success");
                        tablePapelera.api().ajax.reload();
                    }else{
                        swal("Atención",objData.msg,"error");
                    }
                }
                divLoading.style.display = "none";
            }
        }

    });

}

function fntDelInfo(idarticulo){

    swal({
        title: "Eliminar",
        text: "¿Estas segur@?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Articulos/delArticulo/'+idarticulo;
            let strData = "idArticulo="+idarticulo;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            divLoading.style.display = "flex";
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminado", objData.msg , "success");
                        tableArticulo.api().ajax.reload();
                        tablePapelera.api().ajax.reload();
                    }else{
                        swal("Atención", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
            }
        }

    });
}

function fntCategorias(){
    if(document.querySelector('#listCategoria')){

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl  = base_url+'/Categorias/getSelectCategorias';
        request.open("GET",ajaxUrl ,true);
        request.send(); 
    
        request.onreadystatechange = function(){
            if(request.readyState ==4 && request.status ==200){
                document.querySelector('#listCategoria').innerHTML = request.responseText;
                $('#listCategoria').selectpicker('render');
            }
        }
    }
}
function fntTags(){
    if(document.querySelector('#listTag')){
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl  = base_url+'/Articulos/getSelectTags';
        request.open("GET",ajaxUrl ,true);
        request.send(); 
    
        request.onreadystatechange = function(){
            if(request.readyState ==4 && request.status ==200){
                document.querySelector('#listTag').innerHTML = request.responseText;
                $('#listTag').selectpicker('refresh');
                $('#listTag').selectpicker({
                    noneSelectedText : 'Seleccione...'
                })
            }
        }
    }
}

/*function removePhoto(){
    document.querySelector('#foto').value ="";
    document.querySelector('.delPhoto').classList.add("notBlock");
    if(document.querySelector('#img')){
        document.querySelector('#img').remove();
    }
}*/
