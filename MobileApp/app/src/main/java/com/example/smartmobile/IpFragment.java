package com.example.smartmobile;

import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentTransaction;

public class IpFragment extends Fragment {
    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_ip, container, false);
    }

    @Override
    public void onResume() {
        super.onResume();

        SharedPreferences prefs1 = getContext().getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
        String ip = prefs1.getString("ip", "172.22.21.218");

        EditText et_ip = getView().findViewById(R.id.et_ip);

        et_ip.setText(ip);

        getView().findViewById(R.id.btn_guardar).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                try {
                    SharedPreferences prefs = getContext().getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
                    SharedPreferences.Editor editor = prefs.edit();

                    editor.putString("ip", et_ip.getText().toString());
                    editor.commit();
                    System.out.println("IP guardada: " + et_ip.getText().toString());
                }
                catch (Exception e) {
                    e.printStackTrace();
                    System.out.println("Error: " + e.getMessage());
                }

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
