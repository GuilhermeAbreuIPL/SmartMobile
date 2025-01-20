package com.example.smartmobile.adapters;

import android.text.SpannableString;
import android.text.SpannableStringBuilder;
import android.text.Spanned;
import android.text.style.StrikethroughSpan;
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
import com.example.smartmobile.R;
import com.example.smartmobile.listeners.ProdutosListener;
import com.example.smartmobile.models.Product;

import java.util.List;

public class ProductAdapter extends RecyclerView.Adapter<ProductAdapter.ProductViewHolder> {

    private final List<Product> productList;
    private ProdutosListener listener;

    private final String BASE_IMG_URL = "http://172.22.21.218/SmartMobile/SmartMobileWebApp/backend/web/uploads/";

    public ProductAdapter(List<Product> productList) {
        this.productList = productList;
    }



    @NonNull
    @Override
    public ProductViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {

        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View inflate = layoutInflater.inflate(R.layout.item_product, null);

        return new ProductViewHolder(inflate);
    }


    @Override
    public void onBindViewHolder(@NonNull ProductViewHolder holder, int position) {
        Product product = productList.get(position);
        holder.productName.setText(product.getNome());
        //holder.productPrice.setText(product.getPreco());
        if(product.getPrecoPromo() != "null"){
            String originalPriceText = "Preço: " + product.getPreco() + "€";
            SpannableString spannableString = new SpannableString(originalPriceText);
            spannableString.setSpan(new StrikethroughSpan(), 7, originalPriceText.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);

            // Append the promotional price using SpannableStringBuilder
            String promoPriceText = " " + product.getPrecoPromo() + "€";
            SpannableStringBuilder builder = new SpannableStringBuilder();
            builder.append(spannableString).append(promoPriceText);

            // Set the combined text in the TextView
            holder.productPrice.setText(builder);
        }else {
           holder.productPrice.setText("Preço: " + product.getPreco() + "€");
        }
        String imageUrl = product.getFilename();
        Glide.with(holder.itemView.getContext())
                .load(BASE_IMG_URL + imageUrl)
                .placeholder(null)
                .into(holder.productImage);
        holder.productCard.setTag(product.getId());
    }

    @Override
    public int getItemCount() {
        return productList.size();
    }

    static class ProductViewHolder extends RecyclerView.ViewHolder {
        TextView productName;
        TextView productPrice;
        ImageView productImage;
        LinearLayout productCard;



        public ProductViewHolder(@NonNull View itemView) {
            super(itemView);
            productName = itemView.findViewById(R.id.product_name);
            productPrice = itemView.findViewById(R.id.product_price);
            productImage = itemView.findViewById(R.id.product_image);
            productCard = itemView.findViewById(R.id.product_card);

        }
    }
}
