<div class="logo-login-cadastro">
  <div class="logo-login-cadastro">
    <img src="<?php echo URL_BASE_ASSETS_PICTURES; ?>InfoWorks_logo.png" alt="" srcset="">
  </div>
</div>
<div class="center">
  <h1>Não possui uma conta?</h1>
  <div id="form" class="form_cadastro">
    <p id="msg_cadastro" class="msg_cadastro"></p>
    <div class="txt_field">
      <input type="text" name="nome" data-name="Nome completo" required>
      <span></span>
      <label for="nome">Nome completo</label>
    </div>
    <div class="txt_field">
      <input type="email" name="email" data-name="Email" required>
      <span></span>
      <label for="email">Email</label>
    </div>
    <div class="txt_field">
      <input type="text" name="cpf" class="mask-cpf" minlength="11" maxlength="14" data-name="CPF" required>
      <span></span>
      <label for="cpf">CPF</label>
    </div>
    <div class="txt_field">
      <input type="password" id="password" name="password" data-name="Senha" required>
      <span></span>
      <label for="password">Senha</label>
    </div>
    <div class="txt_field">
      <input type="password" id="confirm_password" name="confirm_password" data-name="Confirmar senha" required>
      <span></span>
      <label for="confirm_password">Confirmar senha</label>
    </div>
    <div class="txt_field">
      <input type="text" name="data_nascimento" class="mask-data" minlength="8" maxlength="10" data-name="Data de Nascimento" required>
      <span></span>
      <label for="data_nascimento">Data de Nascimento</label>
    </div>
    <input name="tipo" type="submit" value="Cadastro" onclick="createUser(event.target.parentNode);">
    <div id="signup_link">
      <p>Voltar para o <a href="#" id="button_cadastrar" onclick="location.href='?page=login'">Login</a>.</p>
      <p><a href="../dashboard/">Voltar</a> à Página Inicial.</p>
    </div>
  </div>
</div>