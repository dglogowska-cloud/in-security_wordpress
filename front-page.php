<?php
/*
 * Treść in-security — LoRa-based tracking do weryfikacji obchodów ochrony.
 *
 * Trzy sekcje celowo pokazują trzy różne perspektywy, żeby się nie dublować —
 * żadna liczba/fakt techniczny nie powtarza się w więcej niż jednym miejscu:
 * "How It Works" (proces na poziomie ogólnym, bez twardych liczb) →
 * "IN Security in a Guard's Pocket" (historia dnia pracy strażnika, zero żargonu
 * technicznego; render urządzenia po lewej — wstaw jako
 * assets/images/garda1-render.png (przezroczyste tło), do tego czasu
 * pokazuje się placeholder) →
 * "Meet IN Security" (jedyne miejsce z konkretnymi specyfikacjami: LoRaWAN/AES,
 * GNSS/15s/500 punktów, bateria/ładowanie, przycisk+upadek).
 *
 * Sekcja "Where IN Security Fits" reużywa klas .services/.tags odziedziczonych
 * z in-monitoring (tam nieużywane, tu dostały wreszcie zastosowanie) — nie
 * duplikujemy stylów. AI-generowane obrazki checkpoints-configuration.jpg /
 * patrol-verification.jpg / statistics.jpg zostały w assets/images/ na potrzeby
 * przyszłej sekcji z korzyściami (jeszcze nieumieszczonej na stronie).
 */
get_header();

$tiles_dir = get_template_directory_uri() . '/assets/images/';

// Render ma przezroczyste tło, dlatego PNG (nie JPG, który by je zabił).
$garda1_render_path = get_template_directory() . '/assets/images/garda1-render.png';
$garda1_render_url  = $tiles_dir . 'garda1-render.png';

// Fragmenty w <strong> renderują się pogrubione — lista jest wypisywana przez
// wp_kses (nie esc_html), więc bezpiecznie przepuszcza tylko ten jeden tag.
$device_usage_points = [
    '<strong>Start of shift:</strong> clip it on, press the power button, and start walking the route — that\'s the entire setup.',
    '<strong>During the patrol:</strong> IN Security quietly tracks itself in the background, with nothing for the guard to check or log by hand.',
    '<strong>If something feels wrong:</strong> one press of the button sends an immediate alarm to the control room — no radio, no phone call, no hesitation.',
    '<strong>If a guard goes down:</strong> IN Security notices on its own and raises the alarm automatically, even if they can\'t reach the button.',
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
        'content' => 'As the guard walks the route, IN Security continuously records its exact position in the background.',
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

$device_specs = [
    [
        'number'  => '01',
        'title'   => 'Long-Range, Encrypted & Fully On-Premise',
        'content' => 'IN Security talks to its base station over the 868 MHz ISM band using LoRaWAN, secured end to end with AES-128 encryption — only devices explicitly registered to your system can ever transmit. The base station connects only to your own control PC (Wi-Fi, LTE, or wired Ethernet), so patrol data never has to leave your network.',
    ],
    [
        'number'  => '02',
        'title'   => 'Precise, Continuous Positioning',
        'content' => 'A built-in multi-constellation GNSS receiver (GPS, GLONASS, Galileo, BeiDou) logs the tracker\'s exact position every 15 seconds, storing up to 500 points on-device and uploading them the moment it\'s back in range of the base station.',
    ],
    [
        'number'  => '03',
        'title'   => 'Built for a Full Shift',
        'content' => 'An onboard battery keeps IN Security running for several hours of continuous patrol work. Recharge it with a standard USB-C cable, or use the dedicated docking station that charges three units at once.',
    ],
    [
        'number'  => '04',
        'title'   => 'Two Layers of Guard Safety',
        'content' => 'A one-touch panic button sends an immediate priority alert to the control room. A built-in motion sensor can also detect a fall — if the device stays motionless and horizontal past a set time, it raises the alarm automatically.',
    ],
];

$use_cases = [
    'Warehouses & Logistics Hubs',
    'Industrial & Production Plants',
    'Corporate Campuses',
    'Critical Infrastructure',
    'Retail & Public Venues',
    'Construction Sites',
];
?>

<main class="security-page">

    <section class="security-hero">
        <div class="container">
            <h1>Prove Every Patrol Happened <br>— On Route, On Time</h1>
            <p>IN Security is a LoRa-based tracking solution that manages and verifies security patrol routes — track guards in real time against defined checkpoints and schedules, with no paperwork or guesswork.</p>
            <div class="cta-group">
                <a href="#how-it-works" class="btn btn-outline">See how it works</a>
                <a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer" class="btn btn-primary">Talk to us</a>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="security-how">
        <div class="container">
            <h2>IN Security: How It Works</h2>
            <p class="security-how-intro">Built around the IN Security tracker and a LoRaWAN base station, running entirely on your own network.</p>
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
                        <img src="<?php echo esc_url( $garda1_render_url ); ?>" alt="IN Security tracker render" class="device-usage-image">
                    <?php else : ?>
                        <div class="device-usage-placeholder">IN Security render<br><span>coming soon</span></div>
                    <?php endif; ?>
                </div>
                <div class="device-usage-content">
                    <h2>IN Security in a Guard's Pocket</h2>
                    <p class="security-how-intro">As simple to use as a phone — no training manual required.</p>
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
            <h2>Meet IN Security — Built for the Field</h2>
            <p class="section-subtitle">
                A single base station supports up to 200 trackers, and additional stations can be added to extend
                coverage across large or demanding sites. IN Security is currently a working prototype — its final form
                factor can be tailored to your specific requirements.
            </p>

            <div class="device-specs-grid">
                <?php foreach ( $device_specs as $spec ) : ?>
                    <div class="device-spec-card">
                        <div class="number"><?php echo esc_html( $spec['number'] ); ?></div>
                        <h3><?php echo esc_html( $spec['title'] ); ?></h3>
                        <p><?php echo esc_html( $spec['content'] ); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="security-how">
        <div class="container">
            <h2>Inside the Control Center</h2>
            <p class="security-how-intro">One piece of software, running on your own machine — no external server required.</p>
            <ul class="security-how-list">
                <li>Live View shows the ongoing patrol in real time — checkpoint by checkpoint, with the exact time each one was reached.</li>
                <li>Time and distance buffers are fully adjustable per route, so verification matches the realities of your site.</li>
                <li>Routes can be added, edited, or removed at any time as your facility or procedures change.</li>
                <li>The Archive lets you filter past patrols by device, date, or time range to review any historical route in detail.</li>
                <li>The software can be extended and integrated with other systems if your operation needs it.</li>
            </ul>
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
