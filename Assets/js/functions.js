function uploadImg(img,location){
    let imgUpload = img.value;
    let fileUpload = img.files;
    let type = fileUpload[0].type;
    if(type != "image/png" && type != "image/jpg" && type != "image/jpeg"){
        imgUpload ="";
        Swal.fire("Error","El archivo es incorrecto.","error");
    }else{
        let objectUrl = window.URL || window.webkitURL;
        let route = objectUrl.createObjectURL(fileUpload[0]);
        document.querySelector(location).setAttribute("src",route);
    }
}

async function request(url,requestData,option){
    let data ="";
    if(option==1){
        option = {
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