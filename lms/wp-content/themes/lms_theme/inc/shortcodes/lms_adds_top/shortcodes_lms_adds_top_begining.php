<?php
add_shortcode('lms_adds_top_begining', 'generate_shortcode_lms_adds_top_begining');
add_action('vc_before_init', 'generate_vc_lms_adds_top_begining');


function generate_shortcode_lms_adds_top_begining($atts) {
    

    return '
<!-- Start Banner Hero -->
<div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="1"></li>
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="container">
                <div class="row p-5">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="<?php echo IMG ?>/iconhashed.jpg" style=" border-radius :50%;" alt="">
                    </div>
                </div>
            </div>
        </div>
 ';
}



function generate_vc_lms_adds_top_begining() {
    vc_map(array(

        "name" => "بدايه الاعلانات التي بالواجهه المتحركه ",
        // __( "Bar tag test", "my-text-domain" ),
        "base" => "lms_adds_top_begining",
        "class" => "",
        "category" => "اعلانات",
        
    )




);



}
?>