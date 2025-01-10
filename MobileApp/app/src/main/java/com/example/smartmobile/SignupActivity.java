package com.example.smartmobile;

import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.smartmobile.models.UserDetails;
import com.example.smartmobile.network.SingletonVolley;

public class SignupActivity extends AppCompatActivity {

    private EditText etNome, etUsername, etEmail, etNif, etTelemovel, etPassword;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup);

        etNome = findViewById(R.id.etNome);
        etUsername = findViewById(R.id.etUsername);
        etEmail = findViewById(R.id.etEmail);
        etNif = findViewById(R.id.etNif);
        etTelemovel = findViewById(R.id.etTelemovel);
        etPassword = findViewById(R.id.etPassword);

    }


    public void onClickSignup(View view) {
        String nome = etNome.getText().toString();
        String username = etUsername.getText().toString();
        String email = etEmail.getText().toString();
        String nif = etNif.getText().toString();
        String telemovel = etTelemovel.getText().toString();
        String password = etPassword.getText().toString();

        if (nome.isEmpty() || username.isEmpty() || email.isEmpty() || nif.isEmpty() || telemovel.isEmpty() || password.isEmpty()) {
            Toast.makeText(this, "Por favor preencha todos os campos", Toast.LENGTH_SHORT).show();
            return;
        }

        UserDetails user = new UserDetails(nome, username, email, nif, telemovel, password);

        SingletonVolley.getInstance(this).signup(user, this);
    }
}