<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header>
   <?php 
    // Pobieramy 3 zmienne z panelu (z domyślnymi wartościami)
    $custom_logo_url = get_theme_mod( 'logo_link_url', 'https://indoornavi.me' );
    $custom_text_url = get_theme_mod( 'text_link_url', 'https://in-security.me/' );
    $custom_logo_text = get_theme_mod( 'logo_custom_text', get_bloginfo( 'name' ) );
?>

<div class="header-container">
    <div class="logo">
        <div class="logo-wrapper">
            <a href="<?php echo esc_url( $custom_logo_url ); ?>" target="_blank" rel="noopener noreferrer" class="logo-img-link">
                <?php 
                if ( has_custom_logo() ) {
                    $custom_logo_id = get_theme_mod( 'custom_logo' );
                    $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                    echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . esc_attr( $custom_logo_text ) . '" class="logo-img">';
                } else {
                    echo '<img src="' . get_template_directory_uri() . '/assets/images/logo.png" alt="Logo" class="logo-img">';
                }
                ?>
            </a>
            

            <a href="<?php echo esc_url( $custom_text_url ); ?>" class="logo-text-link">
                <span class="logo-text"><?php echo esc_html( $custom_logo_text ); ?></span>
            </a>
            
        </div>
    </div>

        <button class="mobile-menu-btn" aria-label="Otwórz menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav>
            <ul>
                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
                <li><a href="https://indoornavi.me/#branches" target="_blank" rel="noopener noreferrer">Other products</a></li>
                <li><a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer">Contact</a></li>
                <li><a href="https://indoornavi.me/blog/" target="_blank" rel="noopener noreferrer">Blog</a></li>
            </ul>
        </nav>
    </div>
</header>