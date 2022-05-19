<?php headerPage($data);?>

<main id="<?=$data['page_name']?>">
    <div class="container">
        <p class="fs-1 text-center">Cambiar contraseña</p>
        <form id="formReset" name="formReset" class="p-4">
            <input type="hidden" id="txtEmail" value="<?=$data['email']?>" required>
            <input type="hidden" id="txtToken" value="<?=$data['token']?>" required>
            <input type="hidden" id="idUsuario" value="<?=$data['idperson']?>" required>
            <div class="mb-3">
                <label for="txtPassword" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="contraseña">
            </div>
            <div class="mb-3">
                <label for="txtPasswordConfirm" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="txtPasswordConfirm" name="txtPasswordConfirm" placeholder="confirmar contraseña">
            </div>
            <button type="submit" class="btn_content" id="btnLogin">Actualizar</button>
        </form>
    </div>
</main>
<?php footerPage($data)?>

