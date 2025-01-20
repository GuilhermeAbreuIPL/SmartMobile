package com.example.smartmobile.network;

import static java.security.AccessController.getContext;

import android.content.Context;
import android.content.SharedPreferences;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.TimeoutError;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;
import com.android.volley.RequestQueue;
import com.example.smartmobile.LoginActivity;
import com.example.smartmobile.listeners.AddCarrinhoListener;
import com.example.smartmobile.listeners.CheckoutListener;
import com.example.smartmobile.listeners.FaturaListener;
import com.example.smartmobile.listeners.GetCarrinhoListener;
import com.example.smartmobile.listeners.MetodoPagamentoListener;
import com.example.smartmobile.listeners.ProdutosListener;
import com.example.smartmobile.listeners.MoradaListener;
import com.example.smartmobile.listeners.SignupListener;
import com.example.smartmobile.listeners.LoginListener;
import com.example.smartmobile.listeners.UpdateCarrinhoListener;
import com.example.smartmobile.listeners.UserListener;
import com.example.smartmobile.models.MoradaModel;
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

    private final String BaseIp = "172.22.21.218";

    private String BASE_URL(String ip) {
        return "http://" + ip + "/SmartMobile/SmartMobileWebApp/backend/web/api/";
    }

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

            //buscar o ip do SharedPreferences
            SharedPreferences prefs = context.getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
            String ip = prefs.getString("ip", BaseIp);

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.POST, BASE_URL(ip) + "auth/register", jsonParams, new Response.Listener<JSONObject>() {
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

            //buscar o ip do SharedPreferences
            SharedPreferences prefs = context.getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
            String ip = prefs.getString("ip", BaseIp);

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.POST, BASE_URL(ip) + "auth/login", jsonParams, new Response.Listener<JSONObject>() {
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

            //buscar o ip do SharedPreferences
            SharedPreferences prefs1 = context.getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
            String ip = prefs1.getString("ip", BaseIp);

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.GET, BASE_URL(ip) + "user?access-token=" + accessToken,null , new Response.Listener<JSONObject>() {
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

    public void updateUser(Context context, UserListener userListener, JSONObject user){
        // Teste da internet
        if (!NetworkUtils.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            //Log to console see if token is saved
            SharedPreferences prefs = context.getSharedPreferences("AppPrefs", LoginActivity.MODE_PRIVATE);
            String accessToken = prefs.getString("access_token", null);
            System.out.println("Token: " + accessToken);

            //log to console user
            System.out.println("User Voley: " + user.toString());

            //buscar o ip do SharedPreferences
            SharedPreferences prefs1 = context.getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
            String ip = prefs1.getString("ip", BaseIp);

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.PUT, BASE_URL(ip) + "user?access-token=" + accessToken, user, new Response.Listener<JSONObject>() {
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

    public void getProdutos(Context context, ProdutosListener listener){
        //verifica se tenho ligação à internet
        if (!NetworkUtils.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            //buscar o ip do SharedPreferences
            SharedPreferences prefs = context.getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
            String ip = prefs.getString("ip", BaseIp);

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.GET, BASE_URL(ip) + "produtos", null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    //Log to console response
                    //System.out.println(response.toString());
                    Toast.makeText(context, "Recebi uma response", Toast.LENGTH_SHORT).show();
                    if (listener != null) {
                        try {
                            listener.onProdutosResponse(response);
                        } catch (JSONException e) {
                            throw new RuntimeException(e);
                        }
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    testTimeoutError(context, error);
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

    public void getProdutoDetails(Context context, int id, ProdutosListener listener){
        //verifica se tenho ligação à internet
        if (!NetworkUtils.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            //buscar o ip do SharedPreferences
            SharedPreferences prefs = context.getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
            String ip = prefs.getString("ip", BaseIp);

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.GET, BASE_URL(ip) + "produtos/" + id, null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    //Log to console response
                    //System.out.println(response.toString());
                    Toast.makeText(context, "Recebi uma response", Toast.LENGTH_SHORT).show();
                    if (listener != null) {
                        try {
                            listener.onProdutosResponse(response);
                        } catch (JSONException e) {
                            throw new RuntimeException(e);
                        }
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
    
    
    public void getMoradas(Context context, MoradaListener moradaListener) {
        // Teste da internet
        if (!NetworkUtils.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            //Log to console see if token is saved
            SharedPreferences prefs = context.getSharedPreferences("AppPrefs", LoginActivity.MODE_PRIVATE);
            String accessToken = prefs.getString("access_token", null);
            System.out.println("Token: " + accessToken);

            //buscar o ip do SharedPreferences
            SharedPreferences prefs1 = context.getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
            String ip = prefs1.getString("ip", BaseIp);

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.GET, BASE_URL(ip) + "user/moradas?access-token=" + accessToken,null , new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    //Log to console response
                    System.out.println(response.toString());
                    Toast.makeText(context, "Recebi uma response", Toast.LENGTH_SHORT).show();
                    if (moradaListener != null) {
                        moradaListener.onMoradaResponse(response);
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

    public void addMoradas(Context context, MoradaListener moradaListener, JSONObject morada) {
        // Teste da internet
        if (!NetworkUtils.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            //Log to console see if token is saved
            SharedPreferences prefs = context.getSharedPreferences("AppPrefs", LoginActivity.MODE_PRIVATE);
            String accessToken = prefs.getString("access_token", null);
            System.out.println("Token: " + accessToken);

            //log to console morada
            System.out.println(morada.toString());

            //buscar o ip do SharedPreferences
            SharedPreferences prefs1 = context.getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
            String ip = prefs1.getString("ip", BaseIp);

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.POST, BASE_URL(ip) + "user/create-morada?access-token=" + accessToken, morada, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    //Log to console response
                    System.out.println(response.toString());
                    Toast.makeText(context, "Recebi uma response", Toast.LENGTH_SHORT).show();
                    if (moradaListener != null) {
                        moradaListener.onMoradaResponse(response);
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

    public void updateMoradas(Context context, MoradaListener moradaListener, JSONObject morada, Integer moradaId) {
        // Teste da internet
        if (!NetworkUtils.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            //Log to console see if token is saved
            SharedPreferences prefs = context.getSharedPreferences("AppPrefs", LoginActivity.MODE_PRIVATE);
            String accessToken = prefs.getString("access_token", null);
            System.out.println("Token: " + accessToken);

            //log to console morada
            System.out.println("Morada ID: " + moradaId);

            //log to console jsonParams
            System.out.println(morada.toString());

            //buscar o ip do SharedPreferences
            SharedPreferences prefs1 = context.getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
            String ip = prefs1.getString("ip", BaseIp);

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.PUT, BASE_URL(ip) + "user/morada/" + moradaId + "?access-token=" + accessToken, morada, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    //Log to console response
                    System.out.println(response.toString());
                    Toast.makeText(context, "Recebi uma response", Toast.LENGTH_SHORT).show();
                    if (moradaListener != null) {
                        moradaListener.onMoradaResponse(response);
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

    public void deleteMoradas(Context context, MoradaListener moradaListener, Integer moradaId) {
        // Teste da internet
        if (!NetworkUtils.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            //Log to console see if token is saved
            SharedPreferences prefs = context.getSharedPreferences("AppPrefs", LoginActivity.MODE_PRIVATE);
            String accessToken = prefs.getString("access_token", null);
            System.out.println("Token: " + accessToken);

            //log to console morada
            System.out.println("Morada ID: " + moradaId);

            //buscar o ip do SharedPreferences
            SharedPreferences prefs1 = context.getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
            String ip = prefs1.getString("ip", BaseIp);

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.DELETE, BASE_URL(ip) + "user/morada/" + moradaId + "?access-token=" + accessToken, null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    //Log to console response
                    System.out.println(response.toString());
                    Toast.makeText(context, "Recebi uma response", Toast.LENGTH_SHORT).show();
                    if (moradaListener != null) {
                        moradaListener.onMoradaResponse(response);
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

    public void addCarrinhoProduto(Context context, int id, AddCarrinhoListener listener){
        //verifica se tenho ligação à internet
        if (!NetworkUtils.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences prefs = context.getSharedPreferences("AppPrefs", LoginActivity.MODE_PRIVATE);
            String accessToken = prefs.getString("access_token", null);
            System.out.println("Token: " + accessToken);
            System.out.println("ID: " + id);

            //buscar o ip do SharedPreferences
            SharedPreferences prefs1 = context.getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
            String ip = prefs1.getString("ip", BaseIp);

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.POST, BASE_URL(ip) + "carrinho/add/" + id +"?access-token="+accessToken, null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    //Log to console response
                    System.out.println(response.toString());
                    Toast.makeText(context, "Recebi uma response", Toast.LENGTH_SHORT).show();
                    if (listener != null) {
                        listener.onCarrinhoAddResponse(response);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log to console error
                    System.out.println(error.toString());
                    Toast.makeText(context, "Error durante o addcarrinho", Toast.LENGTH_SHORT).show();
                    int statusCode = error.networkResponse.statusCode;
                    String responseBody = new String(error.networkResponse.data);
                    System.out.println("Error Code: " + statusCode);
                    System.out.println("Response Body: " + responseBody);
                }
            });
            volleyQueue.add(req);
        }



    }

    //Função para o getCarrinho
    public void getCarrinho(Context context, GetCarrinhoListener listener){
        //verifica se tenho ligação à internet
        if (!NetworkUtils.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences prefs = context.getSharedPreferences("AppPrefs", LoginActivity.MODE_PRIVATE);
            String accessToken = prefs.getString("access_token", null);
            System.out.println("Token: " + accessToken);

            //buscar o ip do SharedPreferences
            SharedPreferences prefs1 = context.getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
            String ip = prefs1.getString("ip", BaseIp);

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.GET, BASE_URL(ip) + "carrinho?access-token="+accessToken, null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    //Log to console response
                    System.out.println(response.toString());
                    Toast.makeText(context, "Recebi uma response", Toast.LENGTH_SHORT).show();
                    if (listener != null) {
                        listener.onGetCarrinhoResponse(response);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log to console error
                    System.out.println(error.toString());
                    Toast.makeText(context, "Error durante o addcarrinho", Toast.LENGTH_SHORT).show();
                    int statusCode = error.networkResponse.statusCode;
                    String responseBody = new String(error.networkResponse.data);
                    System.out.println("Error Code: " + statusCode);
                    System.out.println("Response Body: " + responseBody);
                }
            });
            volleyQueue.add(req);
        }
    }

    public void updateCarrinhoProduto(Context context, int id, int quantidade, UpdateCarrinhoListener listener){
        //verifica se tenho ligação à internet
        if (!NetworkUtils.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences prefs = context.getSharedPreferences("AppPrefs", LoginActivity.MODE_PRIVATE);
            String accessToken = prefs.getString("access_token", null);
            System.out.println("Token: " + accessToken);
            System.out.println("ID: " + id);
            System.out.println("Quantidade: " + quantidade);

            //buscar o ip do SharedPreferences
            SharedPreferences prefs1 = context.getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
            String ip = prefs1.getString("ip", BaseIp);

            //passa a quantidade para string

            JSONObject jsonParams = new JSONObject();
            try {
                jsonParams.put("quantidade", String.valueOf(quantidade));
            } catch (JSONException e) {
                e.printStackTrace();
            }
            //log to console jsonParams
            System.out.println(jsonParams.toString());

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.PUT, BASE_URL(ip) + "carrinho/edit/" + id +"?access-token="+accessToken, jsonParams, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    //Log to console response
                    System.out.println(response.toString());
                    Toast.makeText(context, "Recebi uma response", Toast.LENGTH_SHORT).show();
                    if (listener != null) {
                        listener.onUpdateCarrinhoResponse(response);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log to console error
                    System.out.println(error.toString());
                    Toast.makeText(context, "Error durante o addcarrinho", Toast.LENGTH_SHORT).show();
                    int statusCode = error.networkResponse.statusCode;
                    String responseBody = new String(error.networkResponse.data);
                    System.out.println("Error Code: " + statusCode);
                    System.out.println("Response Body: " + responseBody);
                }
            });
            volleyQueue.add(req);
        }
    }

    public void getMetodoPagamento (Context context, MetodoPagamentoListener listener){
        //verifica se tenho ligação à internet
        if (!NetworkUtils.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            //buscar o ip do SharedPreferences
            SharedPreferences prefs1 = context.getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
            String ip = prefs1.getString("ip", BaseIp);

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.GET, BASE_URL(ip) + "metodos", null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    //Log to console response
                    System.out.println(response.toString());
                    Toast.makeText(context, "Recebi uma response", Toast.LENGTH_SHORT).show();
                    if (listener != null) {
                        listener.onMetodoPagamentoResponse(response);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log to console error
                    System.out.println(error.toString());
                    Toast.makeText(context, "Error durante o showcarrinho", Toast.LENGTH_SHORT).show();
                    int statusCode = error.networkResponse.statusCode;
                    String responseBody = new String(error.networkResponse.data);
                    System.out.println("Error Code: " + statusCode);
                    System.out.println("Response Body: " + responseBody);
                }
            });
            volleyQueue.add(req);
        }
    }

    public void checkout (Context context, JSONObject checkout, CheckoutListener listener){
        //verifica se tenho ligação à internet
        if (!NetworkUtils.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences prefs = context.getSharedPreferences("AppPrefs", LoginActivity.MODE_PRIVATE);
            String accessToken = prefs.getString("access_token", null);
            System.out.println("Token: " + accessToken);

            //buscar o ip do SharedPreferences
            SharedPreferences prefs1 = context.getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
            String ip = prefs1.getString("ip", BaseIp);

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.POST, BASE_URL(ip) + "carrinho/checkout?access-token="+accessToken, checkout, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    //Log to console response
                    System.out.println(response.toString());
                    Toast.makeText(context, "Recebi uma response", Toast.LENGTH_SHORT).show();
                    if (listener != null) {
                        listener.onCheckoutResponse(response);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log to console error
                    System.out.println(error.toString());
                    Toast.makeText(context, "Error durante o showcarrinho", Toast.LENGTH_SHORT).show();
                    int statusCode = error.networkResponse.statusCode;
                    String responseBody = new String(error.networkResponse.data);
                    System.out.println("Error Code: " + statusCode);
                    System.out.println("Response Body: " + responseBody);
                }
            });
            volleyQueue.add(req);
        }
    }

    public void getAllFaturas(Context context, FaturaListener listener){
        //verifica se tenho ligação à internet
        if (!NetworkUtils.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences prefs = context.getSharedPreferences("AppPrefs", LoginActivity.MODE_PRIVATE);
            String accessToken = prefs.getString("access_token", null);
            System.out.println("Token: " + accessToken);

            //buscar o ip do SharedPreferences
            SharedPreferences prefs1 = context.getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
            String ip = prefs1.getString("ip", BaseIp);

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.GET, BASE_URL(ip) + "faturas?access-token="+accessToken, null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    //Log to console response
                    System.out.println(response.toString());
                    Toast.makeText(context, "Recebi uma response", Toast.LENGTH_SHORT).show();
                    if (listener != null) {
                        listener.onFaturaResponse(response);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log to console error
                    System.out.println(error.toString());
                    Toast.makeText(context, "Error durante o showcarrinho", Toast.LENGTH_SHORT).show();
                    int statusCode = error.networkResponse.statusCode;
                    String responseBody = new String(error.networkResponse.data);
                    System.out.println("Error Code: " + statusCode);
                    System.out.println("Response Body: " + responseBody);
                }
            });
            volleyQueue.add(req);
        }
    }

    public void getFaturaDetails(Context context, String id, FaturaListener listener){
        //verifica se tenho ligação à internet
        if (!NetworkUtils.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences prefs = context.getSharedPreferences("AppPrefs", LoginActivity.MODE_PRIVATE);
            String accessToken = prefs.getString("access_token", null);
            System.out.println("Token: " + accessToken);

            //buscar o ip do SharedPreferences
            SharedPreferences prefs1 = context.getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
            String ip = prefs1.getString("ip", BaseIp);

            JsonObjectRequest req = new JsonObjectRequest(Request.Method.GET, BASE_URL(ip) + "faturas/" + id + "?access-token="+accessToken, null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    //Log to console response
                    System.out.println(response.toString());
                    Toast.makeText(context, "Recebi uma response", Toast.LENGTH_SHORT).show();
                    if (listener != null) {
                        listener.onFaturaResponse(response);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log to console error
                    System.out.println(error.toString());
                    Toast.makeText(context, "Error durante o showcarrinho", Toast.LENGTH_SHORT).show();
                    int statusCode = error.networkResponse.statusCode;
                    String responseBody = new String(error.networkResponse.data);
                    System.out.println("Error Code: " + statusCode);
                    System.out.println("Response Body: " + responseBody);
                }
            });
            volleyQueue.add(req);
        }
    }


    public void testTimeoutError(Context context,VolleyError error) {
        if (error instanceof TimeoutError) {
            Log.e("Fallback", "Tentando IP alternativo...");
            Toast.makeText(context, "Conectividade com o Servidor Falhou", Toast.LENGTH_SHORT).show();
        } else {
            Log.e("VolleyError", "Erro: " + error.getMessage());
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