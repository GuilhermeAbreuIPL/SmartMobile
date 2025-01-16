package com.example.smartmobile;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.database.sqlite.SQLiteDatabase;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;

import com.example.smartmobile.listeners.AddCarrinhoListener;
import com.example.smartmobile.listeners.MoradaListener;
import com.example.smartmobile.listeners.UserListener;
import com.example.smartmobile.models.DatabaseHelper;
import com.example.smartmobile.models.MoradaModel;
import com.example.smartmobile.models.Product;
import com.example.smartmobile.network.NetworkUtils;
import com.example.smartmobile.network.SingletonVolley;
import com.google.android.material.navigation.NavigationView;

import org.json.JSONArray;
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

        // Inicia o fragmento principal
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
        if (item.getItemId() == R.id.nav_mudarip) {
            fragment = new IpFragment(); // Exemplo de fragmento
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

    public void onClickDadosPessoais(View view) {
        ConfigFragment configFragment = new ConfigFragment();
        getSupportFragmentManager()
                .beginTransaction()
                .replace(R.id.fragment_container, configFragment)
                .addToBackStack(null)
                .commit();
    }

    public void onClickProduct(View view) {
        String tag = view.getTag().toString();

        ProductDetailsFragment productDetailsFragment = new ProductDetailsFragment();

        Bundle bundle = new Bundle();
        bundle.putString("product_id", tag);
        productDetailsFragment.setArguments(bundle);

        getSupportFragmentManager()
                .beginTransaction()
                .replace(R.id.fragment_container, productDetailsFragment)
                .addToBackStack(null)
                .commit();
    }


    public void onClickEditMorada(View view) {
        //vais buscar a tag deste botao: btn_edit_morada
        String tag = view.getTag().toString();

        EditMoradaFragment editMoradaFragment = new EditMoradaFragment();

        // Criar um Bundle e adicionar a tag
        Bundle bundle = new Bundle();
        bundle.putString("tag", tag);
        System.out.println("Tag: " + tag);
        editMoradaFragment.setArguments(bundle);

        getSupportFragmentManager()
                .beginTransaction()
                .replace(R.id.fragment_container, editMoradaFragment)
                .addToBackStack(null)
                .commit();

    }

    public void onClickAddMorada(View view) {
        AddMoradaFragment addMoradaFragment = new AddMoradaFragment();
        getSupportFragmentManager()
                .beginTransaction()
                .replace(R.id.fragment_container, addMoradaFragment)
                .addToBackStack(null)
                .commit();
    }

    public void onClickEditUser(View view) {
        EditUserFragment editUserFragment = new EditUserFragment();
        getSupportFragmentManager()
                .beginTransaction()
                .replace(R.id.fragment_container, editUserFragment)
                .addToBackStack(null)
                .commit();
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

            SingletonVolley.getInstance(this).getMoradas(this, new MoradaListener() {
                @Override
                public void onMoradaResponse(JSONObject response) {
                    try {
                        boolean success = response.getBoolean("success");
                        if(success){
                            System.out.println("Morada data: " + response.toString());
                        }

                        JSONArray moradasArray = response.getJSONArray("moradas");

                        DatabaseHelper dbHelper = new DatabaseHelper(getApplicationContext());
                        SQLiteDatabase db = dbHelper.getWritableDatabase();

                        db.delete(MoradaModel.TABLE_NAME, null, null);

                        for (int i = 0; i < moradasArray.length(); i++) {
                            JSONObject moradaJson = moradasArray.getJSONObject(i);

                            MoradaModel morada = new MoradaModel(
                                    moradaJson.getInt("id"),
                                    moradaJson.getString("rua"),
                                    moradaJson.getString("localidade"),
                                    moradaJson.getString("codpostal"),
                                    moradaJson.getInt("user_id")
                            );

                            MoradaModel.insertMorada(db, morada);
                        }

                        db.close();

                    } catch (Exception e) {
                        e.printStackTrace();
                        System.out.println("Erro: " + e);
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

    public void onClickLogo(View view) {
        // Redirecionar para a HomeFragment
        Fragment homeFragment = new HomeFragment();
        getSupportFragmentManager()
                .beginTransaction()
                .replace(R.id.fragment_container, homeFragment)
                .commit();
    }

    public void onClickCartIcon(View view) {
        // Redirecionar para a CarrinhoFragment
        Fragment ShoppingCartFragment = new ShoppingCartFragment();

        getSupportFragmentManager()
                .beginTransaction()
                .replace(R.id.fragment_container, ShoppingCartFragment)
                .commit();
    }

    public void refreshCarrinho() {
        Fragment ShoppingCartFragment = new ShoppingCartFragment();
        getSupportFragmentManager()
                .beginTransaction()
                .replace(R.id.fragment_container, ShoppingCartFragment)
                .commit();
    }

    public void onClickAddCart(View view) {
        // Redirecionar para a CarrinhoFragment
        Fragment ShoppingCartFragment = new ShoppingCartFragment();
        String tag = view.getTag().toString();
        int productId = Integer.parseInt(tag);

        //Bundle bundle = new Bundle();
        System.out.println("Tag: " + tag);

        //bundle.putString("product_id", tag);
        //ShoppingCartFragment.setArguments(bundle);

        //adicionar ao carrinho
        SingletonVolley.getInstance(this).addCarrinhoProduto(this, productId, new AddCarrinhoListener() {
            @Override
            public void onCarrinhoAddResponse(JSONObject produto) {
                try {
                    boolean success = produto.getBoolean("success");
                    if (success) {
                        System.out.println("Produto adicionado ao carrinho: " + produto.toString());
                        Toast.makeText(MainActivity.this, "Produto adicionado ao carrinho", Toast.LENGTH_SHORT).show();
                    } else {
                        System.out.println("Erro ao adicionar produto ao carrinho: " + produto.toString());
                        Toast.makeText(MainActivity.this, "Erro ao adicionar produto ao carrinho", Toast.LENGTH_SHORT).show();
                    }
                } catch (Exception e) {
                    e.printStackTrace();
                    System.out.println("Erro: " + e);
                }
            }
        });


        getSupportFragmentManager()
                .beginTransaction()
                .replace(R.id.fragment_container, ShoppingCartFragment)
                .commit();
    }
}