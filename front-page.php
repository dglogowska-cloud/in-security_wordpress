<?php
/*
 * Treść in-security — dwa produkty platformy IN Security.
 * "IN Security" to nazwa systemu/marki. "IN Guard" to tracker patrolowy
 * (konkretna wersja sprzętowa to wewnętrznie "IN Guard 01", ale Home mówi
 * zawsze "IN Guard" — "01" zarezerwowane dla karty produktu). "IN Sense" to
 * czujnik radarowy — ten sam fizyczny sprzęt co w IN Vitals/in-vitals.me
 * (tam pacjent w łóżku, tu strażnik na stałym posterunku).
 *
 * KOLEJNOŚĆ SEKCJI (celowo w blokach per produkt, żeby czytelnik nie
 * przeskakiwał między IN Guard a IN Sense w środku wątku):
 * Hero → hub "platform-overview" (po jednym zdaniu + link do How It Works
 * każdego produktu) → blok IN Guard w całości (Guard's Pocket → How It
 * Works → The Hardware → Inside the Control Center, z zapowiedzią "meet
 * IN Sense next" na końcu) → blok IN Sense w całości (Meet IN Sense → How
 * It Works → "From Alert to Drowsy" przykładowy wykres pomiaru, dowód
 * działania zamykający wątek IN Sense) → Why It Pays Off (kafle obu produktów, w tym spinający
 * "One Dashboard for Everything") → Where IN Security Fits → CTA.
 * "Inside the Control Center" była kiedyś PO obu sekcjach IN Sense — zostało
 * to celowo przeniesione (2026-08-28), bo psuło wątek: czytelnik wracał do
 * ekranów patrolowych IN Guard tuż po zapoznaniu się z IN Sense.
 *
 * Każda para "X → X: How It Works" pokazuje najpierw praktykę/urządzenie,
 * potem proces — nie odwrotnie (ta sama kolejność dla obu produktów).
 * "IN Guard: The Hardware" to jedyne miejsce z konkretnymi specyfikacjami
 * sprzętu (LoRaWAN/AES, GNSS/15s/500 punktów, bateria, przycisk+upadek);
 * IN Sense celowo NIE ma takiej sekcji na Home — pełna specyfikacja
 * zarezerwowana na przyszłą kartę produktu IN Sense (wzorem
 * page-in-guard.php), żeby nie dublować i nie rozdymać strony głównej.
 *
 * Sekcja "Where IN Security Fits" reużywa klas .services/.tags odziedziczonych
 * z in-monitoring (tam nieużywane, tu dostały wreszcie zastosowanie) — nie
 * duplikujemy stylów.
 *
 * JĘZYK (2026-09-09): wszystkie widoczne stringi idą teraz przez
 * in_security_t('klucz') (patrz inc/i18n.php) zamiast być hardkodowane
 * bezpośrednio tutaj — słownik en/pl siedzi w in_security_strings(). Tam,
 * gdzie tekst zawiera <strong>, wypisujemy przez wp_kses(), nie esc_html().
 */
get_header();

$tiles_dir = get_template_directory_uri() . '/assets/images/';

// Znajdujemy stronę po przypisanym szablonie, nie po hardkodowanym slugu —
// karta produktu (page-in-guard.php) może zostać przeniesiona/zmieniona bez
// psucia tego linku.
$in_guard_product_pages = get_posts( array(
    'post_type'      => 'page',
    'posts_per_page' => 1,
    'meta_key'       => '_wp_page_template',
    'meta_value'     => 'page-in-guard.php',
) );
$in_guard_product_url = ! empty( $in_guard_product_pages ) ? get_permalink( $in_guard_product_pages[0] ) : '';

$in_sense_product_pages = get_posts( array(
    'post_type'      => 'page',
    'posts_per_page' => 1,
    'meta_key'       => '_wp_page_template',
    'meta_value'     => 'page-in-sense.php',
) );
$in_sense_product_url = ! empty( $in_sense_product_pages ) ? get_permalink( $in_sense_product_pages[0] ) : '';

// Render ma przezroczyste tło, dlatego PNG (nie JPG, który by je zabił).
$garda1_render_path = get_template_directory() . '/assets/images/in-guard-render.png';
$garda1_render_url  = $tiles_dir . 'in-guard-render.png';

// Odznaka w kółku na rogu renderu (wzorem in-vitals) — bez placeholdera:
// to dodatek do zdjęcia głównego, nie osobna treść, więc dopóki pliku nie
// ma, po prostu się nie pokazuje.
$in_guard_pocket_badge_path = get_template_directory() . '/assets/images/in-guard-pocket.jpg';
$in_guard_pocket_badge_url  = $tiles_dir . 'in-guard-pocket.jpg';

// Fragmenty w <strong> renderują się pogrubione — lista jest wypisywana przez
// wp_kses (nie esc_html), więc bezpiecznie przepuszcza tylko ten jeden tag.
$device_usage_points = [
    in_security_t( 'guard_pocket_point_1' ),
    in_security_t( 'guard_pocket_point_2' ),
    in_security_t( 'guard_pocket_point_3' ),
    in_security_t( 'guard_pocket_point_4' ),
    in_security_t( 'guard_pocket_point_5' ),
];

$how_it_works = [
    [
        'number'  => '01',
        'title'   => in_security_t( 'step_1_title' ),
        'content' => in_security_t( 'step_1_content' ),
        'icon'    => '<path d="M12 21s7-7.58 7-12A7 7 0 1 0 5 9c0 4.42 7 12 7 12z"/><circle cx="12" cy="9" r="2.5"/>',
    ],
    [
        'number'  => '02',
        'title'   => in_security_t( 'step_2_title' ),
        'content' => in_security_t( 'step_2_content' ),
        'icon'    => '<circle cx="12" cy="12" r="3"/><path d="M12 3v3M12 18v3M3 12h3M18 12h3"/>',
    ],
    [
        'number'  => '03',
        'title'   => in_security_t( 'step_3_title' ),
        'content' => in_security_t( 'step_3_content' ),
        'icon'    => '<path d="M8.5 15.5a5 5 0 0 1 0-7"/><path d="M15.5 8.5a5 5 0 0 1 0 7"/><path d="M5.5 18.5a9 9 0 0 1 0-13"/><path d="M18.5 5.5a9 9 0 0 1 0 13"/><circle cx="12" cy="12" r="1.6" fill="#0070f3" stroke="none"/>',
    ],
    [
        'number'  => '04',
        'title'   => in_security_t( 'step_4_title' ),
        'content' => in_security_t( 'step_4_content' ),
        'icon'    => '<path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6z"/><path d="M9 12l2 2 4-4"/>',
    ],
    [
        'number'  => '05',
        'title'   => in_security_t( 'step_5_title' ),
        'content' => in_security_t( 'step_5_content' ),
        'icon'    => '<path d="M4 19V5M4 19h16"/><path d="M7 15l4-4 3 3 5-6"/>',
    ],
];

// Treść w <strong> renderuje się pogrubiona — wypisywana przez wp_kses
// (nie esc_html), więc bezpiecznie przepuszcza tylko ten jeden tag.
// Tablica żyje w functions.php (in_guard_specs()), bo ta sama specyfikacja
// pojawia się też na karcie produktu page-in-guard.php.
$device_specs = in_guard_specs();

// Zrzuty ekranu z oprogramowania — dopóki plik nie istnieje w assets/images/,
// pokazuje się placeholder 16:9 zamiast pustej kolumny.
$control_center_features = [
    [
        'tag'     => in_security_t( 'feature_1_tag' ),
        'title'   => in_security_t( 'feature_1_title' ),
        'content' => in_security_t( 'feature_1_content' ),
        'file'    => 'control-center-live-view.png',
    ],
    [
        'tag'     => in_security_t( 'feature_2_tag' ),
        'title'   => in_security_t( 'feature_2_title' ),
        'content' => in_security_t( 'feature_2_content' ),
        'file'    => 'control-center-route-editor.png',
    ],
    [
        'tag'     => in_security_t( 'feature_3_tag' ),
        'title'   => in_security_t( 'feature_3_title' ),
        'content' => in_security_t( 'feature_3_content' ),
        'file'    => 'control-center-archive.png',
    ],
];

// Kafle korzyści — celowo mówią o efekcie (compliance, mniej pominiętych
// obchodów, decyzje kadrowe), nie o mechanizmie, żeby nie dublować sekcji
// wyżej. Proste ikony zamiast zdjęć. Dwa ostatnie dotyczą IN Sense.
// Skompresowane z 9 do 6 kafli (2026-09-09) — łączy blisko powiązane pary
// (compliance+coverage, missed rounds+instant alerts, dashboard+integracje),
// żeby sekcja czytała się szybciej. Żaden fakt nie zniknął, tylko się połączył.
$outcomes = [
    [
        'title'   => in_security_t( 'outcome_1_title' ),
        'content' => in_security_t( 'outcome_1_content' ),
        'icon'    => '<rect x="6" y="3" width="12" height="18" rx="2"/><path d="M9 8h6M9 12h6M9 16h3"/>',
    ],
    [
        'title'   => in_security_t( 'outcome_2_title' ),
        'content' => in_security_t( 'outcome_2_content' ),
        'icon'    => '<circle cx="12" cy="12" r="9"/><path d="M8 12l3 3 5-6"/>',
    ],
    [
        'title'   => in_security_t( 'outcome_3_title' ),
        'content' => in_security_t( 'outcome_3_content' ),
        'icon'    => '<rect x="5" y="12" width="3" height="8"/><rect x="10.5" y="8" width="3" height="12"/><rect x="16" y="4" width="3" height="16"/>',
    ],
    [
        'title'   => in_security_t( 'outcome_4_title' ),
        'content' => in_security_t( 'outcome_4_content' ),
        'icon'    => '<path d="M4 8h2l1.5-2h9L18 8h2a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/><circle cx="12" cy="13.5" r="3.2"/><path d="M2 2l20 20"/>',
    ],
    [
        'title'   => in_security_t( 'outcome_5_title' ),
        'content' => in_security_t( 'outcome_5_content' ),
        'icon'    => '<circle cx="6" cy="6" r="2"/><circle cx="18" cy="6" r="2"/><circle cx="12" cy="18" r="2"/><path d="M7.5 7.5L10.5 16.5M16.5 7.5L13.5 16.5M8 6h8"/>',
    ],
    [
        'title'   => in_security_t( 'outcome_6_title' ),
        'content' => in_security_t( 'outcome_6_content' ),
        'icon'    => '<path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6z"/><path d="M9.5 12c0-1 .8-1.8 1.8-1.8.6 0 1 .3 1.2.7.2-.4.6-.7 1.2-.7 1 0 1.8.8 1.8 1.8 0 1.4-1.5 2.6-3 3.6-1.5-1-3-2.2-3-3.6z"/>',
    ],
];

// IN Sense — drugie narzędzie platformy. Ten sam fizyczny czujnik radarowy co
// w IN Vitals (in-vitals.me), inny kontekst: tam pacjent w łóżku, tu strażnik
// na stałym posterunku (budka, dyżurka, punkt kontrolny). Render i podpisy
// współdzielą wzorzec z "IN Guard in a Guard's Pocket" — plik na razie nie
// istnieje, więc pokazuje się placeholder.
$in_sense_render_path = get_template_directory() . '/assets/images/in-sense-render.png';
$in_sense_render_url  = $tiles_dir . 'in-sense-render.png';

$in_sense_points = [
    in_security_t( 'sense_point_1' ),
    in_security_t( 'sense_point_2' ),
    in_security_t( 'sense_point_3' ),
];

// Zdjęcie budki ochroniarskiej — jeszcze nie istnieje w assets/images/,
// więc pokazuje się placeholder. .device-usage-grid--reverse odwraca
// strony (treść z lewej, zdjęcie z prawej), dla odmiany względem "Meet
// IN Sense" tuż powyżej (tam zdjęcie jest po lewej).
$in_sense_booth_path = get_template_directory() . '/assets/images/in-sense-booth.jpg';
$in_sense_booth_url  = $tiles_dir . 'in-sense-booth.jpg';

$in_sense_how_it_works_points = [
    in_security_t( 'sense_how_point_1' ),
    in_security_t( 'sense_how_point_2' ),
    in_security_t( 'sense_how_point_3' ),
    in_security_t( 'sense_how_point_4' ),
    in_security_t( 'sense_how_point_5' ),
];

// Wykres z Fig. 1 (one-pager IN Sense) — ten sam plik co przygaszone tło
// kafelka "platform-overview" ($bg_sleep_chart_path/url, zdefiniowane niżej
// w bloku hub), tu pokazany wprost jako dowód działania, nie jako tło.
$sample_chart_points = [
    in_security_t( 'chart_point_1' ),
    in_security_t( 'chart_point_2' ),
    in_security_t( 'chart_point_3' ),
];

$use_cases = [
    in_security_t( 'use_case_1' ),
    in_security_t( 'use_case_2' ),
    in_security_t( 'use_case_3' ),
    in_security_t( 'use_case_4' ),
    in_security_t( 'use_case_5' ),
    in_security_t( 'use_case_6' ),
    in_security_t( 'use_case_7' ),
    in_security_t( 'use_case_8' ),
    in_security_t( 'use_case_9' ),
    in_security_t( 'use_case_10' ),
    in_security_t( 'use_case_11' ),
    in_security_t( 'use_case_12' ),
    in_security_t( 'use_case_13' ),
    in_security_t( 'use_case_14' ),
];
?>

<main class="security-page">

    <section class="security-hero">
        <div class="container">
            <h1><?php echo esc_html( in_security_t( 'hero_heading_line1' ) ); ?> <br class="hero-break"><?php echo esc_html( in_security_t( 'hero_heading_line2' ) ); ?></h1>
            <p><?php echo wp_kses( in_security_t( 'hero_subtitle' ), array( 'strong' => array() ) ); ?></p>
            <div class="cta-group">
                <a href="#platform-overview" class="btn btn-outline"><?php echo esc_html( in_security_t( 'hero_cta_read_more' ) ); ?></a>
                <a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer" class="btn btn-primary"><?php echo esc_html( in_security_t( 'hero_cta_talk_to_us' ) ); ?></a>
            </div>
        </div>
    </section>

    <?php
    // Dwa kafelki-rozdzielacze zaraz po hero — po jednym zdaniu na narzędzie,
    // małe zdjęcie i link do właściwej sekcji "How It Works" niżej na stronie.
    // Warstwowa wizualizacja: przygaszone tło (zrzut ekranu / wykres) na całą
    // szerokość kafelka, a na wierzchu render urządzenia z cieniem. Tła też
    // sprawdzają file_exists — dopóki brak pliku, kafelek pokazuje samo
    // przygaszone tło sekcji, bez błędu.
    $bg_live_view_path  = get_template_directory() . '/assets/images/control-center-live-view.png';
    $bg_live_view_url   = $tiles_dir . 'control-center-live-view.png';
    $bg_sleep_chart_path = get_template_directory() . '/assets/images/in-sense-sample-chart.png';
    $bg_sleep_chart_url  = $tiles_dir . 'in-sense-sample-chart.png';

    // 'title' to nazwa marki (IN Guard/IN Sense) — celowo NIE idzie przez
    // in_security_t(), bo nazwy produktów zostają takie same w obu językach.
    $platform_tiles = [
        [
            'title'       => 'IN Guard',
            'content'     => in_security_t( 'hub_guard_content' ),
            'device_path' => $garda1_render_path,
            'device_url'  => $garda1_render_url,
            'bg_path'     => $bg_live_view_path,
            'bg_url'      => $bg_live_view_url,
            'anchor'      => '#how-it-works',
            'zoomed'      => false,
        ],
        [
            'title'       => 'IN Sense',
            'content'     => in_security_t( 'hub_sense_content' ),
            'device_path' => $in_sense_render_path,
            'device_url'  => $in_sense_render_url,
            'bg_path'     => $bg_sleep_chart_path,
            'bg_url'      => $bg_sleep_chart_url,
            'anchor'      => '#meet-in-sense',
            'zoomed'      => true,
        ],
    ];
    ?>
    <section id="platform-overview" class="platform-overview-section">
        <div class="container">
            <h2><?php echo esc_html( in_security_t( 'hub_heading' ) ); ?></h2>
            <p class="section-subtitle"><?php echo esc_html( in_security_t( 'hub_subtitle' ) ); ?></p>
            <div class="platform-overview-grid">
                <?php foreach ( $platform_tiles as $tile ) : ?>
                    <div class="platform-tile">
                        <div class="platform-tile-visual">
                            <?php if ( file_exists( $tile['bg_path'] ) ) : ?>
                                <div class="platform-tile-visual-bg" style="background-image:url('<?php echo esc_url( $tile['bg_url'] ); ?>');"></div>
                            <?php endif; ?>
                            <?php if ( file_exists( $tile['device_path'] ) ) : ?>
                                <img src="<?php echo esc_url( $tile['device_url'] ); ?>" alt="<?php echo esc_attr( $tile['title'] ); ?> device" class="platform-tile-device-image<?php echo $tile['zoomed'] ? ' platform-tile-device-image--zoomed' : ''; ?>">
                            <?php else : ?>
                                <div class="platform-tile-placeholder"><?php echo esc_html( $tile['title'] ); ?><br><span><?php echo esc_html( in_security_t( 'label_coming_soon' ) ); ?></span></div>
                            <?php endif; ?>
                        </div>
                        <h3><?php echo esc_html( $tile['title'] ); ?></h3>
                        <p><?php echo wp_kses( $tile['content'], array( 'strong' => array() ) ); ?></p>
                        <a href="<?php echo esc_attr( $tile['anchor'] ); ?>" class="cta-link-secondary"><?php echo esc_html( sprintf( in_security_t( 'hub_cta_template' ), $tile['title'] ) ); ?><span class="cta-arrow">→</span></a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="security-device-usage">
        <div class="container">
            <span class="section-eyebrow">IN Guard</span>
            <div class="device-usage-grid">
                <div class="device-usage-media">
                    <div class="device-usage-image-wrap">
                        <?php if ( file_exists( $garda1_render_path ) ) : ?>
                            <img src="<?php echo esc_url( $garda1_render_url ); ?>" alt="IN Guard tracker render" class="device-usage-image">
                        <?php else : ?>
                            <div class="device-usage-placeholder"><?php echo esc_html( in_security_t( 'label_in_guard_render' ) ); ?><br><span><?php echo esc_html( in_security_t( 'label_coming_soon' ) ); ?></span></div>
                        <?php endif; ?>

                        <?php if ( file_exists( $in_guard_pocket_badge_path ) ) : ?>
                            <img src="<?php echo esc_url( $in_guard_pocket_badge_url ); ?>" alt="IN Guard tracker in a guard's shirt pocket" class="device-usage-badge">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="device-usage-content">
                    <h2><?php echo esc_html( in_security_t( 'guard_pocket_heading' ) ); ?></h2>
                    <p class="security-how-intro"><?php echo esc_html( in_security_t( 'guard_pocket_intro' ) ); ?></p>
                    <ul class="security-how-list">
                        <?php foreach ( $device_usage_points as $point ) : ?>
                            <li><?php echo wp_kses( $point, array( 'strong' => array() ) ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="security-how">
        <div class="container">
            <h2><?php echo esc_html( in_security_t( 'guard_how_heading' ) ); ?></h2>
            <p class="security-how-intro"><?php echo esc_html( in_security_t( 'guard_how_intro' ) ); ?></p>
            <div class="roadmap-wrapper-context how-it-works-steps">
                <div class="roadmap-connect-line"></div>
                <div class="roadmap-wrapper">
                    <?php foreach ( $how_it_works as $step ) : ?>
                        <div class="step-card">
                            <div class="step-header">
                                <span class="step-icon-small">
                                    <svg viewBox="0 0 24 24" width="20" height="20" style="fill:none;" stroke="#0070f3" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <?php echo $step['icon']; ?>
                                    </svg>
                                </span>
                                <span class="step-number"><?php echo esc_html( in_security_t( 'label_step_prefix' ) ); ?> <?php echo esc_html( $step['number'] ); ?></span>
                            </div>
                            <div class="step-body">
                                <h3><?php echo esc_html( $step['title'] ); ?></h3>
                                <p><?php echo esc_html( $step['content'] ); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="device-specs-section">
        <div class="container">
            <h2><?php echo esc_html( in_security_t( 'guard_hardware_heading' ) ); ?></h2>
            <p class="section-subtitle">
                <?php echo esc_html( in_security_t( 'guard_hardware_subtitle' ) ); ?>
            </p>

            <div class="device-specs-grid">
                <?php foreach ( $device_specs as $spec ) : ?>
                    <div class="device-spec-card">
                        <div class="number"><?php echo esc_html( $spec['number'] ); ?></div>
                        <h3><?php echo esc_html( $spec['title'] ); ?></h3>
                        <p><?php echo wp_kses( $spec['content'], array( 'strong' => array() ) ); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ( $in_guard_product_url ) : ?>
                <div class="device-specs-footnote">
                    <a href="<?php echo esc_url( $in_guard_product_url ); ?>" class="cta-link-secondary"><?php echo esc_html( in_security_t( 'guard_hardware_footnote_cta' ) ); ?><span class="cta-arrow">→</span></a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section id="control-center" class="security-how">
        <div class="container">
            <h2><?php echo esc_html( in_security_t( 'control_center_heading' ) ); ?></h2>
            <p class="security-how-intro"><?php echo esc_html( in_security_t( 'control_center_intro' ) ); ?></p>

            <div class="feature-showcase">
                <?php foreach ( $control_center_features as $i => $feature ) : ?>
                    <?php $screenshot_path = get_template_directory() . '/assets/images/' . $feature['file']; ?>
                    <div class="feature-row <?php echo ( $i % 2 === 1 ) ? 'feature-row-reverse' : ''; ?>">
                        <div class="feature-media">
                            <?php if ( file_exists( $screenshot_path ) ) : ?>
                                <img src="<?php echo esc_url( $tiles_dir . $feature['file'] ); ?>" alt="<?php echo esc_attr( $feature['title'] ); ?> screenshot" class="feature-screenshot">
                            <?php else : ?>
                                <div class="feature-placeholder"><?php echo esc_html( $feature['title'] ); ?><br><span><?php echo esc_html( in_security_t( 'label_screenshot_coming_soon' ) ); ?></span></div>
                            <?php endif; ?>
                        </div>
                        <div class="feature-text">
                            <span class="feature-tag"><?php echo esc_html( $feature['tag'] ); ?></span>
                            <h3><?php echo esc_html( $feature['title'] ); ?></h3>
                            <p><?php echo esc_html( $feature['content'] ); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="control-center-footnote">
                <p><?php echo esc_html( in_security_t( 'control_center_footnote_text' ) ); ?></p>
                <a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer" class="cta-link-secondary"><?php echo esc_html( in_security_t( 'control_center_footnote_cta' ) ); ?><span class="cta-arrow">→</span></a>
            </div>
        </div>
    </section>

    <section id="meet-in-sense" class="security-device-usage">
        <div class="container">
            <span class="section-eyebrow">IN Sense</span>
            <div class="device-usage-grid">
                <div class="device-usage-media">
                    <?php if ( file_exists( $in_sense_render_path ) ) : ?>
                        <img src="<?php echo esc_url( $in_sense_render_url ); ?>" alt="IN Sense sensor render" class="device-usage-image">
                    <?php else : ?>
                        <div class="device-usage-placeholder"><?php echo esc_html( in_security_t( 'label_in_sense_render' ) ); ?><br><span><?php echo esc_html( in_security_t( 'label_coming_soon' ) ); ?></span></div>
                    <?php endif; ?>
                </div>
                <div class="device-usage-content">
                    <h2><?php echo esc_html( in_security_t( 'meet_sense_heading' ) ); ?></h2>
                    <p class="security-how-intro"><?php echo esc_html( in_security_t( 'meet_sense_intro' ) ); ?></p>
                    <ul class="security-how-list">
                        <?php foreach ( $in_sense_points as $point ) : ?>
                            <li><?php echo wp_kses( $point, array( 'strong' => array() ) ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="in-sense-how-it-works" class="security-device-usage">
        <div class="container">
            <div class="device-usage-grid device-usage-grid--reverse">
                <div class="device-usage-content">
                    <h2><?php echo esc_html( in_security_t( 'sense_how_heading' ) ); ?></h2>
                    <p class="security-how-intro"><?php echo esc_html( in_security_t( 'sense_how_intro' ) ); ?></p>
                    <ul class="security-how-list">
                        <?php foreach ( $in_sense_how_it_works_points as $point ) : ?>
                            <li><?php echo wp_kses( $point, array( 'strong' => array() ) ); ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <?php if ( $in_sense_product_url ) : ?>
                        <div class="device-specs-footnote">
                            <a href="<?php echo esc_url( $in_sense_product_url ); ?>" class="cta-link-secondary"><?php echo esc_html( in_security_t( 'sense_hardware_footnote_cta' ) ); ?><span class="cta-arrow">→</span></a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="device-usage-media">
                    <?php if ( file_exists( $in_sense_booth_path ) ) : ?>
                        <img src="<?php echo esc_url( $in_sense_booth_url ); ?>" alt="Security guard booth" class="device-usage-photo">
                    <?php else : ?>
                        <div class="device-usage-placeholder"><?php echo esc_html( in_security_t( 'label_guard_booth_photo' ) ); ?><br><span><?php echo esc_html( in_security_t( 'label_coming_soon' ) ); ?></span></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="security-how sample-chart-section">
        <div class="container">
            <h2><?php echo esc_html( in_security_t( 'chart_heading' ) ); ?></h2>
            <p class="security-how-intro"><?php echo esc_html( in_security_t( 'chart_intro' ) ); ?></p>

            <?php if ( file_exists( $bg_sleep_chart_path ) ) : ?>
                <img src="<?php echo esc_url( $bg_sleep_chart_url ); ?>" alt="Sample respiration rate chart, alert to drowsy" class="feature-screenshot sample-chart-image">
            <?php else : ?>
                <div class="feature-placeholder sample-chart-placeholder"><?php echo esc_html( in_security_t( 'label_sample_chart' ) ); ?><br><span><?php echo esc_html( in_security_t( 'label_coming_soon' ) ); ?></span></div>
            <?php endif; ?>

            <ul class="security-how-list sample-chart-list">
                <?php foreach ( $sample_chart_points as $point ) : ?>
                    <li><?php echo wp_kses( $point, array( 'strong' => array() ) ); ?></li>
                <?php endforeach; ?>
            </ul>

            <div class="control-center-footnote">
                <p><?php echo esc_html( in_security_t( 'chart_footnote_text' ) ); ?></p>
                <a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer" class="cta-link-secondary"><?php echo esc_html( in_security_t( 'chart_footnote_cta' ) ); ?><span class="cta-arrow">→</span></a>
            </div>
        </div>
    </section>

    <section class="outcomes-section">
        <div class="container">
            <h2><?php echo esc_html( in_security_t( 'outcomes_heading' ) ); ?></h2>
            <p class="section-subtitle"><?php echo esc_html( in_security_t( 'outcomes_subtitle' ) ); ?></p>
            <div class="outcomes-grid">
                <?php foreach ( $outcomes as $outcome ) : ?>
                    <div class="outcome-tile">
                        <div class="outcome-tile-body">
                            <div class="outcome-tile-header">
                                <div class="outcome-tile-icon">
                                    <svg viewBox="0 0 24 24" width="26" height="26" style="fill:none;" stroke="#0070f3" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <?php echo $outcome['icon']; ?>
                                    </svg>
                                </div>
                                <h3><?php echo esc_html( $outcome['title'] ); ?></h3>
                            </div>
                            <p><?php echo esc_html( $outcome['content'] ); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="services">
        <div class="container">
            <h2><?php echo esc_html( in_security_t( 'services_heading' ) ); ?></h2>
            <p class="section-subtitle"><?php echo esc_html( in_security_t( 'services_subtitle' ) ); ?></p>
            <div class="tags">
                <?php foreach ( $use_cases as $use_case ) : ?>
                    <span class="tag"><?php echo esc_html( $use_case ); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="security-cta">
        <div class="container">
            <h2><?php echo esc_html( in_security_t( 'final_cta_heading' ) ); ?></h2>
            <p><?php echo esc_html( in_security_t( 'final_cta_text' ) ); ?></p>
            <div class="security-cta-btns">
                <a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer" class="btn btn-primary-blue"><?php echo esc_html( in_security_t( 'final_cta_button' ) ); ?></a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
