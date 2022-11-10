<?php
    headerAdmin($data);
?>
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
        <img src="..." class="rounded me-2" alt="..." height="20" width="20">
        <strong class="me-auto" id="toastProduct"></strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
        Hello, world! This is a toast message.
        </div>
    </div>
</div>
<div class="card mb-4">
    <div class="card-body">
        <a href="<?=base_url()?>/pedidos" class="btn btn-primary"><i class="fas fa-arrow-circle-left"></i> Regresar</a>
    <?=$data['option']?>
    </div>
</div>
<script>
    if(document.querySelector("#addFrame")){
        document.querySelector("#addFrame").setAttribute("id","addMarco");
        let addMarco = document.querySelector("#addMarco");
        const toastLiveExample = document.getElementById('liveToast');
        addMarco.addEventListener("click",function(){
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

            addMarco.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
            addMarco.setAttribute("disabled","");

            request(base_url+"/marcos/addCart",formData,"post").then(function(objData){
                addMarco.innerHTML=`Agregar`;
                addMarco.removeAttribute("disabled");
                if(objData.status){
                    const toast = new bootstrap.Toast(toastLiveExample);
                    toast.show();
                    
                    document.querySelector(".toast-header img").src=objData.data.image;
                    document.querySelector(".toast-header img").alt=objData.data.name;
                    document.querySelector("#toastProduct").innerHTML=objData.data.name;
                    document.querySelector(".toast-body").innerHTML=objData.msg;
                }
            });
        }); 
    }
</script>
<?php
    footerAdmin($data);
?>

