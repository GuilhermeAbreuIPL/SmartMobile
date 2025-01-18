package com.example.smartmobile;

import android.os.Bundle;
import android.text.SpannableString;
import android.text.SpannableStringBuilder;
import android.text.Spanned;
import android.text.style.StrikethroughSpan;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.fragment.app.Fragment;
import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import com.bumptech.glide.Glide;
import com.example.smartmobile.listeners.ProdutosListener;
import com.example.smartmobile.models.Product;
import com.example.smartmobile.network.SingletonVolley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import org.w3c.dom.Text;

public class ProductDetailsFragment extends Fragment {

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        //Faz o system out dos argumentos
        System.out.println(getArguments());
        return inflater.inflate(R.layout.fragment_product_details, container, false);
    }

    @Override
    public void onResume() {
        super.onResume();
        //sabendo que o system out dos argumentos devolve isso Bundle[{product_id=7}] saca o id do produto
        int productId = Integer.parseInt(getArguments().getString("product_id"));
        //chama o metodo do singleton volley para carregar o produtoDetails
        SingletonVolley.getInstance(getContext()).getProdutoDetails(getContext(), productId, new ProdutosListener() {
            @Override
            public void onProdutosResponse(JSONObject produtos) throws JSONException {

                JSONObject produto = produtos.getJSONObject("produto");

                Product product = new Product();
                product.setId(produto.getInt("id"));
                product.setNome(produto.getString("nome"));
                product.setCategoria(produto.getString("categoria"));
                product.setCategoria_id(produto.getInt("categoria_id"));
                product.setFilename(produto.getString("filename"));
                product.setPreco(produto.getString("preco"));
                product.setPrecoPromo(produto.getString("precoPromo"));
                product.setDescricao(produto.getString("descricao"));
                product.setPrecoPromo(produto.getString("precoPromo"));

                //System out do produto
                System.out.println("ProdutoDetalhes: "+product.getNome());

                TextView productName = getView().findViewById(R.id.product_name_details);
                productName.setText(product.getNome());

                TextView productPrice = getView().findViewById(R.id.product_price_details);

                if(product.getPrecoPromo() != "null"){
                    String originalPriceText = "Preço: " + product.getPreco() + "€";
                    SpannableString spannableString = new SpannableString(originalPriceText);
                    spannableString.setSpan(new StrikethroughSpan(), 7, originalPriceText.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);

                    // Append the promotional price using SpannableStringBuilder
                    String promoPriceText = " " + product.getPrecoPromo() + "€";
                    SpannableStringBuilder builder = new SpannableStringBuilder();
                    builder.append(spannableString).append(promoPriceText);

                    // Set the combined text in the TextView
                    productPrice.setText(builder);
                }else {
                    productPrice.setText("Preço: " + product.getPreco() + "€");
                }


                TextView productDescription = getView().findViewById(R.id.product_description_details);
                productDescription.setText(product.getDescricao());

                String BASE_IMG_URL = "http://172.22.21.218/SmartMobile/SmartMobileWebApp/backend/web/uploads/";
                String imageUrl = product.getFilename();
                ImageView productImageView = getView().findViewById(R.id.product_image);

                //Glide para carregar a imagem
                Glide.with(getContext())
                        .load(BASE_IMG_URL + imageUrl)
                        .placeholder(null)
                        .into(productImageView);

                Button addToCartButton = getView().findViewById(R.id.add_to_cart);
                addToCartButton.setTag(product.getId());
            }
            //Set da tag do botão adicionar ao carrinho




        });



    }
}