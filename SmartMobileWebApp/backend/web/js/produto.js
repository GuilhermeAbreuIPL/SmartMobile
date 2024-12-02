    $(function () {
        var selectedCategoryId = $('#produto-categoria_id').val();
        if (selectedCategoryId) {
            var selectedLink = $('.category-link[data-id="' + selectedCategoryId + '"]');
            if (selectedLink.length) {
                var categoryName = selectedLink.text();
                $('#selected-category-name').text(categoryName);
                $('#selected-category').show();
                $('#selected-category-label').show();
                $('.category-tree-container').hide();
            }
        }

        $('.expand-button').on('click', function () {
            var parentId = $(this).data('id');
            var branch = $('.category-branch[data-parent-id="' + parentId + '"]');
            branch.toggle();
            $(this).text(branch.is(':visible') ? '-' : '+');
        });

        $('.category-link').on('click', function (e) {
            e.preventDefault();
            var categoryId = $(this).data('id');
            var categoryName = $(this).text();
            $('#produto-categoria_id').val(categoryId).trigger('change');
            $('#selected-category-name').text(categoryName);
            $('#selected-category').show();
            $('#selected-category-label').show();
            $('.category-tree-container').hide();
        });

        $('#clear-category').on('click', function () {
            $('#produto-categoria_id').val('').trigger('change');
            $('#selected-category-name').text('');
            $('#selected-category').hide();
            $('#selected-category-label').hide();
            $('.category-tree-container').show();
        });


        $('form').on('beforeSubmit', function () {
            var categoriaId = $('#produto-categoria_id').val();
            if (!categoriaId) {
                alert("Por favor, selecione uma categoria!");
                return false;
            }
            return true;
        });
    });