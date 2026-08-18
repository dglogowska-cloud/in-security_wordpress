<?php
// Funkcja ładująca główne style motywu
function indoornavi_enqueue_styles() {
    wp_enqueue_style( 'indoornavi-main-style', get_stylesheet_uri(), array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'indoornavi_enqueue_styles' );

function indoornavi_enqueue_legal_styles() {
    if ( is_page_template( array( 'page-privacy-policy.php', 'page-cookie-policy.php' ) ) ) {
        wp_enqueue_style(
            'in-legal-page',
            get_template_directory_uri() . '/assets/css/legal-page.css',
            array( 'indoornavi-main-style' ),
            '1.0'
        );
    }
}
add_action( 'wp_enqueue_scripts', 'indoornavi_enqueue_legal_styles' );

function indoornavi_theme_support() {
    // 1. Odblokowuje opcję dodawania własnego logo w panelu "Dostosuj"
    add_theme_support( 'custom-logo' );

    // 2. Automatycznie zarządza tagiem <title> (dobra praktyka SEO)
    add_theme_support( 'title-tag' );

    // 3. Rejestruje miejsce na Twoje menu nawigacyjne
    register_nav_menus( array(
        'primary_menu' => __( 'Menu Główne (Header)', 'indoornavi' ),
    ) );
}
add_action( 'after_setup_theme', 'indoornavi_theme_support' );

function indoornavi_customize_register( $wp_customize ) {
    // 1. Dodajemy sekcję "Ustawienia Nagłówka"
    $wp_customize->add_section( 'indoornavi_header_settings' , array(
        'title'      => 'Ustawienia Nagłówka',
        'priority'   => 30,
    ) );

    // 2. Pole dla Linku w Obrazku Logo
    $wp_customize->add_setting( 'logo_link_url', array(
        'default'   => 'https://indoornavi.me',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( 'logo_link_url_control', array(
        'label'    => 'Link dla obrazka logo',
        'section'  => 'indoornavi_header_settings',
        'settings' => 'logo_link_url',
        'type'     => 'url',
    ) );

    // 3. Pole dla Tekstu obok Logo
    $wp_customize->add_setting( 'logo_custom_text', array(
        'default'   => 'IndoorNavi',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( 'logo_custom_text_control', array(
        'label'    => 'Tekst obok logo',
        'section'  => 'indoornavi_header_settings',
        'settings' => 'logo_custom_text',
        'type'     => 'text',
    ) );

    // 4. Pole dla Linku w Tekście
    $wp_customize->add_setting( 'text_link_url', array(
        'default'   => 'https://in-security.me',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( 'text_link_url_control', array(
        'label'    => 'Link dla tekstu obok logo',
        'section'  => 'indoornavi_header_settings',
        'settings' => 'text_link_url',
        'type'     => 'url',
    ) );
}
add_action( 'customize_register', 'indoornavi_customize_register' );

// ── ACCENT HEADING helper — **tekst** → <span class="heading-accent">tekst</span> ──
function ins_accent( $escaped_text ) {
    return preg_replace( '/\*\*(.*?)\*\*/s', '<span class="heading-accent">$1</span>', $escaped_text );
}

// Specyfikacja urządzenia IN Guard 01 — współdzielona między front-page.php
// (sekcja "The Hardware") a page-in-guard.php (karta produktu), żeby nie
// trzymać tej samej treści w dwóch miejscach.
function in_guard_specs() {
    return [
        [
            'number'  => '01',
            'title'   => 'Long-Range, Encrypted & Fully On-Premise',
            'content' => 'IN Guard 01 talks to its base station over the <strong>868 MHz ISM band using LoRaWAN, secured end to end with AES-128 encryption</strong> — only devices explicitly registered to your system can ever transmit. The base station connects only to your own control PC (Wi-Fi, LTE, or wired Ethernet), so <strong>patrol data never has to leave your network</strong>.',
        ],
        [
            'number'  => '02',
            'title'   => 'Precise, Continuous Positioning',
            'content' => 'A built-in multi-constellation GNSS receiver (GPS, GLONASS, Galileo, BeiDou) logs the tracker\'s exact position <strong>every 15 seconds</strong>, storing up to <strong>500 points on-device</strong> and uploading them the moment it\'s back in range of the base station.',
        ],
        [
            'number'  => '03',
            'title'   => 'Built for a Full Shift',
            'content' => 'An onboard battery keeps IN Guard 01 running for <strong>several hours of continuous patrol work</strong>. Recharge it with a standard USB-C cable, or use the <strong>dedicated docking station that charges three units at once</strong>.',
        ],
        [
            'number'  => '04',
            'title'   => 'Two Layers of Guard Safety',
            'content' => 'A <strong>one-touch panic button</strong> sends an immediate priority alert to the control room. A built-in motion sensor also watches for falls — if the device stays motionless and horizontal past a set time, <strong>the control room is alerted automatically</strong>.',
        ],
    ];
}
