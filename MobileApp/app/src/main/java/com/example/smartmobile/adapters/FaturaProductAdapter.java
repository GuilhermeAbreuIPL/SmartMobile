package com.example.smartmobile.adapters;

import android.text.Layout;
import android.text.SpannableString;
import android.text.SpannableStringBuilder;
import android.text.Spanned;
import android.text.style.StrikethroughSpan;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.smartmobile.R;
import com.example.smartmobile.listeners.GetCarrinhoListener;
import com.example.smartmobile.models.LinhaCarrinho;
import com.example.smartmobile.models.Product;

import java.util.List;
import java.util.Objects;

public class FaturaProductAdapter extends RecyclerView.Adapter<FaturaProductAdapter.FaturaProductViewHolder> {
    private final List<LinhaCarrinho> faturaProductList;
    private GetCarrinhoListener listener;

    public FaturaProductAdapter(List<LinhaCarrinho> faturaProductList){
        this.faturaProductList = faturaProductList;
    }

    @NonNull
    @Override
    public FaturaProductViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View inflate = layoutInflater.inflate(R.layout.item_product_data, null);

        return new FaturaProductViewHolder(inflate);
    }

    @Override
    public void onBindViewHolder(@NonNull FaturaProductViewHolder holder, int position) {
        LinhaCarrinho linhaCarrinho = faturaProductList.get(position);
        holder.FaturaProductName.setText(linhaCarrinho.getProdutoNome());
        holder.FaturaProductQuantity.setText(linhaCarrinho.getQuantidade());
        if(!Objects.equals(linhaCarrinho.getProdutoPrecoPromo(), null)){
            String originalPriceText = linhaCarrinho.getProdutoPreco() + "€";
            SpannableString spannableString = new SpannableString(originalPriceText);
            spannableString.setSpan(new StrikethroughSpan(), 0, originalPriceText.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);

            // Append the promotional price using SpannableStringBuilder
            String promoPriceText = " " + linhaCarrinho.getProdutoPrecoPromo() + "€";
            SpannableStringBuilder builder = new SpannableStringBuilder();
            builder.append(spannableString);
            builder.append(promoPriceText);
            holder.FaturaProductPrice.setText(builder);
        }else {
            holder.FaturaProductPrice.setText(linhaCarrinho.getProdutoPreco() + " €");
        }
    }

    @Override
    public int getItemCount() {
        return faturaProductList.size();
    }

    static class FaturaProductViewHolder extends RecyclerView.ViewHolder {

        TextView FaturaProductName;
        TextView FaturaProductPrice;
        TextView FaturaProductQuantity;

        public FaturaProductViewHolder(View view) {
            super(view);
            FaturaProductName = view.findViewById(R.id.tv_nome_produto);
            FaturaProductPrice = view.findViewById(R.id.tv_preco_produto);
            FaturaProductQuantity = view.findViewById(R.id.tv_quantidade_produto);
        }
    }
}
