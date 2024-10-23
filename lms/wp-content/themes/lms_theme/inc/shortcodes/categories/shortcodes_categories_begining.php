<?php
add_shortcode('lms_featured_categories_begining', 'generate_shortcode_lms_featured_categories_beginings');
add_action('vc_before_init', 'generate_vc_lms_featured_categories_beginings');


function generate_shortcode_lms_featured_categories_beginings($atts, $content2) {
    extract(shortcode_atts(array(
        'categories_begining_name' => '',

    ), $atts));




    return '
    <section class="container py-5">
        <div class="row text-center pt-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">'.$categories_begining_name.'</h1>
                <p>
                  '.$content2.'
                </p>
            </div>
        </div>
        <div >
   ';
}



function generate_vc_lms_featured_categories_beginings() {
    vc_map(array(

        "name" => "عنوان وبدايه قسم صوره دائريه ورابط ",
        //("Bar tag test", "my-text-domain" ),
        "base" => "lms_featured_categories_begining",
        "class" => "",
        "category" => "صوره دائريه ورابط",
        "params" => array(

            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "اسم العنوان لقسم صور دائريه ورابط",
                "param_name" => "categories_begining_name",
                "value" => "",

                "description" => "اكتب اسم العنوان   قسم صور دائريه ورابط ",
            ),
            array(
                "type" => "textarea_html",
                "holder" => "div",
                "class" => "",
                "heading" => "وصف القسم",
                "param_name" => "content2",
                "value" => "",
                "description" => "اكتب وصف القسم "
            ),

        )
    ));



}
?>