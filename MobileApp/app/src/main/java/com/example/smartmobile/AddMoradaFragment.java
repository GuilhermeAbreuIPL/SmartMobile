package com.example.smartmobile;

import android.database.sqlite.SQLiteDatabase;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentTransaction;

import com.example.smartmobile.listeners.MoradaListener;
import com.example.smartmobile.models.DatabaseHelper;
import com.example.smartmobile.models.MoradaModel;
import com.example.smartmobile.network.NetworkUtils;
import com.example.smartmobile.network.SingletonVolley;

import org.json.JSONException;
import org.json.JSONObject;

public class AddMoradaFragment extends Fragment {
    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_addmorada, container, false);
    }

    @Override
    public void onResume() {
        super.onResume();

        if (!NetworkUtils.isConnectionInternet(getContext())) {
            Toast.makeText(getContext(), "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            DatabaseHelper dbHelper = new DatabaseHelper(requireContext());
            SQLiteDatabase db = dbHelper.getReadableDatabase();


            getView().findViewById(R.id.btn_guardar).setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    TextView et_rua = getView().findViewById(R.id.et_rua);
                    TextView et_localidade = getView().findViewById(R.id.et_localidade);
                    TextView et_codpostal = getView().findViewById(R.id.et_codpostal);

                    // Enviar a morada para o servidor
                    JSONObject jsonMorada = new JSONObject();
                    try {
                        jsonMorada.put("rua", et_rua.getText().toString());
                        jsonMorada.put("localidade", et_localidade.getText().toString());
                        jsonMorada.put("codpostal", et_codpostal.getText().toString());
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }

                    // Instância do listener para capturar a resposta
                    MoradaListener moradaListener = new MoradaListener() {
                        @Override
                        public void onMoradaResponse(JSONObject response) {
                            // Tratar a resposta do servidor
                            Toast.makeText(getContext(), "Morada atualizada com sucesso!", Toast.LENGTH_SHORT).show();

                            Fragment ProfileFragment = new ProfileFragment();
                            FragmentTransaction transaction = requireActivity().getSupportFragmentManager().beginTransaction();
                            transaction.replace(R.id.fragment_container, ProfileFragment);
                            transaction.commit();
                        }
                    };

                    SingletonVolley.getInstance(getContext()).addMoradas(
                            getContext(),
                            moradaListener,
                            jsonMorada
                    );

                    Fragment ProfileFragment = new ProfileFragment();
                    FragmentTransaction transaction = requireActivity().getSupportFragmentManager().beginTransaction();
                    transaction.replace(R.id.fragment_container, ProfileFragment);
                    transaction.commit();
                }
            });

            getView().findViewById(R.id.btn_close).setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    Fragment ProfileFragment = new ProfileFragment();
                    FragmentTransaction transaction = requireActivity().getSupportFragmentManager().beginTransaction();
                    transaction.replace(R.id.fragment_container, ProfileFragment);
                    transaction.commit();
                }
            });
        }
    }
}
