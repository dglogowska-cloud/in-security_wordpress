<?php
/*
 * Treść in-security — LoRa-based tracking do weryfikacji obchodów ochrony.
 * Kafelki mają tymczasowe grafiki wygenerowane AI (assets/images/*.jpg) —
 * podmienić na zrzuty ekranu z aplikacji, gdy będą dostępne.
 */
get_header();

$tiles_dir = get_template_directory_uri() . '/assets/images/';

$tiles = [
    [
        'title'   => 'Checkpoint & Schedule Configuration',
        'image'   => $tiles_dir . 'checkpoints-configuration.jpg',
        'content' => 'Define the checkpoints a patrol route must cover across your facility and assign the exact time each one should be reached. Adjust time and distance buffers to match your site\'s layout and security requirements.',
    ],
    [
        'title'   => 'Automatic Patrol Verification',
        'image'   => $tiles_dir . 'patrol-verification.jpg',
        'content' => 'Confirm whether a patrol was completed — and completed on time — without manual check-ins or paper logs. Every checkpoint is verified against real tracker data from the field.',
    ],
    [
        'title'   => 'Statistics & Route Optimization',
        'image'   => $tiles_dir . 'statistics.jpg',
        'content' => 'Analyze historical patrol data to spot missed checkpoints, recurring delays or inefficient routes, and refine schedules and processes based on real-world performance.',
    ],
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
            <p class="security-how-intro">Built on in-house LoRa tracking hardware and software.</p>
            <ul class="security-how-list">
                <li>Checkpoints are defined across the facility that a patrol route must cover.</li>
                <li>Each checkpoint gets a precise time window, with configurable time and distance buffers.</li>
                <li>A LoRa tracker carried by the patrolling employee reports position in real time to the central system.</li>
                <li>The system automatically verifies whether the route was completed, and whether every checkpoint was reached on time.</li>
                <li>Administrators review statistics and optimize routes or processes using historical patrol data.</li>
            </ul>
        </div>
    </section>

    <section class="security-tiles">
        <div class="container">
            <div class="security-tile-grid">
                <?php foreach ( $tiles as $tile ) : ?>
                    <div class="security-tile">
                        <?php if ( $tile['image'] ) : ?>
                            <img src="<?php echo esc_url( $tile['image'] ); ?>" alt="<?php echo esc_attr( $tile['title'] ); ?>" class="security-tile-image">
                        <?php endif; ?>
                        <h3><?php echo esc_html( $tile['title'] ); ?></h3>
                        <p><?php echo esc_html( $tile['content'] ); ?></p>
                    </div>
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
