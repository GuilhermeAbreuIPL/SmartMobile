package com.example.smartmobile.models;

import android.content.ContentValues;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;

import java.util.ArrayList;
import java.util.List;

public class MoradaModel {
    // Nome da tabela e colunas
    public static final String TABLE_NAME = "moradas";
    public static final String COLUMN_ID = "id";
    public static final String COLUMN_RUA = "rua";
    public static final String COLUMN_LOCALIDADE = "localidade";
    public static final String COLUMN_CODPOSTAL = "codpostal";
    public static final String COLUMN_USER_ID = "user_id";

    // SQL para criar a tabela
    public static final String CREATE_TABLE =
            "CREATE TABLE " + TABLE_NAME + " (" +
                    COLUMN_ID + " INTEGER PRIMARY KEY, " +
                    COLUMN_RUA + " TEXT, " +
                    COLUMN_LOCALIDADE + " TEXT, " +
                    COLUMN_CODPOSTAL + " TEXT, " +
                    COLUMN_USER_ID + " INTEGER)";

    // Atributos
    private int id;
    private String rua;
    private String localidade;
    private String codPostal;
    private int userId;

    // Construtor
    public MoradaModel(int id, String rua, String localidade, String codPostal, int userId) {
        this.id = id;
        this.rua = rua;
        this.localidade = localidade;
        this.codPostal = codPostal;
        this.userId = userId;
    }

    // Getters e Setters
    public int getId() { return id; }
    public void setId(int id) { this.id = id; }

    public String getRua() { return rua; }
    public void setRua(String rua) { this.rua = rua; }

    public String getLocalidade() { return localidade; }
    public void setLocalidade(String localidade) { this.localidade = localidade; }

    public String getCodPostal() { return codPostal; }
    public void setCodPostal(String codPostal) { this.codPostal = codPostal; }

    public int getUserId() { return userId; }
    public void setUserId(int userId) { this.userId = userId; }

    // Inserir uma morada no banco de dados
    public static void insertMorada(SQLiteDatabase db, MoradaModel morada) {

        ContentValues values = new ContentValues();
        values.put(COLUMN_ID, morada.getId());
        values.put(COLUMN_RUA, morada.getRua());
        values.put(COLUMN_LOCALIDADE, morada.getLocalidade());
        values.put(COLUMN_CODPOSTAL, morada.getCodPostal());
        values.put(COLUMN_USER_ID, morada.getUserId());
        db.insert(TABLE_NAME, null, values);
    }




}

