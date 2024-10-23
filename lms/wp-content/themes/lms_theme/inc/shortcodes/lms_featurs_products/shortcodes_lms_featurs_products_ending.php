<?php
add_shortcode('lms_featured_product_ending', 'generate_shortcode_lms_featured_product_endings');
add_action('vc_before_init', 'generate_vc_lms_featured_product_endings');


function generate_shortcode_lms_featured_product_endings($atts) {
    return '</section>
</section>' ;
}



function generate_vc_lms_featured_product_endings() {
    vc_map(array(

        "name" => "نهايه قسم منتجات مميزه", // __( "Bar tag test", "my-text-domain" ),
        "base" => "lms_featured_product_ending",
        "class" => "",
        "category" => "اختصارات",
    ));



}
?>