<?php
require_once PATH_CONFIG;
require_once PATH_START;

$page = (string) $_POST['page'];
if (isset($_GET['page'])) $page = $_GET['page']; ?>

<div class="div-login-cadastrar">
    <div id="div-login">
        <?php include "./login.php" ?>
    </div>
    <div id="div-cadastro">
        <?php include "./cadastro.php" ?>
    </div>
    <div id="div-esqueceu-senha">
        <?php include "./esqueceu_senha.php" ?>
    </div>
</div>

<script defer src="<?php echo URL_BASE_JS; ?>login_cadastro.js?v=<?php echo VERSION_JS_CSS ?>"></script>
<script type="text/javascript" defer>
    window.onload = function() {
        switchLogin("<?php echo $page ?>");
    };
</script>

<?php
require PATH_END;
?>
