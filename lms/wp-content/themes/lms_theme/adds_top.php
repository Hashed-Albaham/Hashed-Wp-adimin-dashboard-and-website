        <?php


</div>
<?php echo do_shortcode('[lms_adds_top adds_top_name="اسم الاعلان" adds_top_sup_name="عنوان الاعلان" adds_top_image="123"]'); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <?php the_content(); ?>

<?php endwhile; else : ?>
    <p>
        <?php esc_html_e('Sorry, no posts matched your criteria.'); ?>
    </p>
<?php endif; ?>


<?php/*if (have_posts()) : while (have_posts()) : the_post(); ?>

        <?php the_content(); ?>




        <?php endwhile; else : ?>
        <p>
            <?php esc_html_e('Sorry, no posts matched your criteria.'); ?>
        </p>
        <?php endif;*/ ?>
    