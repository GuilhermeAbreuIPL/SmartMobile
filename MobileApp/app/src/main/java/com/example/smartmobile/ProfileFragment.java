package com.example.smartmobile;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.fragment.app.Fragment;
import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import com.example.smartmobile.listeners.UserListener;

public class ProfileFragment extends Fragment{

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_profile, container, false);
    }

    @Override
    public void onResume() {
        super.onResume();

        // Verifique novamente o estado de login
        boolean isLoggedIn = ((MainActivity) getActivity()).isUserLoggedIn();
        View view = getView(); // Obtém a View do fragmento
        if (view != null) {
            TextView tv_profile = view.findViewById(R.id.tv_profile);
            View authContainer = view.findViewById(R.id.authcontainer);
            View logoutContainer = view.findViewById(R.id.logoutcontainer);
            View DadosPessoaisContainer = view.findViewById(R.id.dadospessoaiscontainer);
            View MinhasEncomendasContainer = view.findViewById(R.id.minhasencomendascontainer);

            if (isLoggedIn) {
                authContainer.setVisibility(View.GONE);
                logoutContainer.setVisibility(View.VISIBLE);
                DadosPessoaisContainer.setVisibility(View.VISIBLE);
                MinhasEncomendasContainer.setVisibility(View.VISIBLE);
                tv_profile.setText("Deseja terminar a sessão?");
            } else {
                authContainer.setVisibility(View.VISIBLE);
                logoutContainer.setVisibility(View.GONE);
                DadosPessoaisContainer.setVisibility(View.GONE);
                MinhasEncomendasContainer.setVisibility(View.GONE);
                tv_profile.setText("Olá! Faz já o teu Registo no smartmobile");
            }
        }
    }
}