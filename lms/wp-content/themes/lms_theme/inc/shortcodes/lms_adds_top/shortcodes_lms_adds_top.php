<?php
add_shortcode('lms_adds_top', 'generate_shortcode_lms_adds_top');
add_action('vc_before_init', 'generate_vc_lms_adds_top');


function generate_shortcode_lms_adds_top ($atts, $addscontent) {
    extract(shortcode_atts(array(
        'adds_top_name' => '',
        'adds_top_sup_name' => '',
        'adds_top_image' => '',
    ), $atts));

    $adds_top_image_src = wp_get_attachment_image_src($adds_top_image);





    return '
  <div class="carousel-item">
            <div class="container">
                <div class="row p-5">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                    <img class="img-fluid rounded-circle" src="'.$adds_top_image_src[0].'" alt="">
                  
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left">
                            <h1 class="h1 text-success">'.$adds_top_name.'</h1>
                            <h3 class="h2">'.$adds_top_sup_name.'</h3>
                            <p> '.$addscontent.'</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 ';
}



function generate_vc_lms_adds_top() {
    vc_map(array(

        "name" => "الاعلانات الرئيسية",
        // __( "Bar tag test", "my-text-domain" ),
        "base" => "lms_adds_top",
        "class" => "",
        "category" => "اعلانات",
        "params" => array(
            array(
                "type" => "attach_image",
                "holder" => "div",
                "class" => "",
                "heading" => "صوره ",
                "param_name" => "adds_top_image",
                "value" => "",

                "description" => "ادخل صوره  ",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "اسم ",
                "param_name" => "adds_top_name",
                "value" => "",

                "description" => "اكتب اسم  ",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "عنوان2",
                "param_name" => "adds_top_sup_name",
                "value" => "",

                "description" => "ادخل العنوان2",
            ),

            array(
                "type" => "textarea_html",
                "holder" => "div",
                "class" => "",
                "heading" => "وصف ",
                "param_name" => "addscontent",
                "value" => "",
                "description" => "اكتب وصف  "
            ),
        )
    ));



}
?>