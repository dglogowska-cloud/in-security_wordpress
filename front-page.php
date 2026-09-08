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
    '<strong>Start of shift:</strong> clip it on, press the power button, and start walking the route — that\'s the entire setup.',
    '<strong>During the patrol:</strong> IN Guard quietly tracks itself in the background, with nothing for the guard to check or log by hand.',
    '<strong>If something feels wrong:</strong> one press of the button sends an immediate alarm to the control room — no radio, no phone call, no hesitation.',
    '<strong>If a guard goes down:</strong> IN Guard notices on its own and raises the alarm automatically, even if they can\'t reach the button.',
    '<strong>End of shift:</strong> drop it in the charger, and it\'s ready to go for the next patrol.',
];

$how_it_works = [
    [
        'number'  => '01',
        'title'   => 'Define Checkpoints',
        'content' => 'Set the checkpoints a patrol route must cover, each with a target time window, an allowed time deviation, and a distance radius.',
        'icon'    => '<path d="M12 21s7-7.58 7-12A7 7 0 1 0 5 9c0 4.42 7 12 7 12z"/><circle cx="12" cy="9" r="2.5"/>',
    ],
    [
        'number'  => '02',
        'title'   => 'Track in Real Time',
        'content' => 'As the guard walks the route, IN Guard continuously records its exact position in the background.',
        'icon'    => '<circle cx="12" cy="12" r="3"/><path d="M12 3v3M12 18v3M3 12h3M18 12h3"/>',
    ],
    [
        'number'  => '03',
        'title'   => 'Sync Automatically',
        'content' => 'That position data reaches the base station on its own — streamed live when in range, or delivered all at once the moment the guard reconnects.',
        'icon'    => '<path d="M8.5 15.5a5 5 0 0 1 0-7"/><path d="M15.5 8.5a5 5 0 0 1 0 7"/><path d="M5.5 18.5a9 9 0 0 1 0-13"/><path d="M18.5 5.5a9 9 0 0 1 0 13"/><circle cx="12" cy="12" r="1.6" fill="#0070f3" stroke="none"/>',
    ],
    [
        'number'  => '04',
        'title'   => 'Verify Automatically',
        'content' => 'The Control Center compares the recorded route against every checkpoint, automatically flagging missed, late, or off-route visits.',
        'icon'    => '<path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6z"/><path d="M9 12l2 2 4-4"/>',
    ],
    [
        'number'  => '05',
        'title'   => 'Review & Optimize',
        'content' => 'Supervisors watch patrols live or use the Archive to review history, spot bottlenecks, and refine routes over time.',
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
        'tag'     => 'Live Tracking',
        'title'   => 'Live View',
        'content' => 'Select any tracker from the list and watch its patrol unfold in real time — checkpoint by checkpoint, with the exact arrival time for each one. Time and distance buffers are fully adjustable per route, so verification matches the realities of your site.',
        'file'    => 'control-center-live-view.png',
    ],
    [
        'tag'     => 'Easy to Manage',
        'title'   => 'Route & Checkpoint Editor',
        'content' => 'Add, edit, or remove checkpoints and entire routes in a few clicks, no developer support needed — as your facility layout or procedures change, the system changes with you.',
        'file'    => 'control-center-route-editor.png',
    ],
    [
        'tag'     => 'Historical Data',
        'title'   => 'Archive & Analytics',
        'content' => 'Every checkpoint is automatically classified as early, on-time, late, or missed. Filter past patrols by device, date, or time range to dig into the details — spot bottlenecks, recurring delays, or danger zones, and use the data to optimize future routes.',
        'file'    => 'control-center-archive.png',
    ],
];

// Kafle korzyści — celowo mówią o efekcie (compliance, mniej pominiętych
// obchodów, decyzje kadrowe), nie o mechanizmie, żeby nie dublować sekcji
// wyżej. Proste ikony zamiast zdjęć. Dwa ostatnie dotyczą IN Sense.
$outcomes = [
    [
        'title'   => 'Audit-Ready Compliance',
        'content' => 'Every patrol is timestamped and verified automatically — a ready-made record for audits, clients, or insurance.',
        'icon'    => '<rect x="6" y="3" width="12" height="18" rx="2"/><path d="M9 8h6M9 12h6M9 16h3"/>',
    ],
    [
        'title'   => 'Fewer Missed Rounds',
        'content' => 'Automatic verification catches gaps immediately, instead of discovering them after something goes wrong.',
        'icon'    => '<circle cx="12" cy="12" r="9"/><path d="M8 12l3 3 5-6"/>',
    ],
    [
        'title'   => 'Smarter Staffing Decisions',
        'content' => 'Real patrol data — not guesswork — shows you where to add coverage and where routes can be trimmed, raising team efficiency without adding headcount.',
        'icon'    => '<rect x="5" y="12" width="3" height="8"/><rect x="10.5" y="8" width="3" height="12"/><rect x="16" y="4" width="3" height="16"/>',
    ],
    [
        'title'   => 'Complete Anonymity',
        'content' => 'No cameras, no image analysis — guards aren\'t watched on video, only whether they\'re alert.',
        'icon'    => '<path d="M4 8h2l1.5-2h9L18 8h2a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/><circle cx="12" cy="13.5" r="3.2"/><path d="M2 2l20 20"/>',
    ],
    [
        'title'   => 'One Dashboard for Everything',
        'content' => 'IN Sense alerts and IN Guard patrol data both land in the same Control Center — one system for the whole security operation.',
        'icon'    => '<circle cx="6" cy="6" r="2"/><circle cx="18" cy="6" r="2"/><circle cx="12" cy="18" r="2"/><path d="M7.5 7.5L10.5 16.5M16.5 7.5L13.5 16.5M8 6h8"/>',
    ],
    [
        'title'   => 'Built to Extend',
        'content' => 'The Control Center can integrate with your existing systems — access control, alarms, or other software — as your operation grows.',
        'icon'    => '<path d="M9 15l6-6"/><path d="M8 12l-2 2a3 3 0 0 0 4 4l2-2"/><path d="M16 12l2-2a3 3 0 0 0-4-4l-2 2"/>',
    ],
    [
        'title'   => 'Lower Staff Turnover',
        'content' => 'The SOS button and fall detection give guards a constant sense of safety on the job — the kind of support that helps keep good people in the role.',
        'icon'    => '<path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6z"/><path d="M9.5 12c0-1 .8-1.8 1.8-1.8.6 0 1 .3 1.2.7.2-.4.6-.7 1.2-.7 1 0 1.8.8 1.8 1.8 0 1.4-1.5 2.6-3 3.6-1.5-1-3-2.2-3-3.6z"/>',
    ],
    [
        'title'   => 'Instant Threat Detection',
        'content' => 'Sudden movement, a struggle, or a suspected fall at the post triggers an immediate alert — not just a missed check-in.',
        'icon'    => '<circle cx="12" cy="12" r="9"/><path d="M13 7l-4 6h3l-1 4 5-6h-3z" fill="#0070f3" stroke="none"/>',
    ],
    [
        'title'   => 'Guaranteed Post Coverage',
        'content' => 'Confirms not just that a guard showed up, but that they stayed alert at their post for the entire shift.',
        'icon'    => '<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/>',
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
    'Fits any post layout: <strong>ceiling mount, boom arm, or a mobile stand</strong> you can move between booths.',
    '<strong>No cameras, no wearables</strong> — just a compact unit doing its job quietly in the background.',
    'Positioned just above or beside the guard\'s chair — <strong>without ever requiring anything worn on the body</strong>.',
];

// Zdjęcie budki ochroniarskiej — jeszcze nie istnieje w assets/images/,
// więc pokazuje się placeholder. .device-usage-grid--reverse odwraca
// strony (treść z lewej, zdjęcie z prawej), dla odmiany względem "Meet
// IN Sense" tuż powyżej (tam zdjęcie jest po lewej).
$in_sense_booth_path = get_template_directory() . '/assets/images/in-sense-booth.jpg';
$in_sense_booth_url  = $tiles_dir . 'in-sense-booth.jpg';

$in_sense_how_it_works_points = [
    '<strong>Works at a distance (1-3 m):</strong> no wearable required on the guard.',
    '<strong>Passive breathing measurement:</strong> the sensor tracks chest micro-movements in the background, confirming presence and alertness even when the guard is stationary.',
    '<strong>Shift handover & third-party detection:</strong> the system registers when shifts change hands, and flags it if anyone unexpected enters the post.',
    '<strong>Smart, graduated alerts:</strong> first a discreet wake-up signal for the guard, then immediate escalation to the Control Center if it doesn\'t resolve.',
    '<strong>Schedule optimization:</strong> alertness-dip data helps plan shift rotations and breaks more effectively on demanding night shifts.',
];

// Wykres z Fig. 1 (one-pager IN Sense) — ten sam plik co przygaszone tło
// kafelka "platform-overview" ($bg_sleep_chart_path/url, zdefiniowane niżej
// w bloku hub), tu pokazany wprost jako dowód działania, nie jako tło.
$sample_chart_points = [
    'This <strong>30-minute record</strong> shows a guard settling into a stationary post, with the sensor placed <strong>1.5 meters</strong> away.',
    'After several minutes, the <strong>breathing rate noticeably slows down</strong> as alertness drops.',
    'IN Sense automatically flags this as a <strong>graduated alert</strong> — first a discreet wake-up signal, no supervisor watching a screen required.',
];

$use_cases = [
    'Warehouses & Logistics Hubs',
    'Industrial & Production Plants',
    'Corporate Campuses',
    'Critical Infrastructure',
    'Retail & Public Venues',
    'Construction Sites',
    'Data Centers',
    'Airports & Transit Hubs',
    'Healthcare Facilities',
    'Educational Campuses',
    'Solar & Wind Farms',
    'Ports & Maritime Terminals',
    'Guard Booths & Gatehouses',
    'Monitoring & Control Rooms',
];
?>

<main class="security-page">

    <section class="security-hero">
        <div class="container">
            <h1>Every Patrol Proven. <br class="hero-break">Every Post Watched.</h1>
            <p><strong>IN Security</strong> brings patrol verification and post monitoring together in one platform — so your entire security operation runs from a single <strong>Control Center</strong>.</p>
            <div class="cta-group">
                <a href="#platform-overview" class="btn btn-outline">Read more</a>
                <a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer" class="btn btn-primary">Talk to us</a>
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

    $platform_tiles = [
        [
            'title'       => 'IN Guard',
            'content'     => 'Verifies that patrol routes are actually walked, checkpoint by checkpoint, on time — with a full, timestamped record of every round.',
            'device_path' => $garda1_render_path,
            'device_url'  => $garda1_render_url,
            'bg_path'     => $bg_live_view_path,
            'bg_url'      => $bg_live_view_url,
            'anchor'      => '#how-it-works',
            'zoomed'      => false,
        ],
        [
            'title'       => 'IN Sense',
            'content'     => 'Watches over guards holding a stationary post, automatically flagging it the moment their attention drifts into sleep on duty.',
            'device_path' => $in_sense_render_path,
            'device_url'  => $in_sense_render_url,
            'bg_path'     => $bg_sleep_chart_path,
            'bg_url'      => $bg_sleep_chart_url,
            'anchor'      => '#in-sense-how-it-works',
            'zoomed'      => true,
        ],
    ];
    ?>
    <section id="platform-overview" class="platform-overview-section">
        <div class="container">
            <h2>Two Tools, One Platform</h2>
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
                                <div class="platform-tile-placeholder"><?php echo esc_html( $tile['title'] ); ?><br><span>coming soon</span></div>
                            <?php endif; ?>
                        </div>
                        <h3><?php echo esc_html( $tile['title'] ); ?></h3>
                        <p><?php echo esc_html( $tile['content'] ); ?></p>
                        <a href="<?php echo esc_attr( $tile['anchor'] ); ?>" class="cta-link-secondary">How <?php echo esc_html( $tile['title'] ); ?> works<span class="cta-arrow">→</span></a>
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
                            <div class="device-usage-placeholder">IN Guard render<br><span>coming soon</span></div>
                        <?php endif; ?>

                        <?php if ( file_exists( $in_guard_pocket_badge_path ) ) : ?>
                            <img src="<?php echo esc_url( $in_guard_pocket_badge_url ); ?>" alt="IN Guard tracker in a guard's shirt pocket" class="device-usage-badge">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="device-usage-content">
                    <h2>IN Guard in a Guard's Pocket</h2>
                    <p class="security-how-intro">No training manual required — just turn it on and go.</p>
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
            <h2>IN Guard: How It Works</h2>
            <p class="security-how-intro">Built around the IN Guard tracker and a LoRaWAN base station, running entirely on your own network.</p>
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
                                <span class="step-number">Step <?php echo esc_html( $step['number'] ); ?></span>
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
            <h2>IN Guard: The Hardware</h2>
            <p class="section-subtitle">
                A single base station supports up to 200 trackers, and additional stations can be added to extend
                coverage across large or demanding sites. IN Guard is currently a working prototype — its final form
                factor can be tailored to your specific requirements.
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
                    <a href="<?php echo esc_url( $in_guard_product_url ); ?>" class="cta-link-secondary">See full spec sheet<span class="cta-arrow">→</span></a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section id="control-center" class="security-how">
        <div class="container">
            <h2>Inside the Control Center</h2>
            <p class="security-how-intro">One piece of software, running on your own machine — no external server, no subscription fees, and even the map works fully offline. The same Control Center will also surface IN Sense alerts, right alongside your patrol data — meet IN Sense next.</p>

            <div class="feature-showcase">
                <?php foreach ( $control_center_features as $i => $feature ) : ?>
                    <?php $screenshot_path = get_template_directory() . '/assets/images/' . $feature['file']; ?>
                    <div class="feature-row <?php echo ( $i % 2 === 1 ) ? 'feature-row-reverse' : ''; ?>">
                        <div class="feature-media">
                            <?php if ( file_exists( $screenshot_path ) ) : ?>
                                <img src="<?php echo esc_url( $tiles_dir . $feature['file'] ); ?>" alt="<?php echo esc_attr( $feature['title'] ); ?> screenshot" class="feature-screenshot">
                            <?php else : ?>
                                <div class="feature-placeholder"><?php echo esc_html( $feature['title'] ); ?><br><span>screenshot coming soon</span></div>
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
                <p>The software can also be extended and integrated with other systems if your operation needs it.</p>
                <a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer" class="cta-link-secondary">Let's talk about your challenges<span class="cta-arrow">→</span></a>
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
                        <div class="device-usage-placeholder">IN Sense render<br><span>coming soon</span></div>
                    <?php endif; ?>
                </div>
                <div class="device-usage-content">
                    <h2>Meet IN Sense</h2>
                    <p class="security-how-intro">The sensor doing the work: small, unobtrusive, and built to stay out of the way of the job.</p>
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
                    <h2>IN Sense: How It Works</h2>
                    <p class="security-how-intro">A radar sensor that watches over a stationary post — no cameras, no wearables.</p>
                    <ul class="security-how-list">
                        <?php foreach ( $in_sense_how_it_works_points as $point ) : ?>
                            <li><?php echo wp_kses( $point, array( 'strong' => array() ) ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="device-usage-media">
                    <?php if ( file_exists( $in_sense_booth_path ) ) : ?>
                        <img src="<?php echo esc_url( $in_sense_booth_url ); ?>" alt="Security guard booth" class="device-usage-photo">
                    <?php else : ?>
                        <div class="device-usage-placeholder">Guard booth photo<br><span>coming soon</span></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="security-how sample-chart-section">
        <div class="container">
            <h2>From Alert to Drowsy — Captured in a Single Chart</h2>
            <p class="security-how-intro">A real breathing measurement, recorded end to end by IN Sense — the same signal your Control Center would catch.</p>

            <?php if ( file_exists( $bg_sleep_chart_path ) ) : ?>
                <img src="<?php echo esc_url( $bg_sleep_chart_url ); ?>" alt="Sample respiration rate chart, alert to drowsy" class="feature-screenshot sample-chart-image">
            <?php else : ?>
                <div class="feature-placeholder sample-chart-placeholder">Sample measurement chart<br><span>coming soon</span></div>
            <?php endif; ?>

            <ul class="security-how-list sample-chart-list">
                <?php foreach ( $sample_chart_points as $point ) : ?>
                    <li><?php echo wp_kses( $point, array( 'strong' => array() ) ); ?></li>
                <?php endforeach; ?>
            </ul>

            <div class="control-center-footnote">
                <p>IN Sense can be added to any stationary post — gatehouse, booth, or control room — without disrupting how your team already works.</p>
                <a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer" class="cta-link-secondary">Talk to us about your posts<span class="cta-arrow">→</span></a>
            </div>
        </div>
    </section>

    <section class="outcomes-section">
        <div class="container">
            <h2>Why It Pays Off</h2>
            <p class="section-subtitle">Beyond verification — measurable impact on compliance, coverage, and cost.</p>
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
            <h2>Where IN Security Fits</h2>
            <p class="section-subtitle">Anywhere a patrol route needs to be walked, or a post needs to be watched.</p>
            <div class="tags">
                <?php foreach ( $use_cases as $use_case ) : ?>
                    <span class="tag"><?php echo esc_html( $use_case ); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="security-cta">
        <div class="container">
            <h2>Secure Every Patrol. Watch Every Post.</h2>
            <p>Talk to our team about bringing patrol tracking, post monitoring, and verification to your facility.</p>
            <div class="security-cta-btns">
                <a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer" class="btn btn-primary-blue">Book a Consultation</a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
