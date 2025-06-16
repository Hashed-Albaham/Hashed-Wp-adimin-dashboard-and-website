<?php
add_shortcode('lms_featured_product', 'generate_shortcode_lms_featured_products');
add_action('vc_before_init', 'generate_vc_lms_featured_products');


function generate_shortcode_lms_featured_products($atts, $product_content) {
    extract(shortcode_atts(array(
        'product_name' => '',
        'product_price' => '',
        'product_image' => '',
        'product_link' => '',
        'product_stars' => '',
        'product_stars_color' => '',
    ), $atts));

    $product_image_src = wp_get_attachment_image_src($product_image);
    $product_link = vc_build_link($product_link);
    //printr($product_link);

    $stars_to_show = '';
    for ($i = 1; $i <= $product_stars; $i++) {


        $stars_to_show .= '<i class="fa fa-star" style="color:'.$product_stars_color.'"></i>';
    }


    return '<br><div class="card h-100">
                <a href="'.$product_link['url'].'" target = "'.$product_link['target'].'" rel="'.$product_link['rel'].'">
                        <img src="'.$product_image_src[0].'" class="card-img-top" alt="..."> </a>
                        <div class="card-body">
                            <ul class="list-unstyled d-flex justify-content-between">
                             <li>'.$stars_to_show.'</li>
                                <li class="text-muted text-right">$'.$product_price.'</li>
                            </ul>
                                <a href="'.$product_link['url'].'" target = "'.$product_link['target'].'" rel="'.$product_link['rel'].'" class="h2 text-decoration-none text-dark">'.$product_name.'</a>
                            <p class="card-text">
                                '.$product_content.'
                            </p>
                        </div>
                    </div><br>
    ';
}



function generate_vc_lms_featured_products() {
    vc_map(array(

        "name" => "منتج مميز", // __( "Bar tag test", "my-text-domain" ),
        "base" => "lms_featured_product",
        "class" => "",
        "category" => "اختصارات",

        "params" => array(
            array(
                "type" => "attach_image",
                "holder" => "div",
                "class" => "",
                "heading" => "صوره المنتج ",
                "param_name" => "product_image",
                "value" => "",

                "description" => "ادخل صوره المنتج ",
            ),
            array(

                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "تقييم المنتج",
                "param_name" => "product_stars",
                "value" => array(
                    "No stars" => '',
                    "One star" => 1,
                    "Tow stars" => 2,
                    "Three stars" => 3,
                    "Four stars" => 4,
                    "Five stars" => 5,
                ),

                "description" => "لون نجوم تقييم المنتج",
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "لون تقييم المنتج",
                "param_name" => "product_stars_color",
                "value" => "#ede861",
                "dependency" => array(

                    "element" => "product_stars",
                    "not_empty" => true,
                ),
            ),

            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "اسم المنتج",
                "param_name" => "product_name",
                "value" => "",

                "description" => "اكتب اسم المنتج ",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "سعر المنتج",
                "param_name" => "product_price",
                "value" => "",

                "description" => "ادخل سعر المنتج",
            ),

            array(
                "type" => "textarea_html",
                "holder" => "div",
                "class" => "",
                "heading" => "وصف المنتج",
                "param_name" => "product_content",
                "value" => "",
                "description" => "اكتب وصف المنتج "
            ),
            array(
                "type" => "vc_link",
                "holder" => "div",
                "class" => "",
                "heading" => "رابط المنتج ",
                "param_name" => "product_link",
                "value" => "",
                "description" => "ادخل رابط المنتج "
            ),
        )
    ));



}
?>