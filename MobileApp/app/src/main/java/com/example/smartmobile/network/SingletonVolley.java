package com.example.smartmobile.network;

import android.content.Context;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;
import com.android.volley.RequestQueue;
import com.example.smartmobile.listeners.SignupListener;
import com.example.smartmobile.models.UserDetails;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class SingletonVolley{

    //Inicializacao dos listeners
    private SignupListener signupListener;

    private static volatile SingletonVolley instance = null;

    private static final String BASE_URL = "http://172.22.21.218/SmartMobile/SmartMobileWebApp/backend/web/api/";
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
        } else {
            JSONObject jsonParams = new JSONObject();
            try {
                jsonParams.put("nome", user.getNome());
                jsonParams.put("username", user.getUsername());
                jsonParams.put("email", user.getEmail());
                jsonParams.put("nif", user.getNif());
                jsonParams.put("telemovel", user.getTelemovel());
                jsonParams.put("password", user.getPassword());
            } catch (JSONException e) {
                e.printStackTrace();
            }
            //log to console jsonParams
            System.out.println(jsonParams.toString());

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.POST, BASE_URL + "auth/register", jsonParams, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    //Log to console response
                    System.out.println(response.toString());
                    Toast.makeText(context, "Recebi uma response", Toast.LENGTH_SHORT).show();
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log to console error
                    System.out.println(error.toString());
                    Toast.makeText(context, "Error durante o signup", Toast.LENGTH_SHORT).show();
                    int statusCode = error.networkResponse.statusCode;
                    String responseBody = new String(error.networkResponse.data);
                    System.out.println("Error Code: " + statusCode);
                    System.out.println("Response Body: " + responseBody);
                }
            });
            volleyQueue.add(req);
        }

    }




    //listeners
    public void setSignupListener(SignupListener signupListener) {
        this.signupListener = signupListener;
    }


}