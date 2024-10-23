<?php
add_shortcode('lms_featured_categories_ending', 'generate_shortcode_lms_featured_categories_endings');
add_action('vc_before_init', 'generate_vc_lms_featured_categories_endings');


function generate_shortcode_lms_featured_categories_endings($atts) {

    return '
</div>
</section>
   ';
}

function generate_vc_lms_featured_categories_endings() {
    vc_map(array(

        "name" => "نهايه قسم صوره دائريه ورابط ",
        //("Bar tag test", "my-text-domain" ),
        "base" => "lms_featured_categories_ending",
        "class" => "",
        "category" => "صوره دائريه ورابط",
    ));



}
?>