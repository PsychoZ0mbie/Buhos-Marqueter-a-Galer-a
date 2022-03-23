let tableProductos;
let rowTable;
let divLoading = document.querySelector("#divLoading");
$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});
tableProductos = $('#tableProductos').dataTable( {
    "aProcessing":true,
    "aServerSide":true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax":{
        "url": " "+base_url+"/Galeria/getProductos",
        "dataSrc":""
    },
    "columns":[
        {"data":"reference"},
        {"data":"title"},
        {"data":"categoria"},
        {"data":"tecnica"},
        {"data":"medidas"},
        {"data":"price"},
        {"data":"stock"},
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
    "order":[[8,"desc"]]  
});

tablePapelera = $('#tablePaper').dataTable( {
    "aProcessing":true,
    "aServerSide":true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax":{
        "url": " "+base_url+"/Galeria/getPapelera",
        "dataSrc":""
    },
    "columns":[
        {"data":"reference"},
        {"data":"title"},
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
    if(document.querySelector("#pills-make-tab")){
        let btn = document.querySelector("#pills-make-tab");
        btn.onclick = function(){
            document.querySelector('#pills-make-tab').classList.add("active");
            document.querySelector('#pills-make').classList.add("active","show");
            document.querySelector('#pills-products').classList.add("d-none");
            document.querySelector('#pills-products-tab').classList.add("d-none");
            document.querySelector('#pills-paper').classList.add("d-none");
            document.querySelector('#pills-paper-tab').classList.add("d-none");
        }
    }
    let formProducto = document.querySelector("#formProducto");
    document.querySelector("#containerGallery").classList.add("d-none");
    formProducto.onsubmit = function(e) {
        e.preventDefault();
        let strNombre = document.querySelector("#txtNombre").value;
        let intLargo = document.querySelector("#txtLargo").value;
        let intAncho = document.querySelector("#txtAncho").value;
        let strDescripcion = document.querySelector('#txtDescripcion').value;
        let intCategoria = document.querySelector('#listCategoria').value;
        let intPrecio = document.querySelector('#txtPrecio').value;
        let intCantidad = document.querySelector('#txtCantidad').value;
        let intTecnica = document.querySelector('#listTecnica').value;
        let intStatus = document.querySelector('#listStatus').value;        
        if(strNombre == '' || intLargo == '' || intAncho == '' || intPrecio == '' || intCantidad == '' 
        || intStatus == '' || intTecnica == '' || intCategoria == ''){
        
            swal("Atención", "Todos los campos son obligatorios." , "error");
            return false;
        }
        if(strNombre.length > 70){
            swal("Atención", "El título permite máximo 70 carácteres" , "error");
            return false;
        }

        divLoading.style.display = "flex";
        tinyMCE.triggerSave();
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Galeria/setProducto'; 
        let formData = new FormData(formProducto);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
           if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    document.querySelector("#containerGallery").classList.remove("d-none");
                    document.querySelector("#idProducto").value = objData.idproducto;
                    tableProductos.api().ajax.reload();
                    //formProducto.reset();
                    document.querySelector('#btnActionForm').classList.add("d-none");
                    document.querySelector('#btnCancel').innerHTML ="Regresar";
                    document.querySelector("#btnCancel").classList.replace("btn-danger","btn-secondary");
                    
                    swal("Productos", objData.msg ,"success");
                    
                    //removePhoto();
                }else{
                    swal("Error", objData.msg , "error");
                }              
            }
            divLoading.style.display = "none";
            return false; 
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
    fntTecnicas();
},false);

