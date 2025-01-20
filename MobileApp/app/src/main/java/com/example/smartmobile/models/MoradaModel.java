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

    public MoradaModel(){

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


    // Contar o número de moradas de um usuário
    public static int countMoradasUser(SQLiteDatabase db) {
        String query = "SELECT COUNT(*) FROM " + TABLE_NAME;
        Cursor cursor = db.rawQuery(query, null);
        int count = 0;
        if (cursor.moveToFirst()) {
            count = cursor.getInt(0);
        }
        cursor.close();
        return count;
    }

    public static List<MoradaModel> getMoradasUser(SQLiteDatabase db) {
        List<MoradaModel> moradas = new ArrayList<>();
        String query = "SELECT * FROM " + TABLE_NAME;
        Cursor cursor = db.rawQuery(query, null);
        if (cursor.moveToFirst()) {
            do {
                int idIndex = cursor.getColumnIndex(COLUMN_ID);
                int ruaIndex = cursor.getColumnIndex(COLUMN_RUA);
                int localidadeIndex = cursor.getColumnIndex(COLUMN_LOCALIDADE);
                int codPostalIndex = cursor.getColumnIndex(COLUMN_CODPOSTAL);
                int userIdIndex = cursor.getColumnIndex(COLUMN_USER_ID);

                if (idIndex >= 0 && ruaIndex >= 0 && localidadeIndex >= 0 && codPostalIndex >= 0 && userIdIndex >= 0) {
                    int id = cursor.getInt(idIndex);
                    String rua = cursor.getString(ruaIndex);
                    String localidade = cursor.getString(localidadeIndex);
                    String codPostal = cursor.getString(codPostalIndex);
                    int userIdFromDb = cursor.getInt(userIdIndex);

                    moradas.add(new MoradaModel(id, rua, localidade, codPostal, userIdFromDb));
                } else {
                    // If any column doesn't exist, it means the table doesn't exist
                    break;
                }
            } while (cursor.moveToNext());
        }else{

        }
        cursor.close();
        System.out.println("Moradas no model:"+ moradas);
        return moradas;
    }

    // Obter uma morada pelo ID da morada
    public static MoradaModel getMoradaById(SQLiteDatabase db, int id) {
        MoradaModel morada = null;
        String query = "SELECT * FROM " + TABLE_NAME + " WHERE " + COLUMN_ID + " = ?";
        Cursor cursor = db.rawQuery(query, new String[]{String.valueOf(id)});

        if (cursor.moveToFirst()) {
            int idIndex = cursor.getColumnIndex(COLUMN_ID);
            int ruaIndex = cursor.getColumnIndex(COLUMN_RUA);
            int localidadeIndex = cursor.getColumnIndex(COLUMN_LOCALIDADE);
            int codPostalIndex = cursor.getColumnIndex(COLUMN_CODPOSTAL);
            int userIdIndex = cursor.getColumnIndex(COLUMN_USER_ID);

            if (idIndex >= 0 && ruaIndex >= 0 && localidadeIndex >= 0 && codPostalIndex >= 0 && userIdIndex >= 0) {
                int moradaId = cursor.getInt(idIndex);
                String rua = cursor.getString(ruaIndex);
                String localidade = cursor.getString(localidadeIndex);
                String codPostal = cursor.getString(codPostalIndex);
                int userId = cursor.getInt(userIdIndex);

                morada = new MoradaModel(moradaId, rua, localidade, codPostal, userId);
            }
        }

        cursor.close();
        return morada;
    }

}

