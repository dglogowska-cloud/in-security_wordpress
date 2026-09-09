<?php
/*
 * Template Name: IN Sense Product Card
 *
 * Analogiczna do page-in-guard.php: zdjęcie po lewej, kafelek z nazwą i
 * tabelą specyfikacji po prawej, linki na dole. Markup celowo reużywa klas
 * .in-guard-* (te same style pasują 1:1, więc nie duplikujemy CSS pod nową
 * nazwę — dokładnie ten sam wzorzec zastosowany już w in-vitals/page-in-sense.php).
 *
 * Bez sekcji .in-guard-accessory (ładowarka) — IN Sense to stacjonarny
 * czujnik montowany na stałe, nie noszone, bateryjne urządzenie jak IN Guard.
 *
 * Tabela specyfikacji nie zawiera parametrów zasilania/IP ratingu — nie mamy
 * jeszcze twardych liczb dla tych pól (ten sam brak flagowany w in-vitals'
 * wersji tej karty). Do uzupełnienia, gdy będą dostępne.
 */
get_header();

// Znajdujemy stronę po przypisanym szablonie, nie po hardkodowanym slugu —
// ta karta produktu może zostać przeniesiona/zmieniona bez psucia linków do niej.
$render_path = get_template_directory() . '/assets/images/in-sense-render.png';
$render_url  = get_template_directory_uri() . '/assets/images/in-sense-render.png';

$spec_table = [
    [ 'Measurement Principle', 'Radar-based distance measurement to the body, detecting chest micro-movements associated with breathing' ],
    [ 'Sensing Range', '1-3 meters' ],
    [ 'Guard Contact', 'None — no wearable bands, no cables on the guard\'s body' ],
    [ 'Visual Privacy', 'No cameras, no microphones, no image analysis — nothing is ever recorded or watched' ],
    [ 'Mounting Options', 'Ceiling mount, boom arm, or mobile stand — moves between booths or posts' ],
    [ 'Data Transmission', 'Wireless (Wi-Fi) to the Control Center' ],
    [ 'Alert Behavior', 'Graduated — a discreet wake-up signal first, immediate escalation to the Control Center on sudden movement or a suspected fall' ],
    [ 'Shift Handover Detection', 'Registers when shifts change hands, and flags it if anyone unexpected enters the post' ],
    [ 'Compared to Motion Sensors', 'More reliable than PIR sensors, which lose accuracy without large movement and are easy to defeat' ],
    [ 'Processing', '100% on-premise — no cloud, no external server' ],
    [ 'Monitoring Coverage', 'Continuous, one sensor per post' ],
    [ 'Integration Roadmap', 'Machine-learning-based fatigue prediction and behavior profiling' ],
    [ 'Ideal For', 'Guard booths, gatehouses, monitoring and control rooms, critical infrastructure posts' ],
];
?>

<main class="in-guard-page">
    <section class="in-guard-section">
        <div class="container">
            <div class="in-guard-layout">
                <div class="in-guard-media">
                    <?php if ( file_exists( $render_path ) ) : ?>
                        <img src="<?php echo esc_url( $render_url ); ?>" alt="IN Sense sensor" class="in-guard-render">
                    <?php else : ?>
                        <div class="in-guard-render-placeholder">IN Sense render<br><span>coming soon</span></div>
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

            <div class="in-guard-bottom-links">
                <a href="<?php echo esc_url( home_url( '/#meet-in-sense' ) ); ?>">Read how it works</a>
                <a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer">Get in touch</a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
