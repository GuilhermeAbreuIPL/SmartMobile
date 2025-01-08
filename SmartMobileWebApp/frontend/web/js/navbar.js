function openSidebar(sidebarId) {
    const sidebar = document.getElementById(sidebarId);
    if (sidebar) {
        sidebar.style.width = "400px";
        document.getElementById("backdrop").classList.add("active");
    }
}

function closeAllSidebars(sidebarId) {
    const sidebar = document.getElementById(sidebarId);
    if (sidebar) {
        sidebar.style.width = "0";
        document.getElementById("backdrop").classList.remove("active");
    }
}

function loadCart() {
    const cartContainer = document.getElementById('cart-container');
    cartContainer.innerHTML = 'Carregando...'; // Adiciona um indicador de carregamento

    var urlCarrinhoView = document.getElementById('teste').getAttribute('data-urlCarrinhoView');

    fetch(urlCarrinhoView)
        .then(response => {
            // Verificando o status da resposta
            console.log('Status da resposta:', response.status); // Similar ao var_dump
            if (!response.ok) {
                throw new Error('Erro ao carregar o carrinho.');
            }
            return response.text();
        })
        .then(html => {
            // Verificando o HTML que foi retornado
            console.log('HTML recebido:', html); // Similar ao var_dump
            cartContainer.innerHTML = html;
            cartContainer.style.display = 'block'; // Mostra o container do carrinho
        })
        .catch(error => {
            // Caso haja erro, exibe uma mensagem
            console.error('Erro:', error);
            cartContainer.innerHTML = '<p>Erro ao carregar o carrinho.</p>';
        });
}






