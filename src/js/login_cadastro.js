$(document).ready(function() {
    $("#div-cadastro").css("display", "none");
});

function switchLogin (page) {
    if (page == "" || page == "login") {
        $("#div-login").css("display", "flex");
        $("#div-cadastro").css("display", "none");
        $("#div-esqueceu-senha").css("display", "none");
    } else if (page == "cadastro") {
        $("#div-login").css("display", "none");
        $("#div-cadastro").css("display", "flex");
        $("#div-esqueceu-senha").css("display", "none");
    } else if (page == "esqueceu_senha") {
        $("#div-login").css("display", "none");
        $("#div-cadastro").css("display", "none");
        $("#div-esqueceu-senha").css("display", "flex");
    }
}

function login_switch() {
    if ($("#box-login-login").hasClass('hidde')) {
        $("#box-login-recupera").fadeOut(320);
        $("#box-login-login").removeClass('hidde');
        setTimeout(function () {
            $("#box-login-login").fadeIn(320);
        }, 325);
    } else {
        $("#box-login-login").addClass('hidde');
        $("#box-login-login").fadeOut(320);
        setTimeout(function () {
            $("#box-login-recupera").fadeIn(320);
        }, 325);
    }
}

function createUser(div_form) {
    const form = div_form;
    fields = {};
    fields['acao'] = "Cadastro";

    function validateFormCadastro(form) {
        const requiredFields = form.querySelectorAll('[required]');
        let passwordValue = null;
        let confirmPasswordValue = null;

        for (let i = 0; i < requiredFields.length; i++) {
            const field = requiredFields[i];
            if (field.id === 'password') passwordValue = field.value;
            if (field.id === 'confirm_password') confirmPasswordValue = field.value;

            fields[field.name] = field.value;

            if (!field.value) {
                toastr['warning'](`Por favor, preecha o campo "${field.dataset.name}".`, "Atenção");
                field.focus();
                return false;
            }

            if (field.name == "data_nascimento") {
                if (!isValidDate(field.value, field.dataset.name)) {
                    field.focus();
                    return false;
                }
            }

            if (field.name == "cpf") {
                if (!isValidCPF(field.value, field.dataset.name)) {
                    field.focus();
                    return false;
                }
            }
        }

        function validateFormPassword(){
            if(passwordValue!==confirmPasswordValue) {
                toastr['warning']("Senhas não coincidem!");
                return false;
            }
            return true;
        }

        if (!validateFormPassword()) {
            return false;
        }

        return true;
    }


    if (!validateFormCadastro(form)) {
        toastr['error']("Suas informações de cadastro não estão corretas e/ou está faltando informação!");
        return null;
    } else {
        $.ajax({
            method: "POST",
            datatype: "json",
            url: "../../ajax/login_cadastro/cadastro.php",
            data: fields,
            success: function (response) {
                response = JSON.parse(response);
                if (response.flag) {
                    $("#cpf_login").val(fields['cpf']);
                    switchLogin('login');
                    toastr["success"](response.msg);
                } else {
                    toastr['warning'](response.msg);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr['error'](textStatus, errorThrown);
            }
        });
    }
}

function searchUser(div_form) {
    const form = div_form;
    fields = {};
    fields['acao'] = "Login";

    function validateFormLogin(form) {
        const requiredFields = form.querySelectorAll('[required]');

        for (let i = 0; i < requiredFields.length; i++) {
            const field = requiredFields[i];
            fields[field.name] = field.value;

            if (!field.value) {
                toastr['warning'](`Por favor, preecha o campo "${field.dataset.name}".`, "Atenção");
                field.focus();
                return false;
            }

            if (field.name == "cpf") {
                if (!isValidCPF(field.value, field.dataset.name)) {
                    field.focus();
                    return false;
                }
            }
        }

        return true;
    }

    if (!validateFormLogin(form)) {
        toastr['error']("Suas informações de login não estão corretas e/ou está faltando informação!");
        return null;
    } else {
        $.ajax({
            method: "POST",
            datatype: "json",
            url: "../../ajax/login_cadastro/login.php",
            data: fields,
            success: function (response) {
                response = JSON.parse(response);
                if (response.flag) {
                    window.location = "../dashboard/index.php";
                } else {
                    toastr['warning'](response.msg);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr['error'](textStatus, errorThrown);
            }
        });
    }
}

