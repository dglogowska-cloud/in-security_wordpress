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
 *
 * JĘZYK (2026-09-09): stringi idą przez in_security_t() (inc/i18n.php),
 * tak samo jak front-page.php.
 */
get_header();

// Znajdujemy stronę po przypisanym szablonie, nie po hardkodowanym slugu —
// ta karta produktu może zostać przeniesiona/zmieniona bez psucia linków do niej.
$render_path = get_template_directory() . '/assets/images/in-sense-render.png';
$render_url  = get_template_directory_uri() . '/assets/images/in-sense-render.png';

$spec_table = [
    [ in_security_t( 'sense_card_spec_1_label', get_the_ID() ), in_security_t( 'sense_card_spec_1_value', get_the_ID() ) ],
    [ in_security_t( 'sense_card_spec_2_label', get_the_ID() ), in_security_t( 'sense_card_spec_2_value', get_the_ID() ) ],
    [ in_security_t( 'sense_card_spec_3_label', get_the_ID() ), in_security_t( 'sense_card_spec_3_value', get_the_ID() ) ],
    [ in_security_t( 'sense_card_spec_4_label', get_the_ID() ), in_security_t( 'sense_card_spec_4_value', get_the_ID() ) ],
    [ in_security_t( 'sense_card_spec_5_label', get_the_ID() ), in_security_t( 'sense_card_spec_5_value', get_the_ID() ) ],
    [ in_security_t( 'sense_card_spec_6_label', get_the_ID() ), in_security_t( 'sense_card_spec_6_value', get_the_ID() ) ],
    [ in_security_t( 'sense_card_spec_7_label', get_the_ID() ), in_security_t( 'sense_card_spec_7_value', get_the_ID() ) ],
    [ in_security_t( 'sense_card_spec_8_label', get_the_ID() ), in_security_t( 'sense_card_spec_8_value', get_the_ID() ) ],
    [ in_security_t( 'sense_card_spec_9_label', get_the_ID() ), in_security_t( 'sense_card_spec_9_value', get_the_ID() ) ],
    [ in_security_t( 'sense_card_spec_10_label', get_the_ID() ), in_security_t( 'sense_card_spec_10_value', get_the_ID() ) ],
    [ in_security_t( 'sense_card_spec_11_label', get_the_ID() ), in_security_t( 'sense_card_spec_11_value', get_the_ID() ) ],
    [ in_security_t( 'sense_card_spec_12_label', get_the_ID() ), in_security_t( 'sense_card_spec_12_value', get_the_ID() ) ],
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
                        <div class="in-guard-render-placeholder"><?php echo esc_html( in_security_t( 'label_in_sense_render', get_the_ID() ) ); ?><br><span><?php echo esc_html( in_security_t( 'label_coming_soon' ) ); ?></span></div>
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
                <a href="<?php echo esc_url( home_url( '/#meet-in-sense' ) ); ?>"><?php echo esc_html( in_security_t( 'product_card_link_how_it_works' ) ); ?></a>
                <a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer"><?php echo esc_html( in_security_t( 'product_card_link_contact' ) ); ?></a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
