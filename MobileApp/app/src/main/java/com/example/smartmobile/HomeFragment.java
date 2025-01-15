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

import com.example.smartmobile.adapters.ProductAdapter;
import com.example.smartmobile.listeners.ProdutosListener;
import com.example.smartmobile.models.Product;
import com.example.smartmobile.network.NetworkUtils;
import com.example.smartmobile.network.SingletonVolley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class HomeFragment extends Fragment {

    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";
    private List<Product> productList = new ArrayList<>();

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;

    public HomeFragment() {
        // Required empty public constructor
    }

    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param param1 Parameter 1.
     * @param param2 Parameter 2.
     * @return A new instance of fragment HomeFragment.
     */
    // TODO: Rename and change types and number of parameters
    public static HomeFragment newInstance(String param1, String param2) {
        HomeFragment fragment = new HomeFragment();
        Bundle args = new Bundle();
        args.putString(ARG_PARAM1, param1);
        args.putString(ARG_PARAM2, param2);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
            mParam1 = getArguments().getString(ARG_PARAM1);
            mParam2 = getArguments().getString(ARG_PARAM2);
        }

        //Chama o metodo do singleton volley para carregar os produtos
        SingletonVolley.getInstance(getContext()).getProdutos(getContext(), new ProdutosListener() {
            @Override
            public void onProdutosResponse(JSONObject produtos) {
                //system out the response
                System.out.println(produtos);
                Toast.makeText(getContext(), "Produtos carregados com sucesso", Toast.LENGTH_SHORT).show();
                try {
                    JSONArray produtosArray = produtos.getJSONArray("produtos");
                    for (int i = 0; i < produtosArray.length(); i++) {
                        JSONObject produto = produtosArray.getJSONObject(i);
                        Product product = new Product();
                        product.setId(produto.getInt("id"));
                        product.setNome(produto.getString("nome"));
                        product.setCategoria(produto.getString("categoria"));
                        product.setCategoria_id(produto.getInt("categoria_id"));
                        product.setFilename(produto.getString("filename"));
                        product.setPreco(produto.getString("preco"));
                        product.setPrecoPromo(produto.getString("precoPromo"));
                        product.setDescricao(produto.getString("descricao"));
                        productList.add(product);
                    }
                    // Notify the adapter that the data has changed

                    getActivity().runOnUiThread(() -> {
                        RecyclerView recyclerView = getView().findViewById(R.id.recycler_view_products);
                        ProductAdapter adapter = (ProductAdapter) recyclerView.getAdapter();
                        if (adapter != null) {
                            adapter.notifyDataSetChanged();
                        }
                    });


                } catch (JSONException e) {
                    //system out the error
                    System.out.println(e);
                    System.out.println("Fiz porcaria no try catch");
                    throw new RuntimeException(e);

                }


            }
        });

    }

    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_home, container, false);


    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        // Referências aos componentes da vista
        RecyclerView recyclerView = view.findViewById(R.id.recycler_view_products);
        TextView noConnectionMessage = view.findViewById(R.id.no_connection_message);

        // Verificar conexão à Internet
        if (!NetworkUtils.isConnectionInternet(getContext())) {
            // Sem ligação à Internet
            noConnectionMessage.setVisibility(View.VISIBLE);
            recyclerView.setVisibility(View.GONE);
        } else {
            // Com ligação à Internet
            noConnectionMessage.setVisibility(View.GONE);
            recyclerView.setVisibility(View.VISIBLE);

            // Configurar RecyclerView
            recyclerView.setLayoutManager(new GridLayoutManager(getContext(), 2)); // 2 colunas
            ProductAdapter adapter = new ProductAdapter(productList);
            recyclerView.setAdapter(adapter);
        }
    }


}