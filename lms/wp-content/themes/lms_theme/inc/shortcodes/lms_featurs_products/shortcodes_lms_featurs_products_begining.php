<?php
add_shortcode('lms_featured_product_begining', 'generate_shortcode_lms_featured_product_beginings');
add_action('vc_before_init', 'generate_vc_lms_featured_product_beginings');


function generate_shortcode_lms_featured_product_beginings($atts) {
     return '<section class="bg-light">
<section class="container py-5">' ;
}



function generate_vc_lms_featured_product_beginings() {
    vc_map(array(

        "name" => "بدايه قسم منتجات مميزه", // __( "Bar tag test", "my-text-domain" ),
        "base" => "lms_featured_product_begining",
        "class" => "",
        "category" => "اختصارات",
    )
);



}
?>