<?php
// Biblioteka ikon SVG (tylko wnętrze <svg>, bez samego tagu) do wyboru z
// listy rozwijanej w ACF (pola "icon" na CPT-ach outcome/how_step) — zamiast
// pozwalać wpisać dowolny surowy SVG/HTML z wp-admina (ryzyko XSS przy
// nieescape'owanym echo w szablonie), wybiera się z ustalonej puli, a kod
// SVG jest zawsze ten sam, zaufany, zdefiniowany tutaj.
function in_security_icon_library() {
    return [
        'document'     => '<rect x="6" y="3" width="12" height="18" rx="2"/><path d="M9 8h6M9 12h6M9 16h3"/>',
        'check-circle' => '<circle cx="12" cy="12" r="9"/><path d="M8 12l3 3 5-6"/>',
        'bars'         => '<rect x="5" y="12" width="3" height="8"/><rect x="10.5" y="8" width="3" height="12"/><rect x="16" y="4" width="3" height="16"/>',
        'no-camera'    => '<path d="M4 8h2l1.5-2h9L18 8h2a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/><circle cx="12" cy="13.5" r="3.2"/><path d="M2 2l20 20"/>',
        'network'      => '<circle cx="6" cy="6" r="2"/><circle cx="18" cy="6" r="2"/><circle cx="12" cy="18" r="2"/><path d="M7.5 7.5L10.5 16.5M16.5 7.5L13.5 16.5M8 6h8"/>',
        'shield-heart' => '<path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6z"/><path d="M9.5 12c0-1 .8-1.8 1.8-1.8.6 0 1 .3 1.2.7.2-.4.6-.7 1.2-.7 1 0 1.8.8 1.8 1.8 0 1.4-1.5 2.6-3 3.6-1.5-1-3-2.2-3-3.6z"/>',
        'pin'          => '<path d="M12 21s7-7.58 7-12A7 7 0 1 0 5 9c0 4.42 7 12 7 12z"/><circle cx="12" cy="9" r="2.5"/>',
        'target'       => '<circle cx="12" cy="12" r="3"/><path d="M12 3v3M12 18v3M3 12h3M18 12h3"/>',
        'sync'         => '<path d="M8.5 15.5a5 5 0 0 1 0-7"/><path d="M15.5 8.5a5 5 0 0 1 0 7"/><path d="M5.5 18.5a9 9 0 0 1 0-13"/><path d="M18.5 5.5a9 9 0 0 1 0 13"/><circle cx="12" cy="12" r="1.6" fill="#0070f3" stroke="none"/>',
        'shield-check' => '<path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6z"/><path d="M9 12l2 2 4-4"/>',
        'chart-line'   => '<path d="M4 19V5M4 19h16"/><path d="M7 15l4-4 3 3 5-6"/>',
    ];
}

// Etykiety po polsku do listy wyboru w ACF (samo ACF field wymaga
// 'value => label' — patrz inc/acf-fields.php).
function in_security_icon_choices() {
    return [
        'document'     => 'Dokument',
        'check-circle' => 'Ptaszek w kółku',
        'bars'         => 'Wykres słupkowy',
        'no-camera'    => 'Przekreślona kamera',
        'network'      => 'Sieć/węzły',
        'shield-heart' => 'Tarcza z sercem',
        'pin'          => 'Pinezka mapy',
        'target'       => 'Cel/celownik',
        'sync'         => 'Synchronizacja',
        'shield-check' => 'Tarcza z ptaszkiem',
        'chart-line'   => 'Wykres liniowy',
    ];
}

function in_security_get_icon_svg( $slug ) {
    $icons = in_security_icon_library();

    return $icons[ $slug ] ?? $icons['check-circle'];
}
