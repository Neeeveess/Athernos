jQuery(document).ready(function ($) {
    $(".input2").each(function () {
        $(this).on("blur", function () {
            if ($(this).val().trim() != "") {
                $(this).addClass("has-val");
            } else {
                $(this).removeClass("has-val");
            }
        });
    });
    //MENU LATERAL
    const menuHamburguer = $("#menu-hamburguer");
    const menuLateral = $("#menu-lateral");
    const svgEsquerda = $(".svg-esquerda");
    const svgDireita = $(".svg-direita");
    svgDireita.hide();

    menuHamburguer.on("click", () => {
        if (menuLateral.hasClass("close-ml")) {
            //Abrir menu
            menuLateral.removeClass("close-ml").addClass("show-ml");
            svgDireita.hide();
            svgEsquerda.show();
        } else {
            //Fechar menu
            menuLateral.removeClass("show-ml").addClass("close-ml");

            svgDireita.show();
            svgEsquerda.hide();
        }
    });

    //Notificação de Mensagem
    const divMessage = $(".div-alert");
    let msg = "Teste";

    function showMessage(msg, type = "success") {
        const message = $("<div>", {
            class: "message-" + type,
        })
            .text(msg)
            .appendTo(divMessage);
        setTimeout(() => {
            message.hide("fast");
        }, 3000);
    }

    // menuHamburguer.on("click", () => {
    //     showMessage(msg, "success");
    // });

    //Listar Nav Bar
    const titulo = $(".nav-bar__title");

    titulo.each(function () {
        $(this).on("click", () => {
            const itens = $(this).siblings();
            const svgCima = $(this).find(".svg-cima");
            const svgBaixo = $(this).find(".svg-baixo");
            itens.toggleClass("hide");
            if (itens.hasClass("hide")) {
                svgBaixo.hide();
                svgCima.show();
            } else {
                svgBaixo.show();
                svgCima.hide();
            }
        });
    });
});
