package com.example.smartmobile.adapters;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.smartmobile.R;
import com.example.smartmobile.listeners.FaturaListener;
import com.example.smartmobile.models.Fatura;

import java.util.List;

public class FaturaAdapter extends RecyclerView.Adapter<FaturaAdapter.FaturaAdapterViewHoslder> {

        public final List<Fatura> faturasList;
        public FaturaListener listener;

        public FaturaAdapter(List<Fatura> faturasList) {
            this.faturasList = faturasList;
        }

        @NonNull
        @Override
        public FaturaAdapterViewHoslder onCreateViewHolder(@NonNull ViewGroup  parent, int viewType) {
            LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
            View inflate = layoutInflater.inflate(R.layout.item_order_history, null);

            return new FaturaAdapterViewHoslder(inflate);
        }

        @Override
        public void onBindViewHolder(@NonNull FaturaAdapterViewHoslder holder, int position) {
            Fatura faturas = faturasList.get(position);
            holder.FaturaData.setText(faturas.getData());
            holder.FaturaValorTotal.setText(faturas.getTotal());
            holder.FaturaStatus.setText(faturas.getEstado());
            holder.FaturaMetodoPagamento.setText(faturas.getMetodoPagamento());
            holder.FaturaShow.setTag(faturas.getId());
        }

        @Override
        public int getItemCount() {
            return faturasList.size();
        }

        static class FaturaAdapterViewHoslder extends RecyclerView.ViewHolder {

            TextView FaturaData;
            TextView FaturaValorTotal;
            TextView FaturaStatus;
            TextView FaturaMetodoPagamento;
            Button FaturaShow;

            public FaturaAdapterViewHoslder(@NonNull View view) {
                super(view);
                FaturaData = view.findViewById(R.id.tv_data);
                FaturaValorTotal = view.findViewById(R.id.tv_total);
                FaturaStatus = view.findViewById(R.id.tv_status);
                FaturaMetodoPagamento = view.findViewById(R.id.tv_payment);
                FaturaShow = view.findViewById(R.id.btn_show_fatura);
            }
        }
}
