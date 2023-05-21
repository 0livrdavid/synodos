<div class="logo-login-cadastro">
    <div class="logo-login-cadastro">
        <img src="<?php echo URL_BASE_ASSETS_PICTURES; ?>InfoWorks_logo.png" alt="" srcset="">
    </div>
</div>
<div class="center">
    <h1>Esqueceu a senha?</h1>
    <div id="form" class="form_esqueceu_senha">
        <p id="msg_esqueceu_senha" class="msg_esqueceu_senha"></p>
        <div class="txt_field">
            <input name="cpf" type="text" class="mask-cpf" minlength="11" maxlength="14">
            <span></span>
            <label>CPF</label>
        </div>
        <input name="tipo" type="submit" value="Esqueceu a Senha">
        <div id="signup_link">
            <p>Voltar para o <a href="#" id="button_cadastrar" onclick="location.href='?page=login'">Login</a>.</p>
            <p><a href="../dashboard/">Voltar</a> à Página Inicial.</p>
        </div>
    </div>
</div>