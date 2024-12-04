$(document).ready(function() {
    // Inicializando Select2
    $('.select2').select2({
        allowClear: true,
        minimumInputLength: 1, // Permite pesquisa a partir de 1 caractere
        width: '100%'
    });

    // Inicializando o flatpickr com o formato de data desejado
    if (typeof flatpickr !== 'undefined') {
        $('.datetimepicker').flatpickr({
            enableTime: false,
            dateFormat: 'Y-m-d',
            allowInput: true,
            defaultDate: "today"
        });
    }

    // Validando o campo de preço para aceitar apenas números e ponto
    $('input[name="CompraLoja[preçofornecedor]"]').on('input', function() {
        this.value = this.value.replace(/[^0-9.]/g, '');
    });

    // Adicionando controles de aumento e diminuição na quantidade
    $('input[name="CompraLoja[quantidade]"]').inputSpinner({
        groupClass: 'input-group',
        buttonsOnly: true,
        increment: 1,
        decrement: 1,
        min: 1
    });
});
