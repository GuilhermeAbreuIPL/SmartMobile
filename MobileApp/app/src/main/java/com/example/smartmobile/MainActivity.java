package com.example.smartmobile;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.graphics.Insets;
import androidx.core.view.GravityCompat;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;

import com.example.smartmobile.listeners.UserListener;
import com.example.smartmobile.network.SingletonVolley;
import com.google.android.material.navigation.NavigationView;

import org.json.JSONObject;

public class MainActivity extends AppCompatActivity{

    private DrawerLayout drawerLayout;
    private NavigationView navigationView;
    private ActionBarDrawerToggle toggle;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        // inicia a Toolbar
        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        // inicia a DrawerLayout
        drawerLayout = findViewById(R.id.drawer_layout);

        // inicia a NavigationView
        navigationView = findViewById(R.id.nav_view);

        toggle = new ActionBarDrawerToggle(
                this,
                drawerLayout,
                toolbar,
                R.string.open_nav,
                R.string.close_nav
        );

        drawerLayout.addDrawerListener(toggle);

        navigationView.setNavigationItemSelectedListener(this::onNavigationItemSelected);
        toggle.syncState();

        // inicia o fragment main
        if (savedInstanceState == null) {

            Fragment homeFragment = new HomeFragment();

            getSupportFragmentManager()
                    .beginTransaction()
                    .replace(R.id.fragment_container, homeFragment)
                    .commit();
        }


        carregarFragementoInicial();

    }



    @Override
    public void onBackPressed() {
        if (drawerLayout.isDrawerOpen(GravityCompat.START)) {
            drawerLayout.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    private boolean carregarFragementoInicial() {
        Menu menu = navigationView.getMenu();
        MenuItem item = menu.getItem(0);
        item.setChecked(true);
        return onNavigationItemSelected(item);
    }


    public boolean onNavigationItemSelected(@NonNull MenuItem item) {
        Fragment fragment = null;

        // Verifique o item selecionado e substitua o fragmento
        if (item.getItemId() == R.id.nav_perfil) {
            fragment = new ProfileFragment(); // Exemplo de fragmento
        }

        if (fragment != null) {
            getSupportFragmentManager()
                    .beginTransaction()
                    .replace(R.id.fragment_container, fragment)
                    .commit();
        }

        // Fechar o Drawer após a seleção
        drawerLayout.closeDrawer(GravityCompat.START);
        return true;
    }

    public void onClickSignup(View view) {
        // Redirecionar para a SignupActivity
        Intent intent = new Intent(this, SignupActivity.class);
        startActivity(intent);
    }

    public void onClickLogin(View view) {
        // Redirecionar para a LoginActivity
        Toast.makeText(this, "Login", Toast.LENGTH_SHORT).show();
        //debug to console
        Log.d("Login", "Login");
        Intent intent = new Intent(this, LoginActivity.class);
        startActivity(intent);
    }

    public void onClickLogout(View view) {
        // Redirecionar para a LoginActivity
        Toast.makeText(this, "Logout", Toast.LENGTH_SHORT).show();
        //debug to console
        Log.d("Logout", "Logout");
        // Clear the shared preferences
        SharedPreferences sharedPref = getSharedPreferences("AppPrefs", LoginActivity.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPref.edit();
        editor.clear(); // clear all data
        editor.apply(); // commit changes
        Intent intent = new Intent(this, LoginActivity.class);
        startActivity(intent);

    }




    public boolean isUserLoggedIn() {
        //Get Shared Preferences and check if user is logged in
        SharedPreferences sharedPreferences1 = getSharedPreferences("AppPrefs", LoginActivity.MODE_PRIVATE);
        String token = sharedPreferences1.getString("access_token", null);
        System.out.println("Token: " + token);


        if (token != null) {
            //aceceder aos dados que vem do UserListener
            SingletonVolley.getInstance(this).getUser(token, this, new UserListener() {
                @Override
                public void onUserResponse(JSONObject user) {
                    // Processar a resposta do usuário
                    //Acede ao objeto user e faz get de uma propriedad
                    try{
                        user.getString("success");
                        System.out.println("User data: " + user.toString());
                        //Guardar o user data no shared preferences
                        SharedPreferences sharedPref = getSharedPreferences("User", LoginActivity.MODE_PRIVATE);
                        SharedPreferences.Editor editor = sharedPref.edit();

                        JSONObject userObject = user.getJSONObject("user");
                        JSONObject userPObject = user.getJSONObject("userProfile");


                        //quero colocar no shared preferences o user data por cada atributo que o user tem
                        editor.putString("username", userObject.getString("username"));
                        System.out.println("Username: " + userObject.getString("username"));

                        editor.putString("nome", userPObject.getString("nome"));
                        System.out.println("Nome: " + userPObject.getString("nome"));

                        editor.putString("email", userObject.getString("email"));
                        System.out.println("Email: " + userObject.getString("email"));

                        editor.putString("nif", userPObject.getString("nif"));
                        System.out.println("NIF: " + userPObject.getString("nif"));

                        editor.putString("telemovel", userPObject.getString("telemovel"));
                        System.out.println("Telemovel: " + userPObject.getString("telemovel"));

                        editor.commit();

                    }catch (Exception e){
                        e.printStackTrace();
                        System.out.println("Erro: " + e);
                    }


                    if (user != null) {
                        Toast.makeText(MainActivity.this, "User data valid ", Toast.LENGTH_SHORT).show();
                    } else {
                        Toast.makeText(MainActivity.this, "Failed to get user data.", Toast.LENGTH_SHORT).show();
                    }
                }
            });
            //Receber a resposta do volley
            if (token != "") {
                System.out.println("Token Aceite: " + token);
                return true;
            }
            else {
                SharedPreferences sharedPref = getSharedPreferences("AppPrefs", LoginActivity.MODE_PRIVATE);
                SharedPreferences.Editor editor = sharedPref.edit();
                editor.clear(); // clear all data
                editor.commit(); // commit changes
                return false;
            }
        }
        else {
            return false;
        }
    }
}