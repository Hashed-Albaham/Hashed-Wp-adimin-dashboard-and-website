<?php
add_shortcode('lms_featured_categories', 'generate_shortcode_lms_featured_categoriess');
add_action('vc_before_init', 'generate_vc_lms_featured_categoriess');


function generate_shortcode_lms_featured_categoriess($atts) {
    extract(shortcode_atts(array(
        'categories_name' => '',
        'categories_image' => '',
        'categories_link' => '',
    ), $atts));

    $categories_image_src = wp_get_attachment_image_src($categories_image);
    $categories_link = vc_build_link($categories_link);
    //printr($categories_link);



    return '<div class="col-12 col-md-4 p-5 mt-1 text-center">
                      <a href="'.$categories_link['url'].'" target = "'.$categories_link['target'].'" rel="'.$categories_link['rel'].'">
                        <img src="'.$categories_image_src[0].'" class="rounded-circle img-fluid border" alt="..."></a>
                <h5 class="text-center mt-1 mb-1">'.$categories_name.'</h5>
                <p class="text-center">
                    <a class="btn btn-success">Go Shop</a>
                </p>
            </div>
    ';
}



function generate_vc_lms_featured_categoriess() {
    vc_map(array(

        "name" => "صوره دائريه ورابط مميز", // __( "Bar tag test", "my-text-domain" ),
        "base" => "lms_featured_categories",
        "class" => "",
        "category" => "صوره دائريه ورابط",

        "params" => array(
            array(
                "type" => "attach_image",
                "holder" => "div",
                "class" => "",
                "heading" => "صوره الصوره دائريه ورابط ",
                "param_name" => "categories_image",
                "value" => "",

                "description" => "ادخل صوره الصوره دائريه ورابط ",
            ),

            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "اسم الصوره دائريه ورابط",
                "param_name" => "categories_name",
                "value" => "",

                "description" => "اكتب اسم الصوره دائريه ورابط ",
            ),
            array(
                "type" => "vc_link",
                "holder" => "div",
                "class" => "",
                "heading" => "رابط الصوره دائريه ورابط ",
                "param_name" => "categories_link",
                "value" => "",
                "description" => "ادخل رابط الصوره دائريه ورابط "
            ),
        )
    ));



}
?>