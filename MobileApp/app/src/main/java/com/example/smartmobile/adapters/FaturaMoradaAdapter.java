package com.example.smartmobile.adapters;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.RadioButton;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.smartmobile.R;
import com.example.smartmobile.listeners.MoradaListener;
import com.example.smartmobile.models.MoradaModel;

import java.util.List;

public class FaturaMoradaAdapter extends RecyclerView.Adapter<FaturaMoradaAdapter.FaturaMoradaViewHolder> {
    private final List<MoradaModel> faturaMoradaList;
    private MoradaListener listener;
    private int selectedPosition = -1;

    public FaturaMoradaAdapter(List<MoradaModel> faturaMoradaList){
        this.faturaMoradaList = faturaMoradaList;
    }

    @NonNull
    @Override
    public FaturaMoradaAdapter.FaturaMoradaViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View inflate = layoutInflater.inflate(R.layout.item_morada_checkout, null);

        return new FaturaMoradaViewHolder(inflate);
    }

    @Override
    public void onBindViewHolder(@NonNull FaturaMoradaAdapter.FaturaMoradaViewHolder holder, int position) {
        MoradaModel moradaModel = faturaMoradaList.get(position);
        holder.moradaRua.setText(moradaModel.getRua());
        holder.moradaLocalidade.setText(moradaModel.getLocalidade());
        holder.moradaCodPostal.setText(moradaModel.getCodPostal());
        holder.moradaRadio.setTag(moradaModel.getId());

        holder.moradaRadio.setChecked(position == selectedPosition);

        holder.moradaRadio.setOnClickListener(v -> {
            int previousSelectedPosition = selectedPosition;
            selectedPosition = holder.getAdapterPosition();

            //printa a tag do radio button
            System.out.println(holder.moradaRadio.getTag());

            notifyItemChanged(previousSelectedPosition);
            notifyItemChanged(selectedPosition);
        });
    }

    @Override
    public int getItemCount() {
        return faturaMoradaList.size();
    }

    static class FaturaMoradaViewHolder extends RecyclerView.ViewHolder {

        TextView moradaRua;
        TextView moradaLocalidade;
        TextView moradaCodPostal;
        RadioButton moradaRadio;

        public FaturaMoradaViewHolder(@NonNull View itemView) {
            super(itemView);
            moradaRua = itemView.findViewById(R.id.tv_morada_rua_checkout);
            moradaLocalidade = itemView.findViewById(R.id.tv_morada_localidade_checkout);
            moradaCodPostal = itemView.findViewById(R.id.tv_morada_cod_postal_checkout);
            moradaRadio = itemView.findViewById(R.id.radioButton_morada_checkout);
        }
    }
}
