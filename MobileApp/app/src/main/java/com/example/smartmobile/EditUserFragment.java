package com.example.smartmobile;

import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentTransaction;

import com.example.smartmobile.listeners.MoradaListener;
import com.example.smartmobile.listeners.UserListener;
import com.example.smartmobile.network.NetworkUtils;
import com.example.smartmobile.network.SingletonVolley;

import org.json.JSONObject;

public class EditUserFragment extends Fragment {
    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_editperfil, container, false);
    }

    @Override
    public void onResume() {
        super.onResume();

        if (!NetworkUtils.isConnectionInternet(getContext())) {
            Toast.makeText(getContext(), "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
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

                EditText et_username = getView().findViewById(R.id.et_username);
                EditText et_nome = getView().findViewById(R.id.et_nome);
                EditText et_email = getView().findViewById(R.id.et_email);
                EditText et_nif = getView().findViewById(R.id.et_nif);
                EditText et_telemovel = getView().findViewById(R.id.et_telemovel);

                et_username.setText(username);
                et_nome.setText(nome);
                et_email.setText(email);
                et_nif.setText(nif);
                et_telemovel.setText(telemovel);
            }

            getView().findViewById(R.id.btn_guardar).setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {

                    try {
                        // Obter os campos EditText
                        EditText et_username = getView().findViewById(R.id.et_username);
                        EditText et_nome = getView().findViewById(R.id.et_nome);
                        EditText et_email = getView().findViewById(R.id.et_email);
                        EditText et_nif = getView().findViewById(R.id.et_nif);
                        EditText et_telemovel = getView().findViewById(R.id.et_telemovel);

                        // Obter os valores dos campos EditText
                        String username = et_username.getText().toString().trim();
                        String nome = et_nome.getText().toString().trim();
                        String email = et_email.getText().toString().trim();
                        String nif = et_nif.getText().toString().trim();
                        String telemovel = et_telemovel.getText().toString().trim();

                        // Criar o objeto JSON para "profile"
                        JSONObject profileJson = new JSONObject();
                        profileJson.put("nome", nome);
                        profileJson.put("nif", nif);
                        profileJson.put("telemovel", telemovel);

                        // Criar o objeto JSON para "user"
                        JSONObject userJson = new JSONObject();
                        userJson.put("username", username);
                        userJson.put("email", email);

                        // Criar o objeto JSON principal
                        JSONObject mainJson = new JSONObject();
                        mainJson.put("profile", profileJson);
                        mainJson.put("user", userJson);

                        UserListener userListener = new UserListener() {
                            @Override
                            public void onUserResponse(JSONObject response) {
                                // Guardar os dados do utilizador
                                SharedPreferences prefs = getContext().getSharedPreferences("User", LoginActivity.MODE_PRIVATE);
                                SharedPreferences.Editor editor = prefs.edit();
                                try {
                                    JSONObject data = response.getJSONObject("data");
                                    JSONObject user = data.getJSONObject("user");
                                    JSONObject profile = data.getJSONObject("profile");

                                    editor.putString("username", user.getString("username"));
                                    editor.putString("nome", profile.getString("nome"));
                                    editor.putString("email", user.getString("email"));
                                    editor.putString("nif", profile.getString("nif"));
                                    editor.putString("telemovel", profile.getString("telemovel"));
                                    editor.commit();

                                    Toast.makeText(getContext(), "Guardado com sucesso", Toast.LENGTH_SHORT).show();

                                    Fragment ProfileFragment = new ProfileFragment();
                                    FragmentTransaction transaction = requireActivity().getSupportFragmentManager().beginTransaction();
                                    transaction.replace(R.id.fragment_container, ProfileFragment);
                                    transaction.commit();
                                } catch (Exception e) {
                                    System.out.println("Erro: " + e);
                                    e.printStackTrace();
                                }
                            }
                        };

                        // Enviar o objeto JSON para o servidor
                        SingletonVolley.getInstance(getContext()).updateUser(
                                getContext(),
                                userListener,
                                mainJson
                        );
                    } catch (Exception e) {
                        e.printStackTrace();
                    }


                    Toast.makeText(getContext(), "Guardado com sucesso", Toast.LENGTH_SHORT).show();
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
