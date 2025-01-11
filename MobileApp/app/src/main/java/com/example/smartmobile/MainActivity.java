package com.example.smartmobile;

import android.content.Intent;
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

import com.google.android.material.navigation.NavigationView;

public class MainActivity extends AppCompatActivity {

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

    private boolean carregarFragementoInicial(){
        Menu menu = navigationView.getMenu();
        MenuItem item = menu.getItem(0);
        item.setChecked(true);
        return onNavigationItemSelected(item);
    }


    public boolean onNavigationItemSelected(@NonNull MenuItem item){
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
}