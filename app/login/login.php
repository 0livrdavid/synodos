<div class="logo-login-cadastro">
    <div class="logo-login-cadastro">
        <img src="<?php echo URL_BASE_ASSETS_PICTURES; ?>InfoWorks_logo.png" alt="" srcset="">
    </div>
</div>
<div class="center">
    <h1>Entrar</h1>
    <div id="form" class="form_login">
        <p id="msg_login" class="msg_login"></p>
        <div class="txt_field">
            <input id="cpf_login" name="cpf" type="text" class="mask-cpf" minlength="11" maxlength="14" data-name="CPF" required>
            <span></span>
            <label for="cpf">CPF</label>
        </div>
        <div class="txt_field">
            <input name="password" type="password" data-name="Senha" required>
            <span></span>
            <label for="password">Senha</label>
        </div>
        <div class="pass" onclick="location.href='?page=esqueceu_senha'">Esqueceu sua senha?</div>
        <input name="tipo" type="submit" value="Login" onclick="searchUser(event.target.parentNode);">
        <div id="signup_link">
            <p>Ainda não possui uma conta? <a href="#" id="button_cadastrar" onclick="location.href='?page=cadastro'">Cadastrar</a>.</p>
            <p><a href="../dashboard/">Voltar</a> à Página Inicial.</p>
        </div>
    </div>
</div>