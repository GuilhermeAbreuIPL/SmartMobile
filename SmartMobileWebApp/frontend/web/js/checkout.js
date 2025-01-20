document.addEventListener('DOMContentLoaded', function () {
    const selectionRadios = document.querySelectorAll('input[name="tipoentrega"]');
    const moradaList = document.getElementById('morada-list');
    const lojaList = document.getElementById('loja-list');

    // Função para limpar seleção de inputs radio
    function clearSelection(container) {
        const radios = container.querySelectorAll('input[type="radio"]');
        radios.forEach(radio => {
            radio.checked = false; // Remove a seleção do input
        });
    }

    selectionRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === 'morada') {
                clearSelection(lojaList); // Limpa seleção de lojas
                moradaList.style.display = 'block'; // Mostra a lista de moradas
                lojaList.style.display = 'none';   // Oculta a lista de lojas
            } else if (this.value === 'loja') {
                clearSelection(moradaList); // Limpa seleção de moradas
                moradaList.style.display = 'none'; // Oculta a lista de moradas
                lojaList.style.display = 'block';  // Mostra a lista de lojas
            }
        });
    });
});