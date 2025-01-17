package com.example.smartmobile;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

import androidx.fragment.app.Fragment;
import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.example.smartmobile.adapters.FaturaProductAdapter;
import com.example.smartmobile.listeners.FaturaListener;
import com.example.smartmobile.models.LinhaCarrinho;
import com.example.smartmobile.network.SingletonVolley;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class OrderDetailsFragment extends Fragment {

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_order_details, container, false);
    }

    @Override
    public void onResume() {
        super.onResume();

        // Ir buscar o id da fatura que foi passado pelo bundle
        Bundle bundle = getArguments();
        if (bundle != null) {
            String faturaId = bundle.getString("fatura_id");
            System.out.println("Fatura ID: " + faturaId);


            SingletonVolley.getInstance(getContext()).getFaturaDetails(getContext(), faturaId ,new FaturaListener() {
                @Override
                public void onFaturaResponse(JSONObject response) {
                    try {
                        TextView tvData = getView().findViewById(R.id.tv_data);
                        TextView tvTotal = getView().findViewById(R.id.tv_total);
                        TextView tvEstado = getView().findViewById(R.id.tv_status);
                        TextView tvMetodoPagamento = getView().findViewById(R.id.tv_pagamento);
                        TextView tv_entrega = getView().findViewById(R.id.tv_entrega);
                        TextView tvrua = getView().findViewById(R.id.tv_rua);
                        TextView tvlocalidade = getView().findViewById(R.id.tv_localidade);
                        TextView tvcodpostal = getView().findViewById(R.id.tv_codpostal);

                        JSONObject fatura = response.getJSONObject("faturas");

                        tvData.setText(fatura.getString("data"));
                        tvTotal.setText(fatura.getString("total")  + "€" );
                        tvEstado.setText(fatura.getString("estado"));
                        tvMetodoPagamento.setText(fatura.getString("metodopagamento"));
                        tv_entrega.setText(fatura.getString("tipoentrega"));
                        tvrua.setText(fatura.getString("rua"));
                        tvlocalidade.setText(fatura.getString("localidade"));
                        tvcodpostal.setText(fatura.getString("codpostal"));


                        JSONArray produtos = fatura.getJSONArray("linhafaturas");
                        //transforma os produtos em uma list
                        List<LinhaCarrinho> faturaProductList = new ArrayList<>();
                        for (int i = 0; i < produtos.length(); i++) {
                            JSONObject produto = produtos.getJSONObject(i);
                            LinhaCarrinho linhaCarrinho = new LinhaCarrinho();
                            linhaCarrinho.setProdutoNome(produto.getString("produto"));
                            linhaCarrinho.setQuantidade(produto.getString("quantidade"));
                            linhaCarrinho.setProdutoPreco(produto.getString("preco"));
                            faturaProductList.add(linhaCarrinho);
                        }

                        // Ir buscar os produtos da fatura
                        FaturaProductAdapter faturaProductAdapter = new FaturaProductAdapter(faturaProductList);
                        RecyclerView recyclerView = getView().findViewById(R.id.rv_fatura_products_details);
                        recyclerView.setAdapter(faturaProductAdapter);
                        recyclerView.setLayoutManager(new LinearLayoutManager(getContext()));

                    } catch (Exception e) {
                        System.out.println("Erro: " + e.getMessage());
                    }
                }
            });

            getView().findViewById(R.id.btn_close).setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    OrderHistoryFragment homeFragment = new OrderHistoryFragment();
                    getActivity().getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, homeFragment).commit();
                }
            });
        }
        else {
            //Erro toast
            Toast.makeText(getContext(), "Erro ao carregar a fatura", Toast.LENGTH_SHORT).show();
            HomeFragment homeFragment = new HomeFragment();
            getActivity().getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, homeFragment).commit();
        }
    }
}