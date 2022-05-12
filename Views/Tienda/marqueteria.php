<?php
    headerPage($data);
    //dep($data['molduras']);exit;
?>
    <main id="<?=$data['page_name']?>">
        <div class="container measures mt-4">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="measures__container ">
                        <div class="measures__frame">
                            <img src="<?=media()?>/template/Assets/images/uploads/logo.png" alt="">
                        </div>
                        <div class="measures__margin">

                        </div>
                        <!--<label for="measuresImg"><a class="btn btn-info btnUp">Subir foto</a></label>
                        <input class="d-none" type="file" id="measuresImg" name="measuresImg"> -->
                        <div class="measures__zoom w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <i class="fas fa-search-minus"></i>
                                <input type="range" class="form-range me-4 ms-4" min="10" max="200" id="rangeZoom" value="100">
                                <i class="fas fa-search-plus"></i>
                            </div> 
                            <p id="rangeZoomData" class="text-center m-0">100%</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pages mb-4">
                    <div class="measures__dimensions page active">
                        <h1 class="text-center fs-4 text__color"><strong>Enmarcación en línea, enmarca sin salir de casa</strong></h1>
                        <h2 class="fs-5 mt-4 text-center">Ingresa las dimensiones de tu obra <span class="guide" title="Ayuda">?</span></h2>
                        <div class="btn_number flex-column align-items-center">
                            <p class="text__color fs-4"><strong>Alto (cm)</strong></p>
                            <p class="text-secondary">min 10.0cm - max 200.0cm</p>
                            
                            <div class="d-flex align-items-center pr-2 mt-2">
                                <input  type="number" id="intHeight" value="10" min="10">
                            </div>
                        </div>
                        <div class="btn_number flex-column align-items-center">
                            <p class="text__color fs-4"><strong>Ancho (cm)</strong></p>
                            <p class="text-secondary">min 10.0cm - max 200.0cm</p>
                            <div class="d-flex align-items-center pr-2 mt-2">
                                <input  type="number" id="intWidth" value="10" min="10">
                            </div>
                        </div>
                    </div>
                    <div class="measures__custom d-none page">
                        <div class="d-flex justify-content-between flex-wrap mt-3 mb-3 align-items-center">
                            <h2 class="fs-5 text__color m-0"><strong>Diseña tu marco</strong></h2>
                            <p class="fs-5 price m-0"></p>
                        </div>
                        <div class="d-flex">
                            <p class="me-2"><strong>Elige el material y la moldura</strong> <span class="guide" title="Ayuda">?</span></p>
                            <p id="selectFrame"></p>
                        </div>
                        <div>
                            <select class="form-select mb-4" aria-label="Default select example" id="selectType">
                                <option selected>Seleccione material</option>
                                <option value="1">Molduras en madera</option>
                                <option value="2">Molduras importadas</option>
                            </select>
                            <div class="row mb-4 d-none" id="selectMoldura">
                                <div class="col-md-6 mb-2">
                                    <input class="form-control" type="search" placeholder="buscar" aria-label="Search" id="search" name="search">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <select class="form-control form-control" aria-label="Default select example" id="orderBy" name="orderBy">
                                        <option value="1">Ordenar por</option>
                                        <option value="2">Molduras delgadas</option>
                                        <option value="3">Molduras medianas</option>
                                        <option value="4">Molduras anchas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="scroll_list d-flex flex-wrap justify-content-center position-relative" id="selectFrames">
                            </div>
                        </div>
                    </div>
                    <div class="measures__margin__custom d-none page">
                        <div class="d-flex justify-content-between mt-3 mb-3 align-items-center">
                            <h2 class="fs-5 text__color m-0"><strong>Diseña tu marco</strong></h2>
                            <p class="fs-5 price m-0"></p>
                        </div>
                        <p><strong>Elige el tipo de margen </strong><span class="guide" title="Ayuda">?</span></p>
                        <select class="form-select" aria-label="Default select example" id="selectMargin">
                            <option value="1">Sin margen</option>
                            <option value="2">Caribe</option>
                            <option value="3">Passepartout</option>
                        </select>
                        <div class="mt-3 rangeInfo d-none">
                            <p class="m-0"><strong>Ajusta el margen</strong></p>
                            <label for="exampleFormControlInput1" class="form-label"></label>
                            <input type="range" class="form-range" min="0" max="10" id="rangeFrame" value="0">
                            <div class="d-flex justify-content-end">
                                <p id="rangeData" class="m-0">0 cm</p>
                            </div>
                        </div>
                        <div class="color_margin mt-2 d-none">
                            <div class="d-flex">
                                <p class="me-2"><strong>Elige el color:</strong></p>
                                <p id="selectedMarginColor"></p>
                            </div>
                            <div class="scroll_listX d-flex justify-content-start"></div>
                        </div>
                    </div>
                    <div class="measures__border__custom d-none page">
                        <div class="d-flex justify-content-between mt-3 mb-3 align-items-center">
                            <h2 class="fs-5 text__color m-0"><strong>Diseña tu marco</strong></h2>
                            <p class="fs-5 price m-0"></p>
                        </div>
                        <div class="mt-3 d-none" id="border">
                            <p><strong>Elige el borde interno</strong> <span class="guide" title="Ayuda">?</span></p>
                            <select class="form-select" aria-label="Default select example" id="selectBorder">
                                <option value="1">Sin borde</option>
                                <option value="2">Bocel</option>
                                <option value="3">Bastidor</option>
                            </select>
                            <div class="color_border mt-3 d-none">
                                <div class="d-flex">
                                    <p class="me-2"><strong>Elige el color:</strong></p>
                                    <p id="selectedBorderColor"></p>
                                </div>
                                <div class="scroll_listX d-flex justify-content-start"></div>
                            </div>
                        </div>
                        <div class="mt-3" id="glass">
                            <p><strong>Tipo de vidrio</strong> <span class="guide" title="Ayuda">?</span></p>
                            <select class="form-select" aria-label="Default select example" id="selectGlass">
                                <option value="1">Sin vidrio</option>
                                <option value="2">Antireflejo</option>
                            </select>
                        </div>
                    </div>
                    <div class="measures__description d-none page">
                        <h2 class="fs-5 text__color mt-2"><strong>Descripción</strong></h2>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Material de la moldura: </td>
                                    <td id="txtMolduras"></td>
                                </tr>
                                <tr>
                                    <td>Referencia de la moldura: </td>
                                    <td id="txtRef"></td>
                                </tr>
                                <tr>
                                    <td>Tipo de margen</td>
                                    <td id="txtMargen"></td>
                                </tr>
                                <tr>
                                    <td>Tipo de borde</td>
                                    <td id="txtBorde"></td>
                                </tr>
                                <tr>
                                    <td>Tipo de vidrio</td>
                                    <td id="txtVidrio"></td>
                                </tr>
                                <tr>
                                    <td>Margen</td>
                                    <td id="txtMargenMedida">0 cm</td>
                                </tr>
                                <tr>
                                    <td>Medidas de la imágen</td>
                                    <td id="txtMedidasImg"></td>
                                </tr>
                                <tr>
                                    <td>Medidas del marco</td>
                                    <td id="txtMedidasMarco"></td>
                                </tr>
                                <tr>
                                    <td>Precio: </td>
                                    <td id="txtPrice"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-2 ">
                            <input  type="number" id="addCant" class="me-4 text-center" value="1" min="1">
                            <button type="button" class="btn_content addCart"><i class="fas fa-shopping-cart"></i> Agregar</button>
                        </div>
                        <div class="accordion pt-4" id="accordionExample">
                            <p><strong>Información adicional</strong></p>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Tiempos de producción
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                    <ul>
                                        <li>
                                            <p>De acuerdo a la cantidad y moldura solicitada, se dará a conocer el tiempo estimado de producción
                                            a partir del siguiente día hábil de haber realizado y confirmado el pedido.
                                            </p>
                                        </li>
                                    </ul>
                                    <a href="<?=base_url()?>/terminos" target="_blank">Más información</a>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Tiempos de entrega
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                    Realizamos envíos directos en Villavicencio. Para zonas no cubiertas, realizamos envíos con diferentes transportadoras del país, 
                                    buscando siempre la mejor opción para nuestros clientes, 
                                    los tiempos pueden variar de 3 días hasta 5 días hábiles según la ciudad o municipio destino, 
                                    normalmente en ciudades principales las transportadoras entregan máximo en 3 días hábiles. 
                                    <a href="<?=base_url()?>/terminos" target="_blank">Más información</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-4 mb-4">
                <button class="btn_content me-4 d-none" id="btnPrevious">Atrás</button>
                <button class="btn_content" id="btnNext">Siguiente</button>
            </div>
        </div>
        
    </main>
    <button class="btn__guide">Ayuda</button>
    <div class="guide__panel">
        <div class="guide__panel__close d-flex justify-content-between">
            <p class="m-0">Ayuda</p>
            <p class="m-0">x</p>
        </div>
        <p class="text-center"><strong>Haz click en las siguientes opciones para resolver tus dudas</strong></p>
        <div class="accordion scrollY" id="accordionExample" >
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Dimensiones
                </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <p><strong>Precisión: </strong> nuestra aplicación tiene una precisión de 0.1cm, por ejemplo: 20cm X 20cm, 20.5cm X 20.5cm</p>
                        <p><strong>Toma de medidas:</strong> puedes medir el alto y ancho de tu obra con una cinta métrica o con un metro.</p>
                        <img src="<?= media();?>/images/uploads/dimensiones.jpeg" alt="dimensiones" style="width:100%; height:300px;">
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Material y moldura
                </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <p><strong>Molduras en madera:</strong> son hechas a mano y su resistencia es mayor.</p>
                        <p>
                            <strong>Molduras importadas:</strong> son hechas de poliestireno, su resistencia depende del tamaño de la enmarcación y anchura de la moldura.<br>
                            <ul>
                                <li><strong>Molduras delgadas:</strong> recomendadas para enmarcaciones no mayores a 50cm X 50cm</li>
                                <li><strong>Molduras medianas:</strong> recomendadas para enmarcaciones no mayores a 100cm X 100cm</li>
                                <li><strong>Molduras anchas:</strong> recomendadas para enmarcaciones mayores a 100cm X 100cm</li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Margen
                </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <p>
                            <strong>Margen:</strong> es el espacio que hay entre el marco y la obra.<br>
                            <ul>
                                <strong>Tipo de margen:</strong>
                                <li><strong>Caribe:</strong> hecho de triplex con variedad de colores</li>
                                <li><strong>Passepartout:</strong> hecho a mano con cartón paja y opalina de único color, recomendado para fotografías, diplomas o títulos.</li>
                            </ul>
                        </p>
                        <img src="<?= media();?>/images/uploads/enmarcacion.png" alt="enmarcación" style="width:100%; height:300px;">
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    Borde interno
                </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <p>
                            <strong>Borde interno:</strong> es un borde decorativo que viene en bocel o bastidor. 
                            <i><strong>Nota</strong>: esta opción se habilita si elige agregar margen a la enmarcación.</i><br>
                            <ul>
                                <strong>Tipo de borde:</strong>
                                <li class="mt-1">
                                    <strong>Bocel de madera:</strong> bocel de 4mm, recomendado para fotografías, diplomas o títulos.<br>
                                    <img src="<?= media();?>/images/uploads/bocel.png" alt="bocel de madera" class="mt-1" style="width:100%; height:250px;">
                                </li>
                                <li class="mt-1">
                                    <strong>Bastidor:</strong> bastidor de madera de 2.5cm X 2.5cm X 2.5cm, recomendado para fotografías, diplomas, títulos y obras sobre lienzo.<br>
                                    <img src="<?= media();?>/images/uploads/bastidor.png" alt="bastidor de madera" class="mt-1" style="width:100%; height:250px;">
                                </li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                   Vidrio
                </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                    <p>
                        <strong>Vidrio antireflejo:</strong> es un vidrio que corta la reflexión de la luz visible permitiendo que pase mucha luz a través del vidrio,
                        aumentando la visibilidad de la obra y protección de la misma. Recomendado para fotografías, diplomas o títulos.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
    footerPage($data);
?>