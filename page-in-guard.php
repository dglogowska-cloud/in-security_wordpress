<?php
/*
 * Template Name: IN Guard 01 Product Card
 *
 * Zdjęcie mniejsze, osobno po lewej; po prawej kafelek z nazwą, tabelami
 * specyfikacji (nie pełne zdania) i dwa linki na końcu.
 * To osobny, zwięzły zestaw danych — nie to samo co przystępne, opisowe
 * in_guard_specs() z functions.php używane w sekcji "The Hardware".
 */
get_header();

$render_path = get_template_directory() . '/assets/images/in-guard-side-render.png';
$render_url  = get_template_directory_uri() . '/assets/images/in-guard-side-render.png';

$charger_path = get_template_directory() . '/assets/images/in-guard-charger.png';
$charger_url  = get_template_directory_uri() . '/assets/images/in-guard-charger.png';

// [PLACEHOLDER] — uzupełnić konkretami o stacji dokującej.
$charger_points = [
    'Single device: 5V ±5%, 500mA',
    'Docking station: 5V ±5%, 1500mA',
];

$spec_table = [
    [ 'Connectivity', 'LoRaWAN, 868 MHz ISM band, AES-128 encryption' ],
    [ 'Positioning', 'Multi-constellation GNSS (GPS, GLONASS, Galileo, BeiDou)' ],
    [ 'Timestamp Accuracy', 'Derived directly from GNSS — precise, satellite-synchronized time on every recorded point, used for analytics instead of server receive time' ],
    [ 'Update Interval', 'Every 15 seconds (customizable)' ],
    [ 'On-Device Storage', 'Up to 500 points' ],
    [ 'Battery Life', 'Up to 8 hours of continuous patrol use' ],
    [ 'Charging', 'USB-C, or docking station (3 units at once)' ],
    [ 'Single Button', 'Power on; short press sends a priority alarm to the control room; long press (~2s) powers off — reset device' ],
    [ 'Fall Detection', 'Auto-alert after 20s motionless & horizontal, repeats every 60s until resolved — disabled while charging' ],
    [ 'Carry Recommendation', 'User pocket, or clipped to a lanyard; avoid metal shielding for the best signal' ],
    [ 'Operating Temperature', '-5°C to +40°C' ],
    [ 'Base Station Link', 'Wi-Fi, LTE, or wired Ethernet — fully on-premise' ],
    [ 'Map Data', 'Served entirely offline — no internet connection required' ],
    [ 'Checkpoint Verification', 'Every visit automatically classified as early, on-time, late, or missed' ],
    [ 'Scalability', 'Up to 200 trackers per base station; additional base stations can be added to cover more terrain' ],
    [ 'Status Indicator', 'Built-in LED shows the device\'s current status' ],
];
?>

<main class="in-guard-page">
    <section class="in-guard-section">
        <div class="container">
            <div class="in-guard-layout">
                <div class="in-guard-media">
                    <?php if ( file_exists( $render_path ) ) : ?>
                        <img src="<?php echo esc_url( $render_url ); ?>" alt="IN Guard 01 tracker" class="in-guard-render">
                    <?php else : ?>
                        <div class="in-guard-render-placeholder">IN Guard 01 render<br><span>coming soon</span></div>
                    <?php endif; ?>
                </div>

                <div class="in-guard-content">
                    <div class="in-guard-tile">
                        <h1><?php the_title(); ?></h1>

                        <table class="in-guard-spec-table">
                            <?php foreach ( $spec_table as $row ) : ?>
                                <tr>
                                    <th><?php echo esc_html( $row[0] ); ?></th>
                                    <td><?php echo esc_html( $row[1] ); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>

            <?php if ( file_exists( $charger_path ) ) : ?>
                <div class="in-guard-accessory">
                    <img src="<?php echo esc_url( $charger_url ); ?>" alt="IN Guard 01 docking station" class="in-guard-accessory-image">
                    <div class="in-guard-accessory-body">
                        <p><strong>Charging:</strong> individually (USB-C), or use a docking station for simultaneous charging of up to 3 IN Guard 01 units.</p>
                        <ul class="in-guard-accessory-list">
                            <?php foreach ( $charger_points as $point ) : ?>
                                <li><?php echo esc_html( $point ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <div class="in-guard-bottom-links">
                <a href="<?php echo esc_url( home_url( '/#how-it-works' ) ); ?>">Read how it works</a>
                <a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer">Get in touch</a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