function fntInputFile(){
    let inputUploadfile = document.querySelectorAll(".inputUploadfile");
    inputUploadfile.forEach(function(inputUploadfile) {
        inputUploadfile.addEventListener('change', function(){
            let idProducto = document.querySelector("#idProducto").value;
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
                    let ajaxUrl = base_url+'/Galeria/setImage'; 
                    let formData = new FormData();
                    formData.append('idProducto',idProducto);
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
    let idProducto = document.querySelector("#idProducto").value;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Galeria/delFile'; 

    let formData = new FormData();
    formData.append('idProducto',idProducto);
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
    let ajaxUrl  = base_url+'/Galeria/Productos/getArticulo/'+idcategoria;
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

function fntEditInfo(idproducto){

    //rowTable = element.parentNode.parentNode.parentNode;

    document.querySelector('#pills-make-tab').innerHTML ="Actualizar producto";
    document.querySelector('#pills-make-tab').classList.add("active");
    document.querySelector('#pills-make').classList.add("active","show");
    document.querySelector('#pills-products').classList.add("d-none");
    document.querySelector('#pills-products-tab').classList.add("d-none");
    document.querySelector('#pills-paper').classList.add("d-none");
    document.querySelector('#pills-paper-tab').classList.add("d-none");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl  = base_url+'/Galeria/getProducto/'+idproducto;
    request.open("GET",ajaxUrl ,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){

                let objDataImg = objData.data;
                let htmlImage="";
                document.querySelector('#idProducto').value = objData.data.idproduct;
                document.querySelector("#txtNombre").value = objData.data.title;
                document.querySelector("#txtLargo").value = objData.data.length;
                document.querySelector("#txtAncho").value = objData.data.width;
                document.querySelector('#txtDescripcion').value = objData.data.description;
                document.querySelector('#listCategoria').value = objData.data.subtopicid;
                document.querySelector('#txtPrecio').value = objData.data.price;
                document.querySelector('#txtCantidad').value = objData.data.stock;
                document.querySelector('#listTecnica').value = objData.data.techniqueid;
                document.querySelector('#listStatus').value = objData.data.status;

                tinymce.activeEditor.setContent(objData.data.description); 
                
                $('#listCategoria').selectpicker('render');
                $('#listTecnica').selectpicker('render');

                if(objData.data.status == 1){
                    document.querySelector("#listStatus").value = 1;
                }else{
                    document.querySelector("#listStatus").value = 2;
                }
                $('#listStatus').selectpicker('render');

                if(objDataImg.img.length > 0){
                    let objDataImages = objDataImg.img;
                    console.log(objDataImg.img);
                    for (let p = 0; p < objDataImages.length; p++) {
                        let key = Date.now()+p;
                        htmlImage +=`<div id="div${key}">
                            <div class="prevImage">
                            <img src="${objDataImages[p].url}"></img>
                            </div>
                            <button type="button" class="btnDeleteImage" onclick="fntDelItem('#div${key}')" imgname="${objDataImages[p].title}">
                            <i class="fas fa-trash-alt"></i></button></div>`;
                    }
                    
                }

                document.querySelector("#containerImages").innerHTML = htmlImage;
                document.querySelector("#containerGallery").classList.remove("d-none");

            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}
function fntRecoveryInfo(idproducto){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url+"/Galeria/getRecoveryProducto/"+idproducto;
    //let strData = "idproducto="+idproducto;
     request.open("GET",ajaxUrl,true);
     //request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
     request.send();
     divLoading.style.display = "flex";
     request.onreadystatechange = function(){
         if(request.status == 200 && request.readyState == 4){
             let objData = JSON.parse(request.responseText);
             if(objData.status){
                 swal("Papelera",objData.msg, "success");
                 tableProductos.api().ajax.reload();
                 tablePapelera.api().ajax.reload();
             }else{
                swal("Atención",objData.msg, "error");
             }
         }
         divLoading.style.display = "none";
     }
}

function fntDelfEver(idproducto){

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
            let ajaxUrl = base_url+"/Galeria/deleteRecovery/"+idproducto;
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

function fntDelInfo(idproducto){

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
            let ajaxUrl = base_url+'/Galeria/delProducto/'+idproducto;
            let strData = "idproducto="+idproducto;
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
                        tableProductos.api().ajax.reload();
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
        let ajaxUrl  = base_url+'/Galeria/getSelectSubcategorias';
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
function fntTecnicas(){
    if(document.querySelector("#listTecnica")){

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() :new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Galeria/getSelectTecnica';
        request.open("GET",ajaxUrl,true);
        request.send();

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status ==200){
                document.querySelector("#listTecnica").innerHTML = request.responseText;
                $("#listTecnica").selectpicker("render");
            }
        }
    }
}
