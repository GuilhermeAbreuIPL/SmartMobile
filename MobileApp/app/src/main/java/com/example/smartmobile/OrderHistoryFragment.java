package com.example.smartmobile;

import android.os.Bundle;

import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Toast;

import com.example.smartmobile.adapters.CartAdapter;
import com.example.smartmobile.adapters.FaturaAdapter;
import com.example.smartmobile.listeners.FaturaListener;
import com.example.smartmobile.models.Fatura;
import com.example.smartmobile.network.NetworkUtils;
import com.example.smartmobile.network.SingletonVolley;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class OrderHistoryFragment extends Fragment {
    private final List<Fatura> faturasList = new ArrayList<>();

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_order_history, container, false);
    }

    @Override
    public void onResume() {
        super.onResume();
        if (!NetworkUtils.isConnectionInternet(getContext())) {
            Toast.makeText(getContext(), "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {

            SingletonVolley.getInstance(getContext()).getAllFaturas(getContext(),new FaturaListener() {
                @Override
                public void onFaturaResponse(JSONObject response) {
                    try {
                        JSONArray faturas = response.getJSONArray("faturas");
                        for (int i = 0; i < faturas.length(); i++) {
                            JSONObject fatura = faturas.getJSONObject(i);
                            Fatura fatura1 = new Fatura();
                            fatura1.setData(fatura.getString("data"));
                            fatura1.setTotal(fatura.getString("total"));
                            fatura1.setEstado(fatura.getString("estado"));
                            fatura1.setMetodoPagamento(fatura.getString("metodopagamento"));
                            faturasList.add(fatura1);
                        }
                        // Notify the adapter that the data has changed
                        RecyclerView recyclerView = getView().findViewById(R.id.rv_orders);
                        recyclerView.setLayoutManager(new GridLayoutManager(getContext(), 1)); // 2 colunas
                        FaturaAdapter adapter = new FaturaAdapter(faturasList);
                        recyclerView.setAdapter(adapter);

                        Toast.makeText(getContext(), "Faturas carregadas com sucesso", Toast.LENGTH_SHORT).show();
                    } catch (Exception e) {
                        System.out.println(e);
                        System.out.println("Fiz porcaria no try catch");
                        throw new RuntimeException(e);
                    }

                }
            });
        }

    }
}