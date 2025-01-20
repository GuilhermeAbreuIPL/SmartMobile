package com.example.smartmobile.models;

public class LinhaCarrinho
{
    private int id;
    private String quantidade;
    private int produtoId;
    private String produtoNome;
    private String produtoCategoria;
    private String produtoFilename;
    private String produtoPreco;
    private String produtoPrecoPromo;
    private String produtoDescricao;

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getQuantidade() {
        return quantidade;
    }

    public void setQuantidade(String quantidade) {
        this.quantidade = quantidade;
    }

    public int getProdutoId() {
        return produtoId;
    }

    public void setProdutoId(int produtoId) {
        this.produtoId = produtoId;
    }

    public String getProdutoNome() {
        return produtoNome;
    }

    public void setProdutoNome(String produtoNome) {
        this.produtoNome = produtoNome;
    }

    public String getProdutoCategoria() {
        return produtoCategoria;
    }

    public void setProdutoCategoria(String produtoCategoria) {
        this.produtoCategoria = produtoCategoria;
    }

    public String getProdutoFilename() {
        return produtoFilename;
    }

    public void setProdutoFilename(String produtoFilename) {
        this.produtoFilename = produtoFilename;
    }

    public String getProdutoPreco() {
        return produtoPreco;
    }

    public void setProdutoPreco(String produtoPreco) {
        this.produtoPreco = produtoPreco;
    }

    public String getProdutoPrecoPromo() {
        return produtoPrecoPromo;
    }

    public void setProdutoPrecoPromo(String produtoPrecoPromo) {
        this.produtoPrecoPromo = produtoPrecoPromo;
    }

    public String getProdutoDescricao() {
        return produtoDescricao;
    }

    public void setProdutoDescricao(String produtoDescricao) {
        this.produtoDescricao = produtoDescricao;
    }
}
