<?php


namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        //Criar todos os roles
        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $gestor = $auth->createRole('gestor');
        $auth->add($gestor);

        $funcionario = $auth->createRole('funcionario');
        $auth->add($funcionario);

        $cliente = $auth->createRole('cliente');
        $auth->add($cliente);


        //---------------------- Permissões Criar contas de funcionario --------------------------------
        $createFuncionario = $auth->createPermission('createFuncionario');
        $createFuncionario->description = 'Criar Funcionario';
        $auth->add($createFuncionario);

        $updateFuncionario = $auth->createPermission('updateFuncionario');
        $updateFuncionario->description = 'Atualizar Funcionario';
        $auth->add($updateFuncionario);

        $deleteFuncionario = $auth->createPermission('deleteFuncionario');
        $deleteFuncionario->description = 'Remover Funcionario';
        $auth->add($deleteFuncionario);

        $viewFuncionario = $auth->createPermission('viewFuncionario');
        $viewFuncionario->description = 'Ver Funcionario';
        $auth->add($viewFuncionario);

        //Permissões para funcionarios
        $auth->addChild($gestor, $createFuncionario);
        $auth->addChild($gestor, $updateFuncionario);
        $auth->addChild($gestor, $deleteFuncionario);
        $auth->addChild($gestor, $viewFuncionario);

        //---------------------- Permissões Criar contas de cliente --------------------------------
        $createCliente = $auth->createPermission('createCliente');
        $createCliente->description = 'Criar Cliente';
        $auth->add($createCliente);

        $deleteCliente = $auth->createPermission('deleteCliente');
        $deleteCliente->description = 'Remover Cliente';
        $auth->add($deleteCliente);

        $viewCliente = $auth->createPermission('viewCliente');
        $viewCliente->description = 'Ver Cliente';
        $auth->add($viewCliente);

        //Permissões para clientes
        $auth->addChild($funcionario, $createCliente);
        $auth->addChild($gestor, $deleteCliente);
        $auth->addChild($funcionario, $viewCliente);


        //---------------------- Permissões Criar contas de gestor --------------------------------
        $createGestor = $auth->createPermission('createGestor');
        $createGestor->description = 'Criar Gestor';
        $auth->add($createGestor);

        $updateGestor = $auth->createPermission('updateGestor');
        $updateGestor->description = 'Atualizar Gestor';
        $auth->add($updateGestor);

        $deleteGestor = $auth->createPermission('deleteGestor');
        $deleteGestor->description = 'Remover Gestor';
        $auth->add($deleteGestor);

        $viewGestor = $auth->createPermission('viewGestor');
        $viewGestor->description = 'Ver Gestor';
        $auth->add($viewGestor);

        //Permissões para gestores
        $auth->addChild($admin, $createGestor);
        $auth->addChild($admin, $updateGestor);
        $auth->addChild($admin, $deleteGestor);
        $auth->addChild($admin, $viewGestor);

        //---------------------- Permissões Fornecedores --------------------------------
        $createFornecedor = $auth->createPermission('createFornecedor');
        $createFornecedor->description = 'Criar Fornecedor';
        $auth->add($createFornecedor);

        $updateFornecedor = $auth->createPermission('updateFornecedor');
        $updateFornecedor->description = 'Atualizar Fornecedor';
        $auth->add($updateFornecedor);

        $deleteFornecedor = $auth->createPermission('deleteFornecedor');
        $deleteFornecedor->description = 'Remover Fornecedor';
        $auth->add($deleteFornecedor);

        $viewFornecedor = $auth->createPermission('viewFornecedor');
        $viewFornecedor->description = 'Ver Fornecedor';
        $auth->add($viewFornecedor);

        //Permissões para fornecedores
        $auth->addChild($gestor, $createFornecedor);
        $auth->addChild($gestor, $updateFornecedor);
        $auth->addChild($gestor, $deleteFornecedor);
        $auth->addChild($gestor, $viewFornecedor);

        //---------------------- Permissões Lojas --------------------------------
        $createLoja = $auth->createPermission('createLoja');
        $createLoja->description = 'Criar Loja';
        $auth->add($createLoja);

        $updateLoja = $auth->createPermission('updateLoja');
        $updateLoja->description = 'Atualizar Loja';
        $auth->add($updateLoja);

        $deleteLoja = $auth->createPermission('deleteLoja');
        $deleteLoja->description = 'Remover Loja';
        $auth->add($deleteLoja);

        $viewLoja = $auth->createPermission('viewLoja');
        $viewLoja->description = 'Ver Loja';
        $auth->add($viewLoja);

        //Permissões para lojas
        $auth->addChild($gestor, $createLoja);
        $auth->addChild($gestor, $updateLoja);
        $auth->addChild($gestor, $deleteLoja);
        $auth->addChild($gestor, $viewLoja);

        //---------------------- Permissões Compra Loja --------------------------------
        $createCompraLoja = $auth->createPermission('createCompraLoja');
        $createCompraLoja->description = 'Criar Compra Loja';
        $auth->add($createCompraLoja);

        $viewCompraLoja = $auth->createPermission('viewCompraLoja');
        $viewCompraLoja->description = 'Ver Compra Loja';
        $auth->add($viewCompraLoja);

        //Permissões para compra loja
        $auth->addChild($funcionario, $createCompraLoja);
        $auth->addChild($funcionario, $viewCompraLoja);

        //---------------------- Permissões Stock --------------------------------
        $addStock = $auth->createPermission('adicionarStock');
        $addStock->description = 'Adicionar Stock';
        $auth->add($addStock);

        $removeStock = $auth->createPermission('removerStock');
        $removeStock->description = 'Remover Stock';
        $auth->add($removeStock);

        $viewStock = $auth->createPermission('viewStock');
        $viewStock->description = 'Ver Stock';
        $auth->add($viewStock);

        //Permissões para stock
        $auth->addChild($funcionario, $addStock);
        $auth->addChild($gestor, $removeStock);
        $auth->addChild($funcionario, $viewStock);

        //---------------------- Permissões Promoção --------------------------------
        $createPromocao = $auth->createPermission('createPromocao');
        $createPromocao->description = 'Criar Promoção';
        $auth->add($createPromocao);

        $updatePromocao = $auth->createPermission('updatePromocao');
        $updatePromocao->description = 'Atualizar Promoção';
        $auth->add($updatePromocao);

        $deletePromocao = $auth->createPermission('deletePromocao');
        $deletePromocao->description = 'Remover Promoção';
        $auth->add($deletePromocao);

        $viewPromocao = $auth->createPermission('viewPromocao');
        $viewPromocao->description = 'Ver Promoção';
        $auth->add($viewPromocao);

        //Permissões para promoções
        $auth->addChild($admin, $createPromocao);
        $auth->addChild($admin, $updatePromocao);
        $auth->addChild($admin, $deletePromocao);
        $auth->addChild($admin, $viewPromocao);

        //---------------------- Permissões Encomendas --------------------------------
        $createOrder = $auth->createPermission('createOrder');
        $createOrder->description = 'Criar Encomenda';
        $auth->add($createOrder);

        $statusOrder = $auth->createPermission('statusOrder');
        $statusOrder->description = 'Alterar estado da encomenda';
        $auth->add($statusOrder);

        $deleteOrder = $auth->createPermission('deleteOrder');
        $deleteOrder->description = 'Remover Encomenda';
        $auth->add($deleteOrder);

        $viewOwnOrders = $auth->createPermission('viewOwnOrders');
        $viewOwnOrders->description = 'Ver as suas encomendas';
        $auth->add($viewOwnOrders);

        $viewAllOrders = $auth->createPermission('viewAllOrders');
        $viewAllOrders->description = 'Ver todas as encomendas';
        $auth->add($viewAllOrders);

        //Permissões para encomendas
        $auth->addChild($cliente, $createOrder);
        $auth->addChild($funcionario, $statusOrder);
        $auth->addChild($funcionario, $deleteOrder);
        $auth->addChild($cliente, $viewOwnOrders);
        $auth->addChild($funcionario, $viewAllOrders);


        //---------------------- Permissões Categorias --------------------------------
        $createCategoria = $auth->createPermission('createCategoria');
        $createCategoria->description = 'Criar Categoria';
        $auth->add($createCategoria);

        $updateCategoria = $auth->createPermission('updateCategoria');
        $updateCategoria->description = 'Atualizar Categoria';
        $auth->add($updateCategoria);

        $deleteCategoria = $auth->createPermission('deleteCategoria');
        $deleteCategoria->description = 'Remover Categoria';
        $auth->add($deleteCategoria);

        $viewCategoria = $auth->createPermission('viewCategoria');
        $viewCategoria->description = 'Ver Categoria';
        $auth->add($viewCategoria);

        //Permissões para categorias
        $auth->addChild($gestor, $createCategoria);
        $auth->addChild($gestor, $updateCategoria);
        $auth->addChild($gestor, $deleteCategoria);
        $auth->addChild($gestor, $viewCategoria);


        //----------------------- Permissões Produtos --------------------------------
        $createProduto = $auth->createPermission('createProduto');
        $createProduto->description = 'Criar Produto';
        $auth->add($createProduto);

        $updateProduto = $auth->createPermission('updateProduto');
        $updateProduto->description = 'Atualizar Produto';
        $auth->add($updateProduto);

        $deleteProduto = $auth->createPermission('deleteProduto');
        $deleteProduto->description = 'Remover Produto';
        $auth->add($deleteProduto);

        //permissões para produtos
        $auth->addChild($gestor, $createProduto);
        $auth->addChild($gestor, $updateProduto);
        $auth->addChild($gestor, $deleteProduto);


        //---------------------- Permissões Metodos de Pagemento --------------------------------
        $createMetodoPagamento = $auth->createPermission('createMetodoPagamento');
        $createMetodoPagamento->description = 'Criar Metodo de Pagamento';
        $auth->add($createMetodoPagamento);

        $updateMetodoPagamento = $auth->createPermission('updateMetodoPagamento');
        $updateMetodoPagamento->description = 'Atualizar Metodo de Pagamento';
        $auth->add($updateMetodoPagamento);

        $deleteMetodoPagamento = $auth->createPermission('deleteMetodoPagamento');
        $deleteMetodoPagamento->description = 'Remover Metodo de Pagamento';
        $auth->add($deleteMetodoPagamento);

        $viewMetodoPagamento = $auth->createPermission('viewMetodoPagamento');
        $viewMetodoPagamento->description = 'Ver Metodo de Pagamento';
        $auth->add($viewMetodoPagamento);

        //Permissões para metodos de pagamento
        $auth->addChild($admin, $createMetodoPagamento);
        $auth->addChild($admin, $updateMetodoPagamento);
        $auth->addChild($admin, $deleteMetodoPagamento);
        $auth->addChild($admin, $viewMetodoPagamento);

        //---------------------- Permissões Metodos de Entrega --------------------------------
        $createMetodoEntrega = $auth->createPermission('createMetodoEntrega');
        $createMetodoEntrega->description = 'Criar Metodo de Entrega';
        $auth->add($createMetodoEntrega);

        $updateMetodoEntrega = $auth->createPermission('updateMetodoEntrega');
        $updateMetodoEntrega->description = 'Atualizar Metodo de Entrega';
        $auth->add($updateMetodoEntrega);

        $deleteMetodoEntrega = $auth->createPermission('deleteMetodoEntrega');
        $deleteMetodoEntrega->description = 'Remover Metodo de Entrega';
        $auth->add($deleteMetodoEntrega);

        $viewMetodoEntrega = $auth->createPermission('viewMetodoEntrega');
        $viewMetodoEntrega->description = 'Ver Metodo de Entrega';
        $auth->add($viewMetodoEntrega);

        //Permissões para metodos de entrega
        $auth->addChild($admin, $createMetodoEntrega);
        $auth->addChild($admin, $updateMetodoEntrega);
        $auth->addChild($admin, $deleteMetodoEntrega);
        $auth->addChild($admin, $viewMetodoEntrega);

        //---------------------- Permissões Perfis --------------------------------
        $viewMyProfile = $auth->createPermission('viewMyProfile');
        $viewMyProfile->description = 'Ver o seu perfil';
        $auth->add($viewMyProfile);

        $updateMyProfile = $auth->createPermission('updateMyProfile');
        $updateMyProfile->description = 'Atualizar o seu perfil';
        $auth->add($updateMyProfile);

        $deleteMyProfile = $auth->createPermission('deleteMyProfile');
        $deleteMyProfile->description = 'Remover o seu perfil';
        $auth->add($deleteMyProfile);

        $viewAllProfiles = $auth->createPermission('viewAllProfiles');
        $viewAllProfiles->description = 'Ver todos os perfis';
        $auth->add($viewAllProfiles);

        //Permissões para perfis
        $auth->addChild($cliente, $viewMyProfile);
        $auth->addChild($cliente, $updateMyProfile);
        $auth->addChild($cliente, $deleteMyProfile);
        $auth->addChild($funcionario, $viewAllProfiles);

        //---------------------- Permissões para o Carrinho --------------------------------
        $addToCart = $auth->createPermission('addToCart');
        $addToCart->description = 'Adicionar ao Carrinho';
        $auth->add($addToCart);

        $editQuantityOnCart = $auth->createPermission('editQuantityOnCart');
        $editQuantityOnCart->description = 'Editar quantidade no Carrinho';
        $auth->add($editQuantityOnCart);

        $removeFromCart = $auth->createPermission('removeFromCart');
        $removeFromCart->description = 'Remover do Carrinho';
        $auth->add($removeFromCart);

        $viewCart = $auth->createPermission('viewCart');
        $viewCart->description = 'Ver Carrinho';
        $auth->add($viewCart);

        //Permissões para o carrinho
        $auth->addChild($cliente, $addToCart);
        $auth->addChild($cliente, $editQuantityOnCart);
        $auth->addChild($cliente, $removeFromCart);
        $auth->addChild($cliente, $viewCart);

        //---------------------- Permissões para ver Backend --------------------------------
        $viewBackend = $auth->createPermission('viewBackend');
        $viewBackend->description = 'Ver Backend';
        $auth->add($viewBackend);

        //Permissões para ver o backend
        $auth->addChild($funcionario, $viewBackend);

        //---------------------- Finalizações --------------------------------

        //Definir herança de roles
        $auth->addChild($gestor, $funcionario);
        $auth->addChild($admin, $gestor);

        //O admin vai ser o id 1
        $auth->assign($admin, 1);
    }
}
