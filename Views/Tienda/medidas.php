<?php
    headerPage($data);
    //dep($data['molduras']);exit;
?>
    <main id="<?=$data['page_name']?>">
        <div class="container measures mt-4">
            <div class="row">
                <div class="col-lg-6">
                    <div class="measures__container">
                        <div class="measures__frame">
                            <img src="<?=media()?>/template/Assets/images/uploads/logo.png" alt="">
                        </div>
                        <div class="measures__margin">

                        </div>
                        <label for="measuresImg"><a class="btn btn-info btnUp">Subir foto</a></label>
                        <input class="d-none" type="file" id="measuresImg" name="measuresImg"> 
                    </div>
                </div>
                <div class="col-lg-6 pages">
                    <div class="measures__dimensions page active">
                        <h1 class="text-center fs-3 text__color"><strong>Enmarca lo que desees!</strong></h1>
                        <h2 class="fs-5 mt-4 text-center">Ingresa las dimensiones de lo quieres enmarcar</h2>
                        <div class="btn_number flex-column align-items-center">
                            <p class="text__color fs-4"><strong>Alto (cm)</strong></p>
                            <p class="text-secondary">min 10cm - max 200cm</p>
                            <div class="d-flex align-items-center pr-2 mt-2">
                                <input  type="number" id="intHeight" value="10" min="10">
                            </div>
                        </div>
                        <div class="btn_number flex-column align-items-center">
                            <p class="text__color fs-4"><strong>Ancho (cm)</strong></p>
                            <p class="text-secondary">min 10cm - max 200cm</p>
                            <div class="d-flex align-items-center pr-2 mt-2">
                                <input  type="number" id="intWidth" value="10" min="10">
                            </div>
                        </div>
                    </div>
                    <div class="measures__custom d-none page">
                        <h2 class="fs-5 text__color mt-2"><strong>Diseña tu marco</strong></h2>
                        <p><strong>Elige el material y la moldura:</strong> </p>
                        <div class="accordion accordion-flush mb-3" id="accordionExample">
                            <div class="accordion-item">
                                
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Seleccione
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <select class="form-select" aria-label="Default select example" id="selectType">
                                            <option selected>Seleccione material</option>
                                            <option value="1">Molduras en madera</option>
                                            <option value="2">Molduras importadas</option>
                                        </select>
                                        <div class="scroll_list d-flex flex-wrap justify-content-center position-relative" id="selectFrames">
                                            <div id="divLoading" class="position-absolute top-0 start-0 w-100 h-100">
                                                <img src="<?= media();?>/images/loading/loading.svg" alt="Loading">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p><strong>Elige el tipo de margen y borde de la obra:</strong> </p>
                        <div class="accordion accordion-flush mb-3" id="accordionExample">
                            <div class="accordion-item">
                                
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                        Seleccione
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <select class="form-select" aria-label="Default select example" id="selectMargin">
                                            <option value="1">Sin margen</option>
                                            <option value="2">Fondo</option>
                                            <option value="3">Passepartout</option>
                                        </select>
                                        
                                        <div class="mt-3 rangeInfo d-none">
                                            <label for="exampleFormControlInput1" class="form-label">Ajusta el margen</label>
                                            <input type="range" class="form-range" min="1" max="10" id="rangeFrame" value="1">
                                            <div class="d-flex justify-content-end">
                                                <p id="rangeData" class="m-0">0 cm</p>
                                            </div>
                                        </div>
                                        <div class="color_margin mt-2 d-none">
                                            <label for="exampleFormControlInput1" class="form-label">Seleccione el color del fondo</label>
                                            <div class="scroll_listX d-flex justify-content-start">
                                                <div class="color_block color_margin_item"></div>
                                                <div class="color_block color_margin_item"></div>
                                                <div class="color_block color_margin_item"></div>
                                                <div class="color_block color_margin_item"></div>
                                                <div class="color_block color_margin_item"></div>
                                                <div class="color_block color_margin_item"></div>
                                                <div class="color_block color_margin_item"></div>
                                                <div class="color_block color_margin_item"></div>
                                                <div class="color_block color_margin_item"></div>
                                                <div class="color_block color_margin_item"></div>
                                            </div>
                                        </div>
                                        <select class="form-select mt-3 d-none" aria-label="Default select example" id="selectBorder">
                                            <option value="1">Sin borde</option>
                                            <option value="2">Borde con bocel de madera</option>
                                            <option value="3">Borde con marco de madera</option>
                                        </select>
                                        <div class="color_border mt-3 d-none">
                                            <label for="exampleFormControlInput1" class="form-label">Seleccione el color del borde</label>
                                            <div class="scroll_listX d-flex justify-content-start">
                                                <div class="color_block color_border_item"></div>
                                                <div class="color_block color_border_item"></div>
                                                <div class="color_block color_border_item"></div>
                                                <div class="color_block color_border_item"></div>
                                                <div class="color_block color_border_item"></div>
                                                <div class="color_block color_border_item"></div>
                                                <div class="color_block color_border_item"></div>
                                                <div class="color_block color_border_item"></div>
                                                <div class="color_block color_border_item"></div>
                                                <div class="color_block color_border_item"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="measures__description d-none page">
                        <h2 class="fs-5 text__color mt-2"><strong>Ficha técnica</strong></h2>
                    </div>
                </div>
                
            </div>
            <div class="d-flex justify-content-center mt-4">

                <button class="btn_content me-4" id="btnPrevious">Atrás</button>
                <button class="btn_content" id="btnNext">Siguiente</button>

            </div>
        </div>
        
    </main>
<?php 
    footerPage($data);
?>