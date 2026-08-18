<?php
/*
 * Treść in-security — LoRa-based tracking do weryfikacji obchodów ochrony.
 * "IN Security" to nazwa systemu/marki, "IN Guard 01" to nazwa konkretnego
 * urządzenia (trackera) — rozróżniamy to konsekwentnie w treści poniżej.
 *
 * Trzy sekcje celowo pokazują trzy różne perspektywy, żeby się nie dublować —
 * żadna liczba/fakt techniczny nie powtarza się w więcej niż jednym miejscu:
 * "How It Works" (proces na poziomie ogólnym, bez twardych liczb) →
 * "IN Guard 01 in a Guard's Pocket" (historia dnia pracy strażnika, zero żargonu
 * technicznego; render urządzenia po lewej — wstaw jako
 * assets/images/in-guard-render.png (przezroczyste tło), do tego czasu
 * pokazuje się placeholder) →
 * "The Hardware" (jedyne miejsce z konkretnymi specyfikacjami: LoRaWAN/AES,
 * GNSS/15s/500 punktów, bateria/ładowanie, przycisk+upadek — nazwa sekcji
 * celowo sygnalizuje "tu są dane techniczne", w parze z "Inside the Control
 * Center" niżej dla oprogramowania).
 *
 * Sekcja "Where IN Security Fits" reużywa klas .services/.tags odziedziczonych
 * z in-monitoring (tam nieużywane, tu dostały wreszcie zastosowanie) — nie
 * duplikujemy stylów.
 */
get_header();

$tiles_dir = get_template_directory_uri() . '/assets/images/';

// Render ma przezroczyste tło, dlatego PNG (nie JPG, który by je zabił).
$garda1_render_path = get_template_directory() . '/assets/images/in-guard-render.png';
$garda1_render_url  = $tiles_dir . 'in-guard-render.png';

// Fragmenty w <strong> renderują się pogrubione — lista jest wypisywana przez
// wp_kses (nie esc_html), więc bezpiecznie przepuszcza tylko ten jeden tag.
$device_usage_points = [
    '<strong>Start of shift:</strong> clip it on, press the power button, and start walking the route — that\'s the entire setup.',
    '<strong>During the patrol:</strong> IN Guard 01 quietly tracks itself in the background, with nothing for the guard to check or log by hand.',
    '<strong>If something feels wrong:</strong> one press of the button sends an immediate alarm to the control room — no radio, no phone call, no hesitation.',
    '<strong>If a guard goes down:</strong> IN Guard 01 notices on its own and raises the alarm automatically, even if they can\'t reach the button.',
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
        'content' => 'As the guard walks the route, IN Guard 01 continuously records its exact position in the background.',
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
        'content' => 'Add, edit, or remove checkpoints and entire routes in a few clicks — as your facility layout or procedures change, the system changes with you.',
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
// wyżej. Proste ikony zamiast zdjęć.
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
        'content' => 'Real patrol data — not guesswork — shows you where to add coverage and where routes can be trimmed.',
        'icon'    => '<rect x="5" y="12" width="3" height="8"/><rect x="10.5" y="8" width="3" height="12"/><rect x="16" y="4" width="3" height="16"/>',
    ],
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
];
?>

<main class="security-page">

    <section class="security-hero">
        <div class="container">
            <h1>Prove Every Patrol Happened <br class="hero-break">— On Route, On Time</h1>
            <p>IN Security is a LoRa-based tracking solution that manages and verifies security patrol routes — track guards in real time against defined checkpoints and schedules, with no paperwork, no guesswork, and no data ever leaving your network.</p>
            <div class="cta-group">
                <a href="#how-it-works" class="btn btn-outline">See how it works</a>
                <a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer" class="btn btn-primary">Talk to us</a>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="security-how">
        <div class="container">
            <h2>IN Security: How It Works</h2>
            <p class="security-how-intro">Built around the IN Guard 01 tracker and a LoRaWAN base station, running entirely on your own network.</p>
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

    <section class="security-device-usage">
        <div class="container">
            <div class="device-usage-grid">
                <div class="device-usage-media">
                    <?php if ( file_exists( $garda1_render_path ) ) : ?>
                        <img src="<?php echo esc_url( $garda1_render_url ); ?>" alt="IN Guard 01 tracker render" class="device-usage-image">
                    <?php else : ?>
                        <div class="device-usage-placeholder">IN Guard 01 render<br><span>coming soon</span></div>
                    <?php endif; ?>
                </div>
                <div class="device-usage-content">
                    <h2>IN Guard 01 in a Guard's Pocket</h2>
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

    <section class="device-specs-section">
        <div class="container">
            <h2>The Hardware</h2>
            <p class="section-subtitle">
                A single base station supports up to 200 trackers, and additional stations can be added to extend
                coverage across large or demanding sites. IN Guard 01 is currently a working prototype — its final form
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
        </div>
    </section>

    <section class="security-how">
        <div class="container">
            <h2>Inside the Control Center</h2>
            <p class="security-how-intro">One piece of software, running on your own machine — no external server required, and even the map works fully offline.</p>

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
            <p class="section-subtitle">Anywhere a patrol route needs to be walked — and proven.</p>
            <div class="tags">
                <?php foreach ( $use_cases as $use_case ) : ?>
                    <span class="tag"><?php echo esc_html( $use_case ); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="security-cta">
        <div class="container">
            <h2>Ready to Verify Your Security Patrols?</h2>
            <p>Talk to our team about bringing LoRa-based patrol tracking and verification to your facility.</p>
            <div class="security-cta-btns">
                <a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer" class="btn btn-primary-blue">Book a Consultation</a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
