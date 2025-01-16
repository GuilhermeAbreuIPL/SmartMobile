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
import com.example.smartmobile.adapters.FaturaMoradaAdapter;
import com.example.smartmobile.adapters.FaturaProductAdapter;
import com.example.smartmobile.adapters.MetodoPagamentoAdapter;
import com.example.smartmobile.listeners.CheckoutListener;
import com.example.smartmobile.listeners.GetCarrinhoListener;
import com.example.smartmobile.listeners.MetodoPagamentoListener;
import com.example.smartmobile.listeners.MoradaListener;
import com.example.smartmobile.models.LinhaCarrinho;
import com.example.smartmobile.models.MetodoPagamento;
import com.example.smartmobile.models.MoradaModel;
import com.example.smartmobile.network.NetworkUtils;
import com.example.smartmobile.network.SingletonVolley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.AbstractCollection;
import java.util.ArrayList;
import java.util.List;

public class CheckoutFragment extends Fragment {
    private List<LinhaCarrinho> linhasCarrinhoList = new ArrayList<>();
    private List<MetodoPagamento> metodoPagamentoList = new ArrayList<>();
    private List<MoradaModel> faturaMoradaList = new ArrayList<>();
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

            SingletonVolley.getInstance(getContext()).getMetodoPagamento(getContext(), new MetodoPagamentoListener() {
                @Override
                public void onMetodoPagamentoResponse(JSONObject response) {
                    try {
                        JSONArray metodosPagamento = response.getJSONArray("metodoPagamento");

                        for (int i = 0; i < metodosPagamento.length(); i++) {
                            JSONObject metodoPagamento = metodosPagamento.getJSONObject(i);
                            MetodoPagamento metodoPagamentoObj = new MetodoPagamento();
                            metodoPagamentoObj.setId(metodoPagamento.getInt("id"));
                            metodoPagamentoObj.setNome(metodoPagamento.getString("nome"));
                            metodoPagamentoList.add(metodoPagamentoObj);
                        }
                        RecyclerView recyclerView = getView().findViewById(R.id.recycler_view_payments);
                        recyclerView.setLayoutManager(new GridLayoutManager(getContext(), 3));
                        MetodoPagamentoAdapter adapter = new MetodoPagamentoAdapter(metodoPagamentoList);
                        recyclerView.setAdapter(adapter);
                    } catch (JSONException e) {
                        e.printStackTrace();
                        System.out.println("Erro: " + e);
                    }
                }
            });

            SingletonVolley.getInstance(getContext()).getMoradas(getContext(), new MoradaListener() {
                @Override
                public void onMoradaResponse(JSONObject response) {
                    try {
                        JSONArray moradas = response.getJSONArray("moradas");
                        for (int i = 0; i < moradas.length(); i++) {
                            JSONObject morada = moradas.getJSONObject(i);
                            MoradaModel moradaModel = new MoradaModel();
                            moradaModel.setId(morada.getInt("id"));
                            moradaModel.setRua(morada.getString("rua"));
                            moradaModel.setLocalidade(morada.getString("localidade"));
                            moradaModel.setCodPostal(morada.getString("codpostal"));
                            faturaMoradaList.add(moradaModel);
                        }
                        RecyclerView recyclerView = getView().findViewById(R.id.rv_moradas_checkout);
                        recyclerView.setLayoutManager(new GridLayoutManager(getContext(), 1));
                        FaturaMoradaAdapter adapter = new FaturaMoradaAdapter(faturaMoradaList);
                        recyclerView.setAdapter(adapter);
                    } catch (JSONException e) {
                        e.printStackTrace();
                        System.out.println("Erro: " + e);
                    }
                }
            });

            getView().findViewById(R.id.btn_checkout).setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    int metodoPagamentoId = -1;

                    // Obter a posição selecionada do adaptador
                    int selectedPosition = MetodoPagamentoAdapter.getSelectedPosition();

                    if (selectedPosition != RecyclerView.NO_POSITION) {
                        // Obter o método de pagamento com base na posição selecionada
                        MetodoPagamento metodoSelecionado = metodoPagamentoList.get(selectedPosition);
                        metodoPagamentoId = metodoSelecionado.getId();

                        // Usa o ID conforme necessário
                        System.out.println("Método de pagamento selecionado: " + metodoPagamentoId);
                    } else {
                        System.out.println("Nenhum método de pagamento foi selecionado.");
                        Toast.makeText(getContext(), "Selecione um método de pagamento", Toast.LENGTH_SHORT).show();
                    }

                    // Obter a morada selecionada
                    int moradaId = -1;
                    int selectedMoradaPosition = FaturaMoradaAdapter.getSelectedPosition();

                    if (selectedMoradaPosition != RecyclerView.NO_POSITION) {
                        MoradaModel moradaSelecionada = faturaMoradaList.get(selectedMoradaPosition);
                        moradaId = moradaSelecionada.getId();
                        System.out.println("Morada selecionada: " + moradaId);
                    } else {
                        System.out.println("Nenhuma morada foi selecionada.");
                        Toast.makeText(getContext(), "Selecione uma morada", Toast.LENGTH_SHORT).show();
                    }

                    // Criar o objeto de checkout
                    JSONObject checkout = new JSONObject();
                    try {
                        checkout.put("tipoEntrega", "Morada");
                        checkout.put("metodoPagamento", metodoPagamentoId);
                        checkout.put("morada_id", moradaId);
                    } catch (JSONException e) {
                        e.printStackTrace();
                        System.out.println("Erro: " + e);
                    }

                    // Enviar o pedido de checkout
                    SingletonVolley.getInstance(getContext()).checkout(getContext(),checkout, new CheckoutListener() {
                        @Override
                        public void onCheckoutResponse(JSONObject response) {
                            try {
                                if (response.getBoolean("success")) {
                                    Toast.makeText(getContext(), "Checkout bem sucedido", Toast.LENGTH_SHORT).show();
                                    System.out.println("Checkout bem sucedido");

                                    OrderHistoryFragment orderHistoryFragment = new OrderHistoryFragment();
                                    getActivity().getSupportFragmentManager().beginTransaction()
                                            .replace(R.id.fragment_container, orderHistoryFragment)
                                            .addToBackStack(null)
                                            .commit();
                                } else {
                                    Toast.makeText(getContext(), "Erro no checkout", Toast.LENGTH_SHORT).show();
                                    System.out.println("Erro no checkout");
                                }
                            } catch (JSONException e) {
                                e.printStackTrace();
                                System.out.println("Erro: " + e);
                            }
                        }
                    });
                }
            });
        }
    }
}