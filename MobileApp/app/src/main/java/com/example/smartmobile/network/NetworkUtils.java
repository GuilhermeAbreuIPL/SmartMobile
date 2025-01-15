package com.example.smartmobile.network;

import android.content.Context;
import android.content.SharedPreferences;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import com.example.smartmobile.LoginActivity;

public class NetworkUtils {
    public static boolean isConnectionInternet(Context context) {
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo netInfo = cm.getActiveNetworkInfo();

        SharedPreferences prefs1 = context.getSharedPreferences("IP", LoginActivity.MODE_PRIVATE);
        String ip = prefs1.getString("ip", "172.22.21.218");

        if (!ip.equals("localhost") && !ip.equals("172.22.21.218")) {
            //retorna false
            return false;
        }

        return (netInfo != null && netInfo.isConnectedOrConnecting());
    }
}

