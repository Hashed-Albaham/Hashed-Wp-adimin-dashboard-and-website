<!-- Start Footer -->
    <footer class="bg-dark" id="tempaltemo_footer">
        <div class="container">
            <div class="row">

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-success border-bottom pb-3 border-light logo"><?php bloginfo('name'); ?> </h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li>
                            <i class="fas fa-map-marker-alt fa-fw"></i>
                            Yemen </li>
                        <li>
                            <i class="fa fa-phone fa-fw"></i>
                            <a class="text-decoration-none" href="tel:+967773180974">+96773180974</a>
                        </li>
                        <li>
                            <i class="fa fa-envelope fa-fw"></i>
                            <a class="text-decoration-none" href="mailto:hashedhassanzaeed222@gmail.com">hashed@company.com</a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-light border-bottom pb-3 border-light"><?php esc_html_e('Products', 'lms_theme'); ?></h2>
                    <?php
                    if (has_nav_menu('footer_products_menu')) {
                        wp_nav_menu(array(
                            'theme_location' => 'footer_products_menu',
                            'container'      => false,
                            'menu_class'     => 'list-unstyled text-light footer-link-list',
                            'fallback_cb'    => false,
                            'depth'          => 1,
                        ));
                    }
                    ?>
                </div>

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-light border-bottom pb-3 border-light"><?php esc_html_e('Further Info', 'lms_theme'); ?></h2>
                    <?php
                    if (has_nav_menu('footer_info_menu')) {
                        wp_nav_menu(array(
                            'theme_location' => 'footer_info_menu',
                            'container'      => false,
                            'menu_class'     => 'list-unstyled text-light footer-link-list',
                            'fallback_cb'    => false,
                            'depth'          => 1,
                        ));
                    }
                    ?>
                </div>

            </div>

            <div class="row text-light mb-4">
                <div class="col-12 mb-3">
                    <div class="w-100 my-3 border-top border-light"></div>
                </div>
                <div class="col-auto me-auto">
                    <ul class="list-inline text-left footer-icons">
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank" href="http://facebook.com/hashed_00"><i class="fab fa-facebook-f fa-lg fa-fw"></i></a>
                        </li>
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank" href="https://www.instagram.com/hashed_000"><i class="fab fa-instagram fa-lg fa-fw"></i></a>
                        </li>
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank" href="https://twitter.com/hashed_00"><i class="fab fa-twitter fa-lg fa-fw"></i></a>
                        </li>
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank" href="https://www.linkedin.com/"><i class="fab fa-linkedin fa-lg fa-fw"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="col-auto">
                    <label class="sr-only" for="subscribeEmail">Email address</label>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control bg-dark border-light" id="subscribeEmail" placeholder="Email address">
                        <div class="input-group-text btn-success text-light">
                            Subscribe
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-100 bg-black py-3">
            <div class="container">
                <div class="row pt-2">
                    <div class="col-12">
                        <p class="text-left text-light">
                            Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>
                            | Designed by <a rel="sponsored" href="" target="_blank">Eng: Hashed Albaham</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </footer>
    <!-- End Footer -->
<?php wp_footer(); ?>
    <!-- Start Script -->
</body>

</html>
