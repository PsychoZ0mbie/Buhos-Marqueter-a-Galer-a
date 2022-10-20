<?php headerAdmin($data)?>
<div id="modalItem"></div>
<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center"><?=$data['page_title']?></h2>
                <button type="button" class="btn btn-success text-white" id="exportExcel" data-name="table<?=$data['page_title']?>" title="Export to excel" ><i class="fas fa-file-excel"></i></button>
                <div class="row mb-3">
                    <div class="col-md-6 mt-3">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search" id="search" name="search">
                    </div>
                </div>
                <div class="scroll-y">
                    <table class="table text-center items align-middle" id="table<?=$data['page_title']?>">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Costo</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody id="listItem">
                            <?=$data['colores']['data']?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php footerAdmin($data)?>        