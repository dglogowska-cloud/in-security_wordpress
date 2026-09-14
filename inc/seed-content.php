<?php
// Jednorazowy import obecnej (hardkodowanej) treści list do nowych CPT-ów
// jako gotowe wpisy — żeby nie trzeba było ręcznie przepisywać kilkudziesięciu
// wierszy w wp-adminie. Strona Narzędzia → "Import treści IN Security",
// guard: 'manage_options' + nonce. Idempotentne — jeśli dany CPT już ma
// choć jeden wpis, import dla niego jest pomijany (bezpiecznie klikać
// wielokrotnie, nie duplikuje).
//
// Używa in_security_t_lang() (nie in_security_t()!), żeby zapisać en i pl
// naraz, niezależnie od tego, jaki język ma akurat aktywny administrator
// klikający przycisk.

add_action( 'admin_menu', 'in_security_add_seed_page' );
function in_security_add_seed_page() {
    add_management_page(
        'Import treści IN Security',
        'Import treści IN Security',
        'manage_options',
        'in-security-seed',
        'in_security_render_seed_page'
    );
}

function in_security_render_seed_page() {
    $post_types = [ 'outcome', 'use_case', 'device_spec', 'control_feature', 'how_step', 'product_spec' ];
    $result     = isset( $_GET['seed_result'] ) ? json_decode( wp_unslash( $_GET['seed_result'] ), true ) : null;
    ?>
    <div class="wrap">
        <h1>Import treści IN Security</h1>
        <p>Wgrywa obecną (dotąd hardkodowaną) treść list jako gotowe wpisy w nowych typach treści poniżej. Bezpiecznie kliknąć więcej niż raz — jeśli dany typ ma już jakiekolwiek wpisy, jego import zostanie pominięty (nic nie zduplikuje).</p>

        <?php if ( $result ) : ?>
            <div class="notice notice-success">
                <p><strong>Wynik importu:</strong></p>
                <ul>
                    <?php foreach ( $result as $pt => $message ) : ?>
                        <li><strong><?php echo esc_html( $pt ); ?></strong>: <?php echo esc_html( $message ); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <ul>
            <?php foreach ( $post_types as $pt ) : ?>
                <?php $count = wp_count_posts( $pt )->publish; ?>
                <li><strong><?php echo esc_html( $pt ); ?></strong>: <?php echo (int) $count; ?> wpisów</li>
            <?php endforeach; ?>
        </ul>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <?php wp_nonce_field( 'in_security_seed_content' ); ?>
            <input type="hidden" name="action" value="in_security_seed_content">
            <?php submit_button( 'Importuj treść' ); ?>
        </form>
    </div>
    <?php
}

add_action( 'admin_post_in_security_seed_content', 'in_security_handle_seed_content' );
function in_security_handle_seed_content() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Brak uprawnień.' );
    }
    check_admin_referer( 'in_security_seed_content' );

    $summary = [
        'outcome'         => in_security_seed_outcomes(),
        'use_case'        => in_security_seed_use_cases(),
        'device_spec'     => in_security_seed_device_specs(),
        'control_feature' => in_security_seed_control_features(),
        'how_step'        => in_security_seed_how_steps(),
        'product_spec'    => in_security_seed_product_specs(),
    ];

    $redirect = add_query_arg( [
        'page'        => 'in-security-seed',
        'seed_result' => rawurlencode( wp_json_encode( $summary ) ),
    ], admin_url( 'tools.php' ) );

    wp_safe_redirect( $redirect );
    exit;
}

// Zwraca true, jeśli dany CPT jest jeszcze pusty (import ma sens); false,
// jeśli już ma jakiekolwiek wpisy — to daje idempotencję (bezpiecznie klikać
// przycisk importu wielokrotnie).
function in_security_seed_should_run( $post_type ) {
    $existing = get_posts( [
        'post_type'      => $post_type,
        'posts_per_page' => 1,
        'post_status'    => 'any',
    ] );

    return empty( $existing );
}

function in_security_seed_insert( $post_type, $title, $order, $fields ) {
    $post_id = wp_insert_post( [
        'post_type'   => $post_type,
        'post_title'  => $title,
        'post_status' => 'publish',
        'menu_order'  => $order,
    ] );

    if ( is_wp_error( $post_id ) || ! function_exists( 'update_field' ) ) {
        return;
    }

    foreach ( $fields as $key => $value ) {
        update_field( $key, $value, $post_id );
    }
}

function in_security_seed_outcomes() {
    if ( ! in_security_seed_should_run( 'outcome' ) ) {
        return 'pominięto (wpisy już istnieją)';
    }

    $icons = [ 'document', 'check-circle', 'bars', 'no-camera', 'network', 'shield-heart' ];

    for ( $i = 1; $i <= 6; $i++ ) {
        $title_en = in_security_t_lang( 'outcome_' . $i . '_title', 'en' );
        in_security_seed_insert( 'outcome', $title_en, $i - 1, [
            'icon'       => $icons[ $i - 1 ],
            'title_en'   => $title_en,
            'content_en' => in_security_t_lang( 'outcome_' . $i . '_content', 'en' ),
            'title_pl'   => in_security_t_lang( 'outcome_' . $i . '_title', 'pl' ),
            'content_pl' => in_security_t_lang( 'outcome_' . $i . '_content', 'pl' ),
        ] );
    }

    return 'zaimportowano 6 wpisów';
}

function in_security_seed_use_cases() {
    if ( ! in_security_seed_should_run( 'use_case' ) ) {
        return 'pominięto (wpisy już istnieją)';
    }

    for ( $i = 1; $i <= 14; $i++ ) {
        $label_en = in_security_t_lang( 'use_case_' . $i, 'en' );
        in_security_seed_insert( 'use_case', $label_en, $i - 1, [
            'label_en' => $label_en,
            'label_pl' => in_security_t_lang( 'use_case_' . $i, 'pl' ),
        ] );
    }

    return 'zaimportowano 14 wpisów';
}

function in_security_seed_device_specs() {
    if ( ! in_security_seed_should_run( 'device_spec' ) ) {
        return 'pominięto (wpisy już istnieją)';
    }

    for ( $i = 1; $i <= 4; $i++ ) {
        $title_en = in_security_t_lang( 'guard_spec_' . $i . '_title', 'en' );
        in_security_seed_insert( 'device_spec', $title_en, $i - 1, [
            'title_en'   => $title_en,
            'content_en' => in_security_t_lang( 'guard_spec_' . $i . '_content', 'en' ),
            'title_pl'   => in_security_t_lang( 'guard_spec_' . $i . '_title', 'pl' ),
            'content_pl' => in_security_t_lang( 'guard_spec_' . $i . '_content', 'pl' ),
        ] );
    }

    return 'zaimportowano 4 wpisy';
}

function in_security_seed_control_features() {
    if ( ! in_security_seed_should_run( 'control_feature' ) ) {
        return 'pominięto (wpisy już istnieją)';
    }

    for ( $i = 1; $i <= 3; $i++ ) {
        $title_en = in_security_t_lang( 'feature_' . $i . '_title', 'en' );
        in_security_seed_insert( 'control_feature', $title_en, $i - 1, [
            'tag_en'     => in_security_t_lang( 'feature_' . $i . '_tag', 'en' ),
            'title_en'   => $title_en,
            'content_en' => in_security_t_lang( 'feature_' . $i . '_content', 'en' ),
            'tag_pl'     => in_security_t_lang( 'feature_' . $i . '_tag', 'pl' ),
            'title_pl'   => in_security_t_lang( 'feature_' . $i . '_title', 'pl' ),
            'content_pl' => in_security_t_lang( 'feature_' . $i . '_content', 'pl' ),
        ] );
    }

    return 'zaimportowano 3 wpisy (zrzuty ekranu dodaj ręcznie — import nie kopiuje istniejących plików z assets/images/)';
}

function in_security_seed_how_steps() {
    if ( ! in_security_seed_should_run( 'how_step' ) ) {
        return 'pominięto (wpisy już istnieją)';
    }

    $icons = [ 'pin', 'target', 'sync', 'shield-check', 'chart-line' ];

    for ( $i = 1; $i <= 5; $i++ ) {
        $title_en = in_security_t_lang( 'step_' . $i . '_title', 'en' );
        in_security_seed_insert( 'how_step', $title_en, $i - 1, [
            'icon'       => $icons[ $i - 1 ],
            'title_en'   => $title_en,
            'content_en' => in_security_t_lang( 'step_' . $i . '_content', 'en' ),
            'title_pl'   => in_security_t_lang( 'step_' . $i . '_title', 'pl' ),
            'content_pl' => in_security_t_lang( 'step_' . $i . '_content', 'pl' ),
        ] );
    }

    return 'zaimportowano 5 wpisów';
}

function in_security_seed_product_specs() {
    if ( ! in_security_seed_should_run( 'product_spec' ) ) {
        return 'pominięto (wpisy już istnieją)';
    }

    for ( $i = 1; $i <= 16; $i++ ) {
        $label_en = in_security_t_lang( 'guard_card_spec_' . $i . '_label', 'en' );
        in_security_seed_insert( 'product_spec', 'IN Guard — ' . $label_en, $i - 1, [
            'product'  => 'in_guard',
            'label_en' => $label_en,
            'value_en' => in_security_t_lang( 'guard_card_spec_' . $i . '_value', 'en' ),
            'label_pl' => in_security_t_lang( 'guard_card_spec_' . $i . '_label', 'pl' ),
            'value_pl' => in_security_t_lang( 'guard_card_spec_' . $i . '_value', 'pl' ),
        ] );
    }

    for ( $i = 1; $i <= 12; $i++ ) {
        $label_en = in_security_t_lang( 'sense_card_spec_' . $i . '_label', 'en' );
        in_security_seed_insert( 'product_spec', 'IN Sense — ' . $label_en, 100 + $i, [
            'product'  => 'in_sense',
            'label_en' => $label_en,
            'value_en' => in_security_t_lang( 'sense_card_spec_' . $i . '_value', 'en' ),
            'label_pl' => in_security_t_lang( 'sense_card_spec_' . $i . '_label', 'pl' ),
            'value_pl' => in_security_t_lang( 'sense_card_spec_' . $i . '_value', 'pl' ),
        ] );
    }

    return 'zaimportowano 28 wpisów (16 IN Guard + 12 IN Sense)';
}
