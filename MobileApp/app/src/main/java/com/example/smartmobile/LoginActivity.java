package com.example.smartmobile;

import static java.security.AccessController.getContext;

import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.example.smartmobile.listeners.LoginListener;
import com.example.smartmobile.models.UserLogin;
import com.example.smartmobile.network.NetworkUtils;
import com.example.smartmobile.network.SingletonVolley;

public class LoginActivity extends AppCompatActivity implements LoginListener {

    private EditText etUsername, etPassword;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        etUsername = findViewById(R.id.etUsername);
        etPassword = findViewById(R.id.etPassword);
    }

    public void onClickLogin(View view) {
        if (!NetworkUtils.isConnectionInternet(this)) {
            Toast.makeText(this, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            String username = etUsername.getText().toString();
            String password = etPassword.getText().toString();

            if (username.isEmpty() || password.isEmpty()) {
                Toast.makeText(this, "Por favor preencha todos os campos", Toast.LENGTH_SHORT).show();
                return;
            }

            UserLogin user = new UserLogin(username, password);

            SingletonVolley.getInstance(this).login(user, this);
        }
    }

    @Override
    public void onUpdateLogin(UserLogin user) {
        if (user != null) {
            // Login successful
            Toast.makeText(this, "Login successful! Token saved.", Toast.LENGTH_SHORT).show();
            // Proceed to the next activity or update UI
        } else {
            // Login failed
            Toast.makeText(this, "Login failed. Please try again.", Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    public void onUpdateLogin(String token) {
        if (token != null) {
            // Login successful
            Toast.makeText(this, "Login successful! Token saved.", Toast.LENGTH_SHORT).show();
            // Proceed to the next activity or update UI
        } else {
            // Login failed
            Toast.makeText(this, "Login failed. Please try again.", Toast.LENGTH_SHORT).show();
        }
    }
}