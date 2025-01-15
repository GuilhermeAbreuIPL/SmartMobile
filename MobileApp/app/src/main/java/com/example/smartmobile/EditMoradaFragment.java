package com.example.smartmobile;

import android.app.Activity;
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

import com.example.smartmobile.listeners.MoradaListener;
import com.example.smartmobile.models.DatabaseHelper;
import com.example.smartmobile.models.MoradaModel;
import com.example.smartmobile.network.SingletonVolley;

import org.json.JSONException;
import org.json.JSONObject;

public class EditMoradaFragment extends Fragment {
    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_editmorada, container, false);
    }

    @Override
    public void onResume() {
        super.onResume();
        Bundle bundle = this.getArguments();
        if (bundle != null) {
            String tag = bundle.getString("tag");

            DatabaseHelper dbHelper = new DatabaseHelper(requireContext());
            SQLiteDatabase db = dbHelper.getReadableDatabase();

            int moradaId = Integer.parseInt(tag);

            MoradaModel morada = MoradaModel.getMoradaById(db, moradaId);

            if (morada != null) {
                System.out.println("Morada encontrada:");
                System.out.println("Rua: " + morada.getRua());
                System.out.println("Localidade: " + morada.getLocalidade());
                System.out.println("Código Postal: " + morada.getCodPostal());

                // Atualizar a interface com os dados da morada encontrada et_rua et_localidade et_codpostal
                TextView et_rua = getView().findViewById(R.id.et_rua);
                TextView et_localidade = getView().findViewById(R.id.et_localidade);
                TextView et_codpostal = getView().findViewById(R.id.et_codpostal);

                et_rua.setText(morada.getRua());
                et_localidade.setText(morada.getLocalidade());
                et_codpostal.setText(morada.getCodPostal());


                getView().findViewById(R.id.btn_close).setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        Activity activity = getActivity();
                        if (activity != null) {
                            activity.onBackPressed();
                        }
                    }
                });


                // Adicionar um listener ao botão de guardar
                getView().findViewById(R.id.btn_guardar).setOnClickListener(new View.OnClickListener() {
                    //Corre o singleton para atualizar a morada
                    @Override
                    public void onClick(View v) {
                        String rua = et_rua.getText().toString();
                        String localidade = et_localidade.getText().toString();
                        String codpostal = et_codpostal.getText().toString();

                        try {
                            // Criar o JSONObject da morada
                            JSONObject moradaJson = new JSONObject();
                            moradaJson.put("rua", rua);
                            moradaJson.put("localidade", localidade);
                            moradaJson.put("codpostal", codpostal);

                            System.out.println("Morada JSON: " + moradaJson.toString());

                            // Instância do listener para capturar a resposta
                            MoradaListener moradaListener = new MoradaListener() {
                                @Override
                                public void onMoradaResponse(JSONObject response) {
                                    // Tratar a resposta do servidor
                                    Toast.makeText(getContext(), "Morada atualizada com sucesso!", Toast.LENGTH_SHORT).show();
                                    Activity activity = getActivity();
                                    if (activity != null) {
                                        activity.onBackPressed();
                                    }
                                }
                            };

                            SingletonVolley.getInstance(getContext()).updateMoradas(
                                    getContext(),
                                    moradaListener,
                                    moradaJson,
                                    moradaId
                            );

                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                });

            } else {
                System.out.println("Nenhuma morada encontrada com o ID " + moradaId);

            }

        }
        else {
            Toast.makeText(getContext(), "Erro ao carregar morada", Toast.LENGTH_SHORT).show();
            Activity activity = getActivity();
            if (activity != null) {
                activity.onBackPressed();
            }
        }
    }
}
