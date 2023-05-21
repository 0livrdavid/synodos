if (window.navigator.userAgent.indexOf("Trident/") > 0) {
    alert("Internet Explorer não é mais suportado.\n\n Por favor utilize outro navegador.");
    location.href = servidor + "../../not_support.php";
}

$(document).ready(function () {
    $('.mask-cpf').mask('999.999.999-99');
    $('.mask-cep').mask('99999-999');
    $('.mask-data').mask('99/99/9999');
    $('.mask-dinheiro').maskMoney({
        prefix: 'R$ ',
        decimal: ',',
        thousands: '.'
    });

    $('#fileInput').on('change', function (e) {
        var files = e.target.files;
        var fileList = $('#fileList');
        fileList.empty();

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            fileList.append('<div class="file-progress">' + file.name + ': <div class="file-progress-bar"></div></div>');
        }
    });
});

toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

function switchLoginDashboard(user) {
    if (user == 'logged') {
        $(".header-menu-logged").css("display", "flex");
        $(".header-menu-logout").css("display", "none");
    } else if (user == "logout") {
        $(".header-menu-logged").css("display", "none");
        $(".header-menu-logout").css("display", "flex");
    }
}

function isValidDate(data, msg = "Data Nascimento") {
    if (!/^\d{2}\/\d{2}\/\d{4}$/.test(data)) {
        toastr["warning"](`O campo "${msg}" não fornece uma entrada de data valida.`, "Atenção");
        return false;
    }

    const [dia, mes, ano] = data.split('/');
    const date = new Date(`${ano}-${mes}-${dia}`);

    if (isNaN(date.getTime())) {
        toastr["warning"](`O campo "${msg}" não fornece uma entrada de data valida.`, "Atenção");
        return false;
    }

    const now = new Date();
    if (date.getTime() > now.getTime()) {
        toastr["warning"](`A data fornecida no campo "${msg}" não pode ser superior a data de hoje "${now}".`, "Atenção");
        return false;
    }

    const minDate = new Date();
    minDate.setFullYear(minDate.getFullYear() - 150);
    if (date.getTime() < minDate.getTime()) {
        toastr["warning"](`A data fornecida no campo "${msg}" não pode ser que "${minDate}".`, "Atenção");
        return false;
    }

    return true;
}


function isValidCPF(cpf, msg) {
    cpf = cpf.replace(/[^\d]+/g, ''); // remove caracteres não numéricos
    if (cpf.length !== 11) {
        toastr['warning'](`O campo "${msg}" deve ter 11 dígitos.`, "Atenção");
        return false; // o CPF deve ter 11 dígitos
    }
    // Calcula o primeiro dígito verificador
    let soma = 0;
    for (let i = 0; i < 9; i++) {
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    }
    let resto = 11 - (soma % 11);
    let digitoVerificador1 = (resto === 10 || resto === 11) ? 0 : resto;

    // Calcula o segundo dígito verificador
    soma = 0;
    for (let i = 0; i < 10; i++) {
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    }
    resto = 11 - (soma % 11);
    let digitoVerificador2 = (resto === 10 || resto === 11) ? 0 : resto;

    // Retorna true se os dígitos verificadores estão corretos, false caso contrário
    if ((digitoVerificador1 === parseInt(cpf.charAt(9)) && digitoVerificador2 === parseInt(cpf.charAt(10)))) {
        return true;
    } else {
        toastr["warning"](`O campo "${msg}" não fornece dados validos`, "Atenção");
        return false;
    }
}

function cloneImage(srcElementId, destElementId) {
    var srcElement = document.getElementById(srcElementId);
    var destElement = document.getElementById(destElementId);

    destElement.src = srcElement.src;
}