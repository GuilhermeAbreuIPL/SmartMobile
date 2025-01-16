package com.example.smartmobile.adapters;

import android.text.SpannableString;
import android.text.SpannableStringBuilder;
import android.text.Spanned;
import android.text.style.StrikethroughSpan;
import android.util.Pair;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.example.smartmobile.HomeFragment;
import com.example.smartmobile.MainActivity;
import com.example.smartmobile.R;
import com.example.smartmobile.ShoppingCartFragment;
import com.example.smartmobile.listeners.GetCarrinhoListener;

import com.example.smartmobile.listeners.UpdateCarrinhoListener;
import com.example.smartmobile.models.LinhaCarrinho;
import com.example.smartmobile.network.SingletonVolley;


import org.json.JSONObject;
import org.w3c.dom.Text;

import java.util.List;
import java.util.Objects;

public class CartAdapter extends RecyclerView.Adapter<CartAdapter.LinhaCarrinhoViewHolder> {

    private final List<LinhaCarrinho> linhaCarrinhoList;
    private GetCarrinhoListener listener;

    private final String BASE_IMG_URL = "http://172.22.21.218/SmartMobile/SmartMobileWebApp/backend/web/uploads/";

    public CartAdapter(List<LinhaCarrinho> linhaCarrinhoList) {
        this.linhaCarrinhoList = linhaCarrinhoList;
    }



    @NonNull
    @Override
    public LinhaCarrinhoViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {

        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View inflate = layoutInflater.inflate(R.layout.item_product_cart, null);

        return new LinhaCarrinhoViewHolder(inflate);
    }


    @Override
    public void onBindViewHolder(@NonNull LinhaCarrinhoViewHolder holder, int position) {
        LinhaCarrinho linhaCarrinho = linhaCarrinhoList.get(position);
        holder.productName.setText(linhaCarrinho.getProdutoNome());
        //holder.productPrice.setText(linhaCarrinho.getProdutoPreco() + " €");
        holder.productQuantity.setText(linhaCarrinho.getQuantidade());
        if(!Objects.equals(linhaCarrinho.getProdutoPrecoPromo(), null)){
            String originalPriceText = "Preço: " + linhaCarrinho.getProdutoPreco() + "€";
            SpannableString spannableString = new SpannableString(originalPriceText);
            spannableString.setSpan(new StrikethroughSpan(), 7, originalPriceText.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);

            // Append the promotional price using SpannableStringBuilder
            String promoPriceText = " " + linhaCarrinho.getProdutoPrecoPromo() + "€";
            SpannableStringBuilder builder = new SpannableStringBuilder();
            builder.append(spannableString);
            builder.append(promoPriceText);
            holder.productPrice.setText(builder);
        }else {
            holder.productPrice.setText(linhaCarrinho.getProdutoPreco() + " €");
        }

        String imageUrl = linhaCarrinho.getProdutoFilename();
        Glide.with(holder.productImage.getContext())
                .load(BASE_IMG_URL + imageUrl)
                .placeholder(null)
                .into(holder.productImage);

        holder.addQty.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                int qty = Integer.parseInt(holder.productQuantity.getText().toString());

                qty++;

                SingletonVolley.getInstance(holder.itemView.getContext()).updateCarrinhoProduto(holder.itemView.getContext(), linhaCarrinho.getId(), qty, new UpdateCarrinhoListener() {
                    @Override
                    public void onUpdateCarrinhoResponse(JSONObject response) {
                        System.out.println("Atualizei o carrinho");
                        ((MainActivity) holder.itemView.getContext()).refreshCarrinho();
                    }
                });
            }
        });

        holder.removeQty.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                int qty = Integer.parseInt(holder.productQuantity.getText().toString());

                qty--;
                SingletonVolley.getInstance(holder.itemView.getContext()).updateCarrinhoProduto(holder.itemView.getContext(), linhaCarrinho.getId(), qty, new UpdateCarrinhoListener() {
                    @Override
                    public void onUpdateCarrinhoResponse(JSONObject response) {
                        System.out.println("Atualizei o carrinho");
                        ((MainActivity) holder.itemView.getContext()).refreshCarrinho();
                    }
                });
            }
        });

    }

    @Override
    public int getItemCount() {
        return linhaCarrinhoList.size();
    }

    static class LinhaCarrinhoViewHolder extends RecyclerView.ViewHolder {
        ImageView productImage;
        TextView productName;
        TextView productPrice;
        TextView productQuantity;
        Button addQty;
        Button removeQty;


        public LinhaCarrinhoViewHolder(@NonNull View itemView) {
            super(itemView);
            productName = itemView.findViewById(R.id.tv_product_name_cart);
            productImage = itemView.findViewById(R.id.iv_product_image_cart);
            productPrice = itemView.findViewById(R.id.tv_product_price_cart);
            productQuantity = itemView.findViewById(R.id.tv_quantidade_cart);
            addQty = itemView.findViewById(R.id.btn_add_quantidade_cart);
            removeQty = itemView.findViewById(R.id.btn_remove_product_cart);

        }
    }

    public double calcularTotal() {
        double total = 0.0;
        for (LinhaCarrinho linha : linhaCarrinhoList) {
            int quantidade = Integer.parseInt(linha.getQuantidade()); // Parse para int
            double preco = Double.parseDouble(linha.getProdutoPreco()); // Parse para double
            total += quantidade * preco;
        }
        return total;
    }

}
