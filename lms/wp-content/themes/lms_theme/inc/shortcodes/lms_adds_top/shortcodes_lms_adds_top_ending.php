<?php
add_shortcode('lms_adds_top_ending', 'generate_shortcode_lms_adds_top_ending');
add_action('vc_before_init', 'generate_vc_lms_adds_top_ending');


function generate_shortcode_lms_adds_top_ending($atts) {
    

    return '
        <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="prev">
            <i class="fas fa-chevron-left"></i>
        </a>
        <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="next">
            <i class="fas fa-chevron-right"></i>
        </a>
    </div>
</div>
 

 ';
}



function generate_vc_lms_adds_top_ending() {
    vc_map(array(

        "name" => "نهايه الاعلانات التي بالواجهه المتحركه ",
        // __( "Bar tag test", "my-text-domain" ),
        "base" => "lms_adds_top_ending",
        "class" => "",
        "category" => "اعلانات",
        
    )




);



}
?>