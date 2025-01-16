package com.example.smartmobile.adapters;

import android.text.Layout;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.RadioButton;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.smartmobile.R;
import com.example.smartmobile.listeners.MetodoPagamentoListener;
import com.example.smartmobile.models.MetodoPagamento;
import com.example.smartmobile.models.Product;

import java.util.ArrayList;
import java.util.List;

public class MetodoPagamentoAdapter extends RecyclerView.Adapter<MetodoPagamentoAdapter.MetodoPagamentoViewHolder> {
    private List<MetodoPagamento> metodoPagamentoList = new ArrayList<>();
    private MetodoPagamentoListener listener;
    private static int selectedPosition = -1;

    public static int getSelectedPosition() {
        return selectedPosition;
    }

    public MetodoPagamentoAdapter(List<MetodoPagamento> metodoPagamentoList) {
        this.metodoPagamentoList = metodoPagamentoList;
    }

    @NonNull
    @Override
    public MetodoPagamentoViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View inflate = layoutInflater.inflate(R.layout.item_payment, null);

        return new MetodoPagamentoViewHolder(inflate);
    }

    @Override
    public void onBindViewHolder(@NonNull MetodoPagamentoViewHolder holder, int position) {
        MetodoPagamento metodoPagamento = metodoPagamentoList.get(position);
        holder.metodoPagamentoNome.setText(metodoPagamento.getNome());

        // Configurar o estado do RadioButton com base na posição selecionada
        holder.metodoPagamentoRadio.setChecked(position == selectedPosition);

        // Listener para atualizar a posição selecionada
        holder.metodoPagamentoRadio.setOnClickListener(v -> {
            int previousSelectedPosition = selectedPosition;
            selectedPosition = holder.getAdapterPosition();

            // Notificar apenas os itens que mudaram para melhorar a performance
            notifyItemChanged(previousSelectedPosition);
            notifyItemChanged(selectedPosition);
        });
    }


    @Override
    public int getItemCount() {
        return metodoPagamentoList.size();
    }


    static class MetodoPagamentoViewHolder extends RecyclerView.ViewHolder {

        TextView metodoPagamentoNome;
        RadioButton metodoPagamentoRadio;


        public MetodoPagamentoViewHolder(@NonNull View itemView) {
            super(itemView);
            metodoPagamentoNome = itemView.findViewById(R.id.tv_pagamento_nome);
            metodoPagamentoRadio = itemView.findViewById(R.id.radioButtonCheckout);
        }

    }
}
