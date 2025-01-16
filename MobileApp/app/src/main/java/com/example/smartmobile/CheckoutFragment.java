package com.example.smartmobile;

import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

import com.example.smartmobile.adapters.CartAdapter;
import com.example.smartmobile.adapters.FaturaProductAdapter;
import com.example.smartmobile.listeners.GetCarrinhoListener;
import com.example.smartmobile.models.LinhaCarrinho;
import com.example.smartmobile.network.NetworkUtils;
import com.example.smartmobile.network.SingletonVolley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class CheckoutFragment extends Fragment {
    private List<LinhaCarrinho> linhasCarrinhoList = new ArrayList<>();
    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_checkout, container, false);
    }

    @Override
    public void onResume() {
        super.onResume();
        if (!NetworkUtils.isConnectionInternet(getContext())) {
            Toast.makeText(getContext(), "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {

            SingletonVolley.getInstance(getContext()).getCarrinho(getContext(), new GetCarrinhoListener() {
                @Override
                public void onGetCarrinhoResponse(JSONObject response) {

                    try {
                        JSONObject carrinho = response.getJSONObject("carrinho");
                        JSONArray linhasCarrinhos = carrinho.getJSONArray("linhacarrinhos");
                        for (int i = 0; i < linhasCarrinhos.length(); i++) {
                            JSONObject linha = linhasCarrinhos.getJSONObject(i);
                            LinhaCarrinho linhaCarrinho = new LinhaCarrinho();

                            // Preencher o Total do carrinho
                            String total = carrinho.getString("total");
                            TextView tv_total = getView().findViewById(R.id.tv_total_price);
                            tv_total.setText("Total: " + total + " €");


                            // Preencher os dados principais da linha do carrinho
                            linhaCarrinho.setId(linha.getInt("id"));
                            linhaCarrinho.setQuantidade(linha.getString("quantidade"));

                            // Obter o objeto do produto dentro da linha do carrinho
                            JSONObject produto = linha.getJSONObject("produto");

                            // Preencher os dados do produto
                            linhaCarrinho.setProdutoId(produto.getInt("id"));
                            linhaCarrinho.setProdutoNome(produto.getString("nome"));
                            linhaCarrinho.setProdutoCategoria(produto.getString("categoria"));
                            linhaCarrinho.setProdutoFilename(produto.getString("filename"));
                            linhaCarrinho.setProdutoPreco(produto.getString("preco"));
                            linhaCarrinho.setProdutoPrecoPromo(produto.isNull("precoPromo") ? null : produto.getString("precoPromo"));
                            linhaCarrinho.setProdutoDescricao(produto.getString("descricao"));

                            // Adicionar a linha do carrinho preenchida à lista (ou processar conforme necessário)
                            linhasCarrinhoList.add(linhaCarrinho); // Assumindo que linhasCarrinhoList é uma lista do tipo List<LinhaCarrinho>
                            System.out.println("Linha do carrinho adicionada: " + linhaCarrinho);
                        }
                        RecyclerView recyclerView = getView().findViewById(R.id.recycler_view_products_checkout);
                        recyclerView.setLayoutManager(new GridLayoutManager(getContext(), 1)); // 2 colunas
                        FaturaProductAdapter adapter = new FaturaProductAdapter(linhasCarrinhoList);
                        recyclerView.setAdapter(adapter);


                    } catch (JSONException e) {
                        e.printStackTrace();
                        System.out.println("Erro: " + e);
                    }
                }
            });
        }
    }
}