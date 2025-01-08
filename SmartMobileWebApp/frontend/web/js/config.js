document.addEventListener("DOMContentLoaded", function () {
    // Ações para caixas de morada existentes
    document.querySelectorAll(".morada-card[data-id]").forEach(function (card) {
        card.addEventListener("click", function () {
            const moradaId = card.getAttribute("data-id");
            if (moradaId) {
                // Redireciona para a rota de edição da morada
                window.location.href = `manage-morada?moradaId=${moradaId}`;
            }
        });
    });

    // Ação para o botão de adicionar nova morada
    const addNewCard = document.querySelector(".add-new-card");
    if (addNewCard) {
        addNewCard.addEventListener("click", function () {
            // Redireciona para a rota de adicionar nova morada
            window.location.href = "manage-morada";
        });
    }
});
