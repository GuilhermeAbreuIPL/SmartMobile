package com.example.smartmobile.network;

import android.content.Context;
import android.content.SharedPreferences;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;
import com.android.volley.RequestQueue;
import com.example.smartmobile.LoginActivity;
import com.example.smartmobile.listeners.SignupListener;
import com.example.smartmobile.listeners.LoginListener;
import com.example.smartmobile.listeners.UserListener;
import com.example.smartmobile.models.UserDetails;
import com.example.smartmobile.models.UserLogin;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class SingletonVolley{

    //Inicializacao dos listeners
    private SignupListener signupListener;
    private LoginListener loginListener;

    private UserListener userListener;

    private static volatile SingletonVolley instance = null;

    public static RequestQueue volleyQueue;

    private static final String BASE_URL = "http://172.22.21.218/SmartMobile/SmartMobileWebApp/backend/web/api/";



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

                    // Extract the token from the response
                    JSONObject tokenObject = null; // Extrair o objeto "token"
                    try {
                        tokenObject = response.getJSONObject("token");
                    } catch (JSONException e) {
                        throw new RuntimeException(e);
                    }

                    String token = null;
                    try {
                        token = tokenObject.getString("access_token");
                    } catch (JSONException e) {
                        throw new RuntimeException(e);
                    }

                    // Save the token in SharedPreferences
                    SharedPreferences sharedPreferences = context.getSharedPreferences("AppPrefs", LoginActivity.MODE_PRIVATE);
                    SharedPreferences.Editor editor = sharedPreferences.edit();
                    editor.putString("access_token", token);
                    editor.commit();

                    //Log to console see if token is saved
                    SharedPreferences sharedPreferences1 = context.getSharedPreferences("AppPrefs", LoginActivity.MODE_PRIVATE);
                    String test = sharedPreferences1.getString("access_token", null);
                    System.out.println("Token: " + test);

                    // Notify listener if required
                    loginListener.onUpdateLogin(token);
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

    public void login(UserLogin user, Context context) {
        // Teste da internet
        if (!NetworkUtils.isConnectionInternet(context)) {
            loginListener.onUpdateLogin((UserLogin) null);
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            JSONObject jsonParams = new JSONObject();
            try {
                jsonParams.put("username", user.getUsername());
                jsonParams.put("password", user.getPassword());
            } catch (JSONException e) {
                e.printStackTrace();
            }
            //log to console jsonParams
            System.out.println(jsonParams.toString());

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.POST, BASE_URL + "auth/login", jsonParams, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    //Log to console response
                    System.out.println(response.toString());
                    Toast.makeText(context, "Recebi uma response", Toast.LENGTH_SHORT).show();

                    try {
                        // Extract the token from the response
                        String token = response.getString("access_token");

                        // Save the token in SharedPreferences
                        SharedPreferences sharedPreferences = context.getSharedPreferences("AppPrefs", Context.MODE_PRIVATE);
                        SharedPreferences.Editor editor = sharedPreferences.edit();
                        editor.putString("access_token", token);
                        editor.commit();

                        //Log to console see if token is saved
                        SharedPreferences prefs = context.getSharedPreferences("AppPrefs", Context.MODE_PRIVATE);
                        String accessToken = prefs.getString("access_token", null);
                        System.out.println("Token: " + accessToken);

                        // Notify listener if required
                        loginListener.onUpdateLogin(token);

                    } catch (JSONException e) {
                        e.printStackTrace();
                        Toast.makeText(context, "Erro ao processar resposta", Toast.LENGTH_SHORT).show();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log to console error
                    System.out.println(error.toString());
                    Toast.makeText(context, "Error durante o login", Toast.LENGTH_SHORT).show();
                    int statusCode = error.networkResponse.statusCode;
                    String responseBody = new String(error.networkResponse.data);
                    System.out.println("Error Code: " + statusCode);
                    System.out.println("Response Body: " + responseBody);
                }
            });
            volleyQueue.add(req);
        }
    }

    public void getUser(String token, Context context, UserListener userListener) {
        // Teste da internet
        if (!NetworkUtils.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            //Log to console see if token is saved
            SharedPreferences prefs = context.getSharedPreferences("AppPrefs", LoginActivity.MODE_PRIVATE);
            String accessToken = prefs.getString("access_token", null);
            System.out.println("Token: " + accessToken);

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.GET, BASE_URL + "user?access-token=" + accessToken,null , new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    //Log to console response
                    System.out.println(response.toString());
                    Toast.makeText(context, "Recebi uma response", Toast.LENGTH_SHORT).show();
                    if (userListener != null) {
                        userListener.onUserResponse(response);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log to console error
                    System.out.println(error.toString());
                    Toast.makeText(context, "Error durante o login", Toast.LENGTH_SHORT).show();
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

    public void setLoginListener(LoginListener loginListener) {
        this.loginListener = loginListener;
    }

    public void setUserListener(UserListener userListener) {
        this.userListener = userListener;
    }

}