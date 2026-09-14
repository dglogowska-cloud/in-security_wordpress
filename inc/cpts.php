<?php
// Custom Post Types dla list, które mają być edytowalne z wp-admina bez
// Repeatera (ten jest tylko w ACF Pro, którego nie mamy) — ten sam wzorzec
// co CPT "branch" na indoornavi.me: dodawanie/usuwanie pozycji to zwykłe
// "Dodaj nowy wpis"/"Usuń", kolejność steruje polem "Kolejność" (menu_order,
// dzięki 'page-attributes'). Treść samych pól (PL/EN) żyje w ACF — patrz
// inc/acf-fields.php.
//
// Pojedyncze teksty strony głównej (nagłówki, akapity) CELOWO zostają w
// inc/i18n.php — bez ACF Pro nie mamy Options Page, więc to jedyne sensowne
// miejsce na treść, która nie jest listą powtarzalnych elementów (tak samo
// zrobione na indoornavi.me).
//
// 'public' => false — te wpisy nie mają własnych podstron na froncie, są
// tylko danymi do wyświetlenia w konkretnych sekcjach front-page.php i kart
// produktów; 'show_ui' => true, żeby były widoczne i zarządzalne w menu
// wp-admina.
function in_security_register_post_types() {
    register_post_type( 'outcome', [
        'labels' => [
            'name'          => 'Why It Pays Off — kafle',
            'singular_name' => 'Kafel korzyści',
            'add_new_item'  => 'Dodaj kafel korzyści',
            'edit_item'     => 'Edytuj kafel korzyści',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-star-filled',
        'supports'     => [ 'title', 'page-attributes' ],
        'menu_position' => 20,
    ] );

    register_post_type( 'use_case', [
        'labels' => [
            'name'          => 'Where IN Security Fits — tagi',
            'singular_name' => 'Tag branży',
            'add_new_item'  => 'Dodaj tag branży',
            'edit_item'     => 'Edytuj tag branży',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-tag',
        'supports'     => [ 'title', 'page-attributes' ],
        'menu_position' => 21,
    ] );

    register_post_type( 'device_spec', [
        'labels' => [
            'name'          => 'IN Guard: The Hardware — karty',
            'singular_name' => 'Karta specyfikacji',
            'add_new_item'  => 'Dodaj kartę specyfikacji',
            'edit_item'     => 'Edytuj kartę specyfikacji',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-admin-generic',
        'supports'     => [ 'title', 'page-attributes' ],
        'menu_position' => 22,
    ] );

    register_post_type( 'control_feature', [
        'labels' => [
            'name'          => 'Inside the Control Center — funkcje',
            'singular_name' => 'Funkcja Control Center',
            'add_new_item'  => 'Dodaj funkcję Control Center',
            'edit_item'     => 'Edytuj funkcję Control Center',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-desktop',
        'supports'     => [ 'title', 'page-attributes' ],
        'menu_position' => 23,
    ] );

    register_post_type( 'how_step', [
        'labels' => [
            'name'          => 'How It Works — kroki',
            'singular_name' => 'Krok',
            'add_new_item'  => 'Dodaj krok',
            'edit_item'     => 'Edytuj krok',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-list-view',
        'supports'     => [ 'title', 'page-attributes' ],
        'menu_position' => 24,
    ] );

    // Wspólny CPT dla obu kart produktów (IN Guard + IN Sense) — te same
    // pola (etykieta + wartość), różni je tylko pole wyboru "Produkt", po
    // którym filtrujemy w szablonie zamiast trzymać dwa osobne CPT-y.
    register_post_type( 'product_spec', [
        'labels' => [
            'name'          => 'Karty produktów — wiersze specyfikacji',
            'singular_name' => 'Wiersz specyfikacji',
            'add_new_item'  => 'Dodaj wiersz specyfikacji',
            'edit_item'     => 'Edytuj wiersz specyfikacji',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-editor-table',
        'supports'     => [ 'title', 'page-attributes' ],
        'menu_position' => 25,
    ] );
}
add_action( 'init', 'in_security_register_post_types' );
