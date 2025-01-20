package com.example.smartmobile.listeners;

import com.example.smartmobile.models.Product;

import org.json.JSONException;
import org.json.JSONObject;

public interface ProdutosListener {
    void onProdutosResponse(JSONObject produtos) throws JSONException;
}
