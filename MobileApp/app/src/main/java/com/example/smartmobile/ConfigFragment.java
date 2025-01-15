package com.example.smartmobile;

import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;
import android.database.sqlite.SQLiteDatabase;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

import androidx.fragment.app.Fragment;
import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.example.smartmobile.adapters.MoradaAdapter;
import com.example.smartmobile.adapters.ProductAdapter;
import com.example.smartmobile.models.DatabaseHelper;
import com.example.smartmobile.models.MoradaModel;
import com.example.smartmobile.network.NetworkUtils;

import java.util.ArrayList;
import java.util.List;

public class ConfigFragment extends Fragment {

    private List<MoradaModel> ListMoradas;

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_config, container, false);
    }

    @Override
    public void onResume() {
        super.onResume();
        if (!NetworkUtils.isConnectionInternet(getContext())) {
            Toast.makeText(getContext(), "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            //chama a funçaõ do mainactivity isUserLoggedIn
            ((MainActivity) getActivity()).isUserLoggedIn();
        }
        SharedPreferences prefs = getContext().getSharedPreferences("User", LoginActivity.MODE_PRIVATE);
        if (prefs == null) {
            Toast.makeText(getContext(), "Não existe um user guardado", Toast.LENGTH_SHORT).show();

            //volta para o login
            Intent intent = new Intent(getContext(), LoginActivity.class);
            startActivity(intent);
        }
        else {
            Toast.makeText(getContext(), "Existe um user guardado", Toast.LENGTH_SHORT).show();
            String username = prefs.getString("username", null);
            String nome = prefs.getString("nome", null);
            String email = prefs.getString("email", null);
            String nif = prefs.getString("nif", null);
            String telemovel = prefs.getString("telemovel", null);

            TextView tv_username = getView().findViewById(R.id.tv_username);
            TextView tv_nome = getView().findViewById(R.id.tv_nome);
            TextView tv_email = getView().findViewById(R.id.tv_email);
            TextView tv_nif = getView().findViewById(R.id.tv_nif);
            TextView tv_telemovel = getView().findViewById(R.id.tv_telemovel);

            tv_username.setText(username);
            tv_nome.setText(nome);
            tv_email.setText(email);
            tv_nif.setText(nif);
            tv_telemovel.setText(telemovel);
        }

        //morada
        DatabaseHelper dbHelper = new DatabaseHelper(requireContext());
        SQLiteDatabase db = dbHelper.getReadableDatabase();

        // Obter as moradas do usuário

        ListMoradas = MoradaModel.getMoradasUser(db);
        System.out.println(ListMoradas);

        //faz um if para o botão de adicionar morada desaparecer countMoradasUser
        if(MoradaModel.countMoradasUser(db) >= 3){
            getView().findViewById(R.id.btn_add_morada).setVisibility(View.GONE);
        }

        // Certifique-se de fechar o banco após o uso
        db.close();

        RecyclerView recyclerView = getView().findViewById(R.id.rv_moradas);
        recyclerView.setLayoutManager(new GridLayoutManager(getContext(), 1)); // 2 colunas


        // Configurar o adaptador
        MoradaAdapter adapter = new MoradaAdapter(ListMoradas);
        recyclerView.setAdapter(adapter);

        getView().findViewById(R.id.btn_close).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Activity activity = getActivity();
                if (activity != null) {
                    activity.onBackPressed();
                }
            }
        });
    }
}