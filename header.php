<?php $in_security_lang = in_security_get_language(); ?>
<!DOCTYPE html>
<html lang="<?php echo esc_attr( $in_security_lang ); ?>">
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

    $in_security_lang_url = remove_query_arg( 'site_lang' );
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
                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( in_security_t( 'nav_home' ) ); ?></a></li>
                <li class="nav-dropdown">
                    <a href="<?php echo esc_url( home_url( '/in-guard/' ) ); ?>"><?php echo esc_html( in_security_t( 'nav_product_card' ) ); ?></a>
                    <ul class="nav-dropdown-menu">
                        <li><a href="<?php echo esc_url( home_url( '/in-guard/' ) ); ?>"><?php echo esc_html( in_security_t( 'nav_in_guard' ) ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/in-sense/' ) ); ?>"><?php echo esc_html( in_security_t( 'nav_in_sense' ) ); ?></a></li>
                    </ul>
                </li>
                <li><a href="https://indoornavi.me/#branches" target="_blank" rel="noopener noreferrer"><?php echo esc_html( in_security_t( 'nav_other_products' ) ); ?></a></li>
                <li><a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer"><?php echo esc_html( in_security_t( 'nav_contact' ) ); ?></a></li>
                <li><a href="https://indoornavi.me/blog/" target="_blank" rel="noopener noreferrer"><?php echo esc_html( in_security_t( 'nav_blog' ) ); ?></a></li>
                <li class="lang-switch">
                    <a href="<?php echo esc_url( add_query_arg( 'site_lang', 'en', $in_security_lang_url ) ); ?>" class="lang-switch-link<?php echo 'en' === $in_security_lang ? ' is-active' : ''; ?>">EN</a>
                    <span class="lang-switch-separator">/</span>
                    <a href="<?php echo esc_url( add_query_arg( 'site_lang', 'pl', $in_security_lang_url ) ); ?>" class="lang-switch-link<?php echo 'pl' === $in_security_lang ? ' is-active' : ''; ?>">PL</a>
                </li>
            </ul>
        </nav>
    </div>
</header>