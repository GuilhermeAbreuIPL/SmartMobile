package com.example.smartmobile.adapters;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.smartmobile.R;
import com.example.smartmobile.models.MoradaModel;
import com.example.smartmobile.models.Product;

import org.w3c.dom.Text;

import java.util.ArrayList;
import java.util.List;

public class MoradaAdapter extends RecyclerView.Adapter<MoradaAdapter.MoradaViewHolder> {

    private final List<MoradaModel> moradaList;
    public MoradaAdapter(List<MoradaModel> moradaList) {
        this.moradaList = moradaList != null ? moradaList : new ArrayList<MoradaModel>();
        System.out.println("Morada Null" + moradaList);
        //this.moradaList = moradaList;
    }

    @NonNull
    @Override
    public MoradaViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {

            LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
            View inflate = layoutInflater.inflate(R.layout.item_morada_vh, null);

            return new MoradaViewHolder(inflate);
    }

    @Override
    public void onBindViewHolder(@NonNull MoradaViewHolder holder, int position) {
        MoradaModel morada = moradaList.get(position);
        holder.moradaRua.setText(morada.getRua());
        holder.moradaLocalidade.setText(morada.getLocalidade());
        holder.moradaCodPostal.setText(morada.getLocalidade());



    }

    @Override
    public int getItemCount() {
        return moradaList.size();
    }

    //Create the viewholder
    static class MoradaViewHolder extends RecyclerView.ViewHolder {
        TextView moradaRua;
        TextView moradaLocalidade;
        TextView moradaCodPostal;

        public MoradaViewHolder(@NonNull View itemView) {
            super(itemView);
            moradaRua = itemView.findViewById(R.id.tv_morada_rua);
            moradaLocalidade = itemView.findViewById(R.id.tv_morada_localidade);
            moradaCodPostal = itemView.findViewById(R.id.tv_morada_cod_postal);
        }
    }
}
