<?php
/*
 * Template Name: Cookie Policy
 */
get_header();
?>

<main class="legal-page">

    <section class="legal-hero">
        <div class="safety-container">
            <p class="legal-hero-label">Legal</p>
            <h1><?php the_title(); ?></h1>
        </div>
    </section>

    <section class="legal-content">
        <div class="safety-container legal-body">
            <?php
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
            ?>
        </div>
    </section>

</main>

<?php get_footer( 'subpage' ); ?>
