package com.example.smartmobile.network;

import android.content.Context;
import android.widget.Toast;

import com.android.volley.toolbox.Volley;
import com.android.volley.RequestQueue;
import com.example.smartmobile.listeners.SignupListener;
import com.example.smartmobile.models.UserDetails;

import java.util.ArrayList;

public class SingletonVolley{

    //Inicializacao dos listeners
    private SignupListener signupListener;

    private static volatile SingletonVolley instance = null;
    public static RequestQueue volleyQueue;


    // Construtor privado para evitar instância externa
    private SingletonVolley(Context context) {
        volleyQueue = Volley.newRequestQueue(context.getApplicationContext());
    }

    public static synchronized SingletonVolley getInstance(Context context) {
        if (instance == null) {
            synchronized (SingletonVolley.class) {
                if (instance == null) {
                    instance = new SingletonVolley(context);
                }
            }
        }
        return instance;
    }

    //funções
    public void signup(UserDetails user, Context context) {
        // Teste da internet
        if (!NetworkUtils.isConnectionInternet(context)) {
            signupListener.onUpdateSignup(null);
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        }

    }




    //listeners
    public void setSignupListener(SignupListener signupListener) {
        this.signupListener = signupListener;
    }


}
