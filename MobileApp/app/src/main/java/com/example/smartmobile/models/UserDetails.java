package com.example.smartmobile.models;

public class UserDetails {
    //Atributos UserForm
    private String nome;
    private String username;
    private String email;
    private String nif;
    private String telemovel;
    private String password;

    //Construtor UserDetails
    public UserDetails(String nome, String username, String email, String nif, String telemovel, String password) {
        this.nome = nome;
        this.username = username;
        this.email = email;
        this.nif = nif;
        this.telemovel = telemovel;
        this.password = password;
    }

    //Getters e Setters
    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getNif() {
        return nif;
    }

    public void setNif(String nif) {
        this.nif = nif;
    }

    public String getTelemovel() {
        return telemovel;
    }

    public void setTelemovel(String telemovel) {
        this.telemovel = telemovel;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

}
