<!-- Modal -->


<?php get_header(); ?>

<div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="w-100 pt-1 mb-5 text-right">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="get" class="modal-content modal-body border-0 p-0">
            <div class="input-group mb-2">
                <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                <button type="submit" class="input-group-text bg-success text-light">
                    <i class="fa fa-fw fa-search text-white"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<?php
if (is_front_page() && !is_home() ) { // Check if it's the static front page
    // Attempt to display content from shortcodes if this is the front page.
    // User will need to configure these shortcodes on a specific page set as Front Page,
    // or these could be replaced by theme options or custom fields in a more advanced setup.
    // For now, this provides a basic structure.
    
    // Placeholder for Hero Carousel (lms_adds_top)
    // To make this dynamic, the user would typically use a page builder like WP Bakery on their chosen front page
    // or the theme would offer customizer options.
    // The shortcode 'lms_adds_top_begining' and 'lms_adds_top_ending' are assumed to exist from previous file listings.
    // The actual content for 'lms_adds_top' would be added by the user.
    // Example: echo do_shortcode('[lms_adds_top_begining]');
    // Example: echo do_shortcode('[lms_adds_top adds_top_name="Welcome" adds_top_sup_name="To our store" adds_top_image="IMAGE_ID_HERE"]Discover our products.[/lms_adds_top]');
    // Example: echo do_shortcode('[lms_adds_top_ending]');
    // Fallback to content if no specific shortcode structure is defined or if user adds content via editor
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            the_content(); // This will display content added via WP Bakery or the classic editor to the page set as Front Page
        }
    }

} elseif ( is_home() && !is_front_page() ) { // Blog posts index page
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            // Display post excerpts or full posts for the blog listing
            the_title('<h2><a href="' . esc_url(get_permalink()) . '">', '</a></h2>');
            the_excerpt(); // Or the_content() for full posts
        }
        // Add pagination if needed
        the_posts_pagination();
    } else {
        echo '<p>' . esc_html__('Sorry, no posts matched your criteria.', 'lms_theme') . '</p>';
    }
} else { // For all other pages, posts, archives, etc.
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            the_content();
        }
    } else {
        echo '<p>' . esc_html__('Sorry, no content found.', 'lms_theme') . '</p>';
    }
}
?>

    <?php get_footer(); ?>
    <!-- Start Script -->