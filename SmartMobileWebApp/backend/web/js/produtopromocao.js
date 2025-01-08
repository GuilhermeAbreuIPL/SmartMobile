
$(document).ready(function() {
    $('.select2').select2({
        allowClear: true,
        minimumInputLength: 1,
        width: '100%'
    });

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd', // Exibindo apenas a data no formato desejado
        autoclose: true,       // Fecha automaticamente o datepicker após seleção
        todayHighlight: true,  // Destaca o dia de hoje
        startView: 2,          // Exibe o mês por padrão
        maxViewMode: 2,        // Desabilita a visualização de anos
        clearBtn: true         // Adiciona um botão para limpar a data
    });
});
