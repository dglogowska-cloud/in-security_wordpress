<?php
// Prowizoryczny przełącznik języka PL/EN dla etapu przed podpięciem treści
// do WordPressa — ten sam wzorzec co na indoornavi.me (inc/i18n.php tamtego
// motywu): stringi są na razie hardkodowane w in_security_strings() poniżej,
// docelowo (Etap 3 — treść zarządzana z wp-admina) in_security_t() ma już
// wbudowaną ścieżkę do pól ACF ("{$key}_en"/"{$key}_pl") — gdy takie pole
// istnieje i ma wartość, wygrywa z hardkodowanym słownikiem, więc podpięcie
// ACF-a nie będzie wymagało zmiany ani jednego wywołania in_security_t() w
// szablonach, tylko dodanie pól.
//
// Parametr URL to celowo "site_lang", nie "lang" — z tych samych powodów co
// na indoornavi.me: unika kolizji, gdyby kiedyś obok trafił tu Polylang albo
// inna wtyczka wielojęzyczna zajmująca "?lang=".
//
// in-security.me nie ma własnego bloga (link "Blog" w menu prowadzi
// zewnętrznie na indoornavi.me/blog/), więc — w odróżnieniu od indoornavi.me —
// nie ma tu w ogóle kontekstu blogowego/Polylang do obsługi; to uproszczona
// wersja tego samego mechanizmu.

define( 'IN_SECURITY_LANGUAGES', [ 'en', 'pl' ] );

function in_security_get_language() {
    if ( isset( $_GET['site_lang'] ) && in_array( $_GET['site_lang'], IN_SECURITY_LANGUAGES, true ) ) {
        return $_GET['site_lang'];
    }

    if ( isset( $_COOKIE['in_security_lang'] ) && in_array( $_COOKIE['in_security_lang'], IN_SECURITY_LANGUAGES, true ) ) {
        return $_COOKIE['in_security_lang'];
    }

    return 'en';
}

function in_security_maybe_set_language_cookie() {
    if ( isset( $_GET['site_lang'] ) && in_array( $_GET['site_lang'], IN_SECURITY_LANGUAGES, true ) ) {
        setcookie( 'in_security_lang', $_GET['site_lang'], time() + YEAR_IN_SECONDS, '/' );
    }
}
add_action( 'init', 'in_security_maybe_set_language_cookie' );

// $post_id domyślnie to front page — podanie innego ID (np. get_the_ID() na
// page-in-guard.php/page-in-sense.php) pozwoli w przyszłości czytać pola
// ACF przypięte do tamtej konkretnej strony, nie do strony głównej.
function in_security_t( $key, $post_id = null ) {
    $lang = in_security_get_language();

    if ( function_exists( 'get_field' ) ) {
        $post_id = $post_id ?? (int) get_option( 'page_on_front' );

        if ( $post_id ) {
            $value = get_field( $key . '_' . $lang, $post_id );

            if ( ! empty( $value ) ) {
                return $value;
            }
        }
    }

    $strings = in_security_strings();

    return $strings[ $lang ][ $key ] ?? $strings['en'][ $key ] ?? $key;
}

function in_security_strings() {
    return [
        'en' => [
            // Nav / footer chrome
            'nav_home'              => 'Home',
            'nav_product_card'      => 'Product Card',
            'nav_in_guard'          => 'IN Guard',
            'nav_in_sense'          => 'IN Sense',
            'nav_other_products'    => 'Other products',
            'nav_contact'           => 'Contact',
            'nav_blog'              => 'Blog',
            'footer_rights'         => 'IndoorNavi. All rights reserved.',
            'footer_privacy_policy' => 'Privacy Policy',
            'footer_cookie_policy'  => 'Cookie Policy',

            // Shared labels (placeholders reused across sections)
            'label_coming_soon'           => 'coming soon',
            'label_screenshot_coming_soon' => 'screenshot coming soon',
            'label_in_guard_render'       => 'IN Guard render',
            'label_in_sense_render'       => 'IN Sense render',
            'label_guard_booth_photo'     => 'Guard booth photo',
            'label_sample_chart'          => 'Sample measurement chart',
            'label_step_prefix'           => 'Step',

            // Hero
            'hero_heading_line1' => 'Every Patrol Proven.',
            'hero_heading_line2' => 'Every Post Watched.',
            'hero_subtitle'      => '<strong>IN Security</strong> brings patrol verification and post monitoring together in one platform — so your entire security operation runs from a single <strong>Control Center</strong>.',
            'hero_cta_read_more' => 'Read more',
            'hero_cta_talk_to_us' => 'Talk to us',

            // Hub ("Two Tools, One Platform")
            'hub_heading'        => 'Two Tools, One Platform',
            'hub_subtitle'       => 'Two purpose-built devices, each solving a different problem — both able to feed into a single Control Center that can bring their handling together.',
            'hub_guard_content'  => 'Verifies that <strong>patrol routes</strong> are actually walked, checkpoint by checkpoint, on time — with a full, timestamped record of every round.',
            'hub_sense_content'  => 'Watches over guards holding a <strong>stationary post</strong>, automatically flagging it the moment their attention drifts into sleep on duty.',
            'hub_cta_template'   => 'How %s works',

            // IN Guard in a Guard's Pocket
            'guard_pocket_heading' => "IN Guard in a Guard's Pocket",
            'guard_pocket_intro'   => 'No training manual required — just turn it on and go.',
            'guard_pocket_point_1' => '<strong>Start of shift:</strong> press the power button, put it in the pocket, and start walking the route — that\'s the entire setup.',
            'guard_pocket_point_2' => '<strong>During the patrol:</strong> IN Guard quietly tracks itself in the background, with nothing for the guard to check or log by hand.',
            'guard_pocket_point_3' => '<strong>If something feels wrong:</strong> one press of the button sends an immediate alarm to the control room — no radio, no phone call, no hesitation.',
            'guard_pocket_point_4' => '<strong>If a guard goes down:</strong> IN Guard notices on its own and raises the alarm automatically, even if they can\'t reach the button.',
            'guard_pocket_point_5' => '<strong>End of shift:</strong> drop it in the charger, and it\'s ready to go for the next patrol.',

            // IN Guard: How It Works
            'guard_how_heading'  => 'IN Guard: How It Works',
            'guard_how_intro'    => 'Built around the IN Guard tracker and a LoRaWAN base station, running entirely on your own network.',
            'step_1_title'       => 'Define Checkpoints',
            'step_1_content'     => 'Set the checkpoints a patrol route must cover, each with a target time window, an allowed time deviation, and a distance radius.',
            'step_2_title'       => 'Track in Real Time',
            'step_2_content'     => 'As the guard walks the route, IN Guard continuously records its exact position in the background.',
            'step_3_title'       => 'Sync Automatically',
            'step_3_content'     => 'That position data reaches the base station on its own — streamed live when in range, or delivered all at once the moment the guard reconnects.',
            'step_4_title'       => 'Verify Automatically',
            'step_4_content'     => 'The Control Center compares the recorded route against every checkpoint, automatically flagging missed, late, or off-route visits.',
            'step_5_title'       => 'Review & Optimize',
            'step_5_content'     => 'Supervisors watch patrols live or use the Archive to review history, spot bottlenecks, and refine routes over time.',

            // IN Guard: The Hardware
            'guard_hardware_heading'      => 'IN Guard: The Hardware',
            'guard_hardware_subtitle'     => 'A single base station supports up to 200 trackers, and additional stations can be added to extend coverage across large or demanding sites. IN Guard is currently a working prototype — its final form factor can be tailored to your specific requirements.',
            'guard_spec_1_title'          => 'Long-Range, Encrypted & Fully On-Premise',
            'guard_spec_1_content'        => 'IN Guard talks to its base station over the <strong>868 MHz ISM band using LoRaWAN, secured end to end with AES-128 encryption</strong> — only devices explicitly registered to your system can ever transmit. The base station connects only to your own control PC (Wi-Fi, LTE, or wired Ethernet), so <strong>patrol data never has to leave your network</strong>.',
            'guard_spec_2_title'          => 'Precise, Continuous Positioning',
            'guard_spec_2_content'        => 'A built-in multi-constellation GNSS receiver (GPS, GLONASS, Galileo, BeiDou) logs the tracker\'s exact position <strong>every 15 seconds</strong>, storing up to <strong>500 points on-device</strong> and uploading them the moment it\'s back in range of the base station.',
            'guard_spec_3_title'          => 'Built for a Full Shift',
            'guard_spec_3_content'        => 'An onboard battery keeps IN Guard running for <strong>several hours of continuous patrol work</strong>. Recharge it with a standard USB-C cable, or use the <strong>dedicated docking station that charges three units at once</strong>.',
            'guard_spec_4_title'          => 'Two Layers of Guard Safety',
            'guard_spec_4_content'        => 'A <strong>one-touch panic button</strong> sends an immediate priority alert to the control room. A built-in motion sensor also watches for falls — if the device stays motionless and horizontal past a set time, <strong>the control room is alerted automatically</strong>.',
            'guard_hardware_footnote_cta' => 'See full IN Guard spec sheet',

            // Inside the Control Center
            'control_center_heading'        => 'Inside the Control Center',
            'control_center_intro'          => 'One piece of software, running on your own machine — no external server, no cloud dependency, and even the map works fully offline. The same Control Center will also surface IN Sense alerts, right alongside your patrol data — meet IN Sense next.',
            'feature_1_tag'                 => 'Live Tracking',
            'feature_1_title'               => 'Live View',
            'feature_1_content'             => 'Select any tracker from the list and watch its patrol unfold in real time — checkpoint by checkpoint, with the exact arrival time for each one. Time and distance buffers are fully adjustable per route, so verification matches the realities of your site.',
            'feature_2_tag'                 => 'Easy to Manage',
            'feature_2_title'               => 'Route & Checkpoint Editor',
            'feature_2_content'             => 'Add, edit, or remove checkpoints and entire routes in a few clicks, no developer support needed — as your facility layout or procedures change, the system changes with you.',
            'feature_3_tag'                 => 'Historical Data',
            'feature_3_title'               => 'Archive & Analytics',
            'feature_3_content'             => 'Every checkpoint is automatically classified as early, on-time, late, or missed. Filter past patrols by device, date, or time range to dig into the details — spot bottlenecks, recurring delays, or danger zones, and use the data to optimize future routes.',
            'control_center_footnote_text'  => 'The software can also be extended and integrated with other systems if your operation needs it.',
            'control_center_footnote_cta'   => "Let's talk about your challenges",

            // Meet IN Sense
            'meet_sense_heading' => 'Meet IN Sense',
            'meet_sense_intro'   => 'The sensor doing the work: small, unobtrusive, and built to stay out of the way of the job.',
            'sense_point_1'      => 'Fits any post layout: <strong>ceiling mount, boom arm, or a mobile stand</strong> you can move between booths.',
            'sense_point_2'      => '<strong>No cameras, no wearables</strong> — just a compact unit doing its job quietly in the background.',
            'sense_point_3'      => 'Positioned just above or beside the guard\'s chair — <strong>without ever requiring anything worn on the body</strong>.',

            // IN Sense: How It Works
            'sense_how_heading'          => 'IN Sense: How It Works',
            'sense_how_intro'            => 'A radar sensor that watches over a stationary post — no cameras, no wearables.',
            'sense_how_point_1'          => '<strong>Works at a distance (1-3 m):</strong> no wearable required on the guard.',
            'sense_how_point_2'          => '<strong>Passive breathing measurement:</strong> the sensor tracks chest micro-movements in the background, confirming presence and alertness even when the guard is stationary.',
            'sense_how_point_3'          => '<strong>Shift handover & third-party detection:</strong> the system registers when shifts change hands, and flags it if anyone unexpected enters the post.',
            'sense_how_point_4'          => '<strong>Smart, graduated alerts:</strong> first a discreet wake-up signal for the guard, then immediate escalation to the Control Center if it doesn\'t resolve.',
            'sense_how_point_5'          => '<strong>Schedule optimization:</strong> alertness-dip data helps plan shift rotations and breaks more effectively on demanding night shifts.',
            'sense_hardware_footnote_cta' => 'See full IN Sense spec sheet',

            // From Alert to Drowsy (sample chart)
            'chart_heading'      => 'From Alert to Drowsy: Captured in a Single Chart',
            'chart_intro'        => 'A real breathing measurement, recorded end to end by IN Sense.',
            'chart_point_1'      => 'This <strong>30-minute record</strong> shows a guard settling into a stationary post, with the sensor placed <strong>1.5 meters</strong> away.',
            'chart_point_2'      => 'After several minutes, the <strong>breathing rate noticeably slows down</strong> as alertness drops.',
            'chart_point_3'      => 'IN Sense automatically flags this as a <strong>graduated alert</strong> — first a discreet wake-up signal, no supervisor watching a screen required.',
            'chart_footnote_text' => 'IN Sense can be added to any stationary post — gatehouse, booth, or control room — without disrupting how your team already works.',
            'chart_footnote_cta'  => 'Talk to us about your posts',

            // Why It Pays Off
            'outcomes_heading'   => 'Why It Pays Off',
            'outcomes_subtitle'  => 'Beyond verification — measurable impact on compliance, coverage, and cost.',
            'outcome_1_title'    => 'Audit-Ready Compliance',
            'outcome_1_content'  => 'Every patrol and every stationary post is timestamped and verified automatically — a ready-made record for audits, clients, or insurance.',
            'outcome_2_title'    => 'Nothing Falls Through the Cracks',
            'outcome_2_content'  => 'A missed checkpoint is flagged immediately. At a stationary post, sudden movement, a struggle, or a suspected fall triggers an instant alert.',
            'outcome_3_title'    => 'Smarter Staffing Decisions',
            'outcome_3_content'  => 'Real patrol data — not guesswork — shows you where to add coverage and where routes can be trimmed, raising efficiency without adding headcount.',
            'outcome_4_title'    => 'Complete Anonymity',
            'outcome_4_content'  => 'No cameras, no image analysis — across both tools, guards are monitored for presence and alertness, never watched or recorded like on video.',
            'outcome_5_title'    => 'One Platform, Built to Extend',
            'outcome_5_content'  => 'IN Sense alerts and IN Guard patrol data may land in the same Control Center, which can also integrate with your other security systems.',
            'outcome_6_title'    => 'Lower Staff Turnover',
            'outcome_6_content'  => 'The SOS button and fall detection give guards constant on-the-job safety — support that helps keep good people in the role.',

            // Where IN Security Fits
            'services_heading'  => 'Where IN Security Fits',
            'services_subtitle' => 'Anywhere a patrol route needs to be walked, or a post needs to be watched.',
            'use_case_1'  => 'Warehouses & Logistics Hubs',
            'use_case_2'  => 'Industrial & Production Plants',
            'use_case_3'  => 'Corporate Campuses',
            'use_case_4'  => 'Critical Infrastructure',
            'use_case_5'  => 'Retail & Public Venues',
            'use_case_6'  => 'Construction Sites',
            'use_case_7'  => 'Data Centers',
            'use_case_8'  => 'Airports & Transit Hubs',
            'use_case_9'  => 'Healthcare Facilities',
            'use_case_10' => 'Educational Campuses',
            'use_case_11' => 'Solar & Wind Farms',
            'use_case_12' => 'Ports & Maritime Terminals',
            'use_case_13' => 'Guard Booths & Gatehouses',
            'use_case_14' => 'Monitoring & Control Rooms',

            // Final CTA
            'final_cta_heading' => 'Secure Every Patrol. Watch Every Post.',
            'final_cta_text'    => 'Talk to our team about bringing patrol tracking, post monitoring, and verification to your facility.',
            'final_cta_button'  => 'Book a Consultation',

            // page-in-guard.php / page-in-sense.php — karty produktów
            'product_card_link_how_it_works' => 'Read how it works',
            'product_card_link_contact'      => 'Get in touch',

            'guard_card_render_placeholder' => 'IN Guard 01 render',
            'guard_card_spec_1_label'  => 'Connectivity',
            'guard_card_spec_1_value'  => 'LoRaWAN, 868 MHz ISM band, AES-128 encryption',
            'guard_card_spec_2_label'  => 'Positioning',
            'guard_card_spec_2_value'  => 'Multi-constellation GNSS (GPS, GLONASS, Galileo, BeiDou)',
            'guard_card_spec_3_label'  => 'Timestamp Accuracy',
            'guard_card_spec_3_value'  => 'Derived directly from GNSS — precise, satellite-synchronized time on every recorded point, used for analytics instead of server receive time',
            'guard_card_spec_4_label'  => 'Update Interval',
            'guard_card_spec_4_value'  => 'Every 15 seconds (customizable)',
            'guard_card_spec_5_label'  => 'On-Device Storage',
            'guard_card_spec_5_value'  => 'Up to 500 points',
            'guard_card_spec_6_label'  => 'Battery Life',
            'guard_card_spec_6_value'  => 'Up to 8 hours of continuous patrol use',
            'guard_card_spec_7_label'  => 'Charging',
            'guard_card_spec_7_value'  => 'USB-C, or docking station (3 units at once)',
            'guard_card_spec_8_label'  => 'Single Button',
            'guard_card_spec_8_value'  => 'Power on; short press sends a priority alarm to the control room; long press (~2s) powers off — reset device',
            'guard_card_spec_9_label'  => 'Fall Detection',
            'guard_card_spec_9_value'  => 'Auto-alert after 20s motionless & horizontal, repeats every 60s until resolved — disabled while charging',
            'guard_card_spec_10_label' => 'Carry Recommendation',
            'guard_card_spec_10_value' => 'User pocket, or clipped to a lanyard; avoid metal shielding for the best signal',
            'guard_card_spec_11_label' => 'Operating Temperature',
            'guard_card_spec_11_value' => '-5°C to +40°C',
            'guard_card_spec_12_label' => 'Base Station Link',
            'guard_card_spec_12_value' => 'Wi-Fi, LTE, or wired Ethernet — fully on-premise',
            'guard_card_spec_13_label' => 'Map Data',
            'guard_card_spec_13_value' => 'Served entirely offline — no internet connection required',
            'guard_card_spec_14_label' => 'Checkpoint Verification',
            'guard_card_spec_14_value' => 'Every visit automatically classified as early, on-time, late, or missed',
            'guard_card_spec_15_label' => 'Scalability',
            'guard_card_spec_15_value' => 'Up to 200 trackers per base station; additional base stations can be added to cover more terrain',
            'guard_card_spec_16_label' => 'Status Indicator',
            'guard_card_spec_16_value' => 'Built-in LED shows the device\'s current status',
            'guard_card_charger_intro'   => '<strong>Charging:</strong> individually (USB-C), or use a docking station for simultaneous charging of up to 3 IN Guard units.',
            'guard_card_charger_point_1' => 'Single device: 5V ±5%, 500mA',
            'guard_card_charger_point_2' => 'Docking station: 5V ±5%, 1500mA',

            'sense_card_spec_1_label'  => 'Measurement Principle',
            'sense_card_spec_1_value'  => 'Radar-based distance measurement to the body, detecting chest micro-movements associated with breathing',
            'sense_card_spec_2_label'  => 'Sensing Range',
            'sense_card_spec_2_value'  => '1-3 meters',
            'sense_card_spec_3_label'  => 'Guard Contact',
            'sense_card_spec_3_value'  => 'None — no wearable bands, no cables on the guard\'s body',
            'sense_card_spec_4_label'  => 'Visual Privacy',
            'sense_card_spec_4_value'  => 'No cameras, no microphones, no image analysis — nothing is ever recorded or watched',
            'sense_card_spec_5_label'  => 'Mounting Options',
            'sense_card_spec_5_value'  => 'Ceiling mount, boom arm, or mobile stand — moves between booths or posts',
            'sense_card_spec_6_label'  => 'Data Transmission',
            'sense_card_spec_6_value'  => 'Wireless (Wi-Fi) to the Control Center',
            'sense_card_spec_7_label'  => 'Alert Behavior',
            'sense_card_spec_7_value'  => 'Graduated — a discreet wake-up signal first, immediate escalation to the Control Center on sudden movement or a suspected fall',
            'sense_card_spec_8_label'  => 'Shift Handover Detection',
            'sense_card_spec_8_value'  => 'Registers when shifts change hands, and flags it if anyone unexpected enters the post',
            'sense_card_spec_9_label'  => 'Compared to Motion Sensors',
            'sense_card_spec_9_value'  => 'More reliable than PIR sensors, which lose accuracy without large movement and are easy to defeat',
            'sense_card_spec_10_label' => 'Processing',
            'sense_card_spec_10_value' => '100% on-premise — no cloud, no external server',
            'sense_card_spec_11_label' => 'Monitoring Coverage',
            'sense_card_spec_11_value' => 'Continuous, one sensor per post',
            'sense_card_spec_12_label' => 'Integration Roadmap',
            'sense_card_spec_12_value' => 'Machine-learning-based fatigue prediction and behavior profiling',
        ],
        'pl' => [
            // Nav / footer chrome
            'nav_home'              => 'Home',
            'nav_product_card'      => 'Karta produktu',
            'nav_in_guard'          => 'IN Guard',
            'nav_in_sense'          => 'IN Sense',
            'nav_other_products'    => 'Pozostałe usługi',
            'nav_contact'           => 'Kontakt',
            'nav_blog'              => 'Blog',
            'footer_rights'         => 'IndoorNavi. Wszelkie prawa zastrzeżone.',
            'footer_privacy_policy' => 'Polityka prywatności',
            'footer_cookie_policy'  => 'Polityka cookies',

            // Shared labels (placeholders reused across sections)
            'label_coming_soon'           => 'wkrótce',
            'label_screenshot_coming_soon' => 'zrzut ekranu wkrótce',
            'label_in_guard_render'       => 'Render IN Guard',
            'label_in_sense_render'       => 'Render IN Sense',
            'label_guard_booth_photo'     => 'Zdjęcie budki ochroniarskiej',
            'label_sample_chart'          => 'Przykładowy wykres pomiaru',
            'label_step_prefix'           => 'Krok',

            // Hero
            'hero_heading_line1' => 'Każdy obchód potwierdzony.',
            'hero_heading_line2' => 'Każdy posterunek pod kontrolą.',
            'hero_subtitle'      => '<strong>IN Security</strong> łączy weryfikację obchodów i monitoring posterunków w jednej platformie — dzięki czemu cała ochrona obiektu działa z poziomu jednego <strong>Centrum Sterowania</strong>.',
            'hero_cta_read_more' => 'Dowiedz się więcej',
            'hero_cta_talk_to_us' => 'Skontaktuj się',

            // Hub ("Two Tools, One Platform")
            'hub_heading'        => 'Dwa narzędzia, jeden panel sterowania',
            'hub_subtitle'       => 'Dwa urządzenia, każde odpowiadające na różne wyzwania — zarządzane z poziomu jednej, zintegrowanej platformy.',
            'hub_guard_content'  => 'Potwierdza, że <strong>trasa obchodu</strong> została faktycznie przebyta, punkt po punkcie, na czas — z pełnym, oznaczonym czasowo zapisem każdego patrolu.',
            'hub_sense_content'  => 'Czuwa nad strażnikami na <strong>stałym posterunku</strong>, automatycznie sygnalizując moment, w którym ich czujność przechodzi w sen.',
            'hub_cta_template'   => 'Jak działa %s',

            // IN Guard w kieszeni strażnika
            'guard_pocket_heading' => 'IN Guard w kieszeni strażnika',
            'guard_pocket_intro'   => 'Bez instrukcji obsługi — wystarczy włączyć i ruszać.',
            'guard_pocket_point_1' => '<strong>Początek zmiany:</strong> uruchom przyciskiem, włóż do kieszeni i zacznij obchód — to cała konfiguracja.',
            'guard_pocket_point_2' => '<strong>Podczas obchodu:</strong> IN Guard śledzi trasę samodzielnie w tle — strażnik nie musi niczego sprawdzać ani zapisywać ręcznie.',
            'guard_pocket_point_3' => '<strong>Gdy coś jest nie tak:</strong> jedno naciśnięcie przycisku wysyła natychmiastowy alarm do dyżurki — bez radia, bez telefonu, bez wahania.',
            'guard_pocket_point_4' => '<strong>Jeśli strażnik upadnie:</strong> IN Guard wykrywa upadek i automatycznie wysyła alarm, nawet jeśli pracownik nie ma możliwości nacisnąć przycisku.',
            'guard_pocket_point_5' => '<strong>Koniec zmiany:</strong> odłóż na ładowarkę — będzie gotowy na kolejny obchód.',

            // IN Guard: jak to działa
            'guard_how_heading'  => 'IN Guard: jak to działa',
            'guard_how_intro'    => 'Rozwiązanie zbudowane wokół trackera IN Guard i stacji bazowej LoRaWAN, działające w całości w Twojej własnej sieci.',
            'step_1_title'       => 'Zdefiniuj punkty kontrolne',
            'step_1_content'     => 'Ustal punkty, które musi obejmować trasa obchodu — z oknem czasowym, dopuszczalnym odchyleniem i promieniem odległości.',
            'step_2_title'       => 'Śledź w czasie rzeczywistym',
            'step_2_content'     => 'Gdy strażnik pokonuje trasę, IN Guard w tle nieprzerwanie rejestruje jego dokładną pozycję.',
            'step_3_title'       => 'Synchronizuj automatycznie',
            'step_3_content'     => 'Dane pozycji trafiają do stacji bazowej same — na żywo, gdy urządzenie jest w zasięgu, albo hurtem w momencie ponownego połączenia.',
            'step_4_title'       => 'Weryfikuj automatycznie',
            'step_4_content'     => 'Centrum Sterowania porównuje zarejestrowaną trasę z każdym punktem kontrolnym, automatycznie oznaczając punkty pominięte, spóźnione lub poza trasą.',
            'step_5_title'       => 'Analizuj i optymalizuj',
            'step_5_content'     => 'Obserwacja patrolu na żywo lub wgląd do Archiwum, by przeglądać historię, wychwycać wąskie gardła i z czasem udoskonalić trasy.',

            // IN Guard: sprzęt
            'guard_hardware_heading'      => 'IN Guard: hardware',
            'guard_hardware_subtitle'     => 'Jedna stacja bazowa obsługuje do 200 trackerów, a zasięg na duże lub wymagające obiekty można rozszerzać o kolejne stacje. IN Guard jest obecnie działającym prototypem, a jego ostateczna forma może zostać dopasowana do Twoich konkretnych wymagań.',
            'guard_spec_1_title'          => 'Dalekozasięgowe, szyfrowane i w pełni lokalne',
            'guard_spec_1_content'        => 'IN Guard komunikuje się ze stacją bazową w paśmie <strong>868 MHz ISM przez LoRaWAN, zabezpieczonym od początku do końca szyfrowaniem AES-128</strong> — nadawać mogą wyłącznie urządzenia jawnie zarejestrowane w Twoim systemie. Stacja bazowa łączy się wyłącznie z Twoim własnym komputerem sterującym (Wi-Fi, LTE lub kablem Ethernet), więc <strong>dane z obchodów nigdy nie muszą opuszczać Twojej sieci</strong>.',
            'guard_spec_2_title'          => 'Precyzyjne, ciągłe pozycjonowanie',
            'guard_spec_2_content'        => 'Wbudowany, wielosystemowy odbiornik GNSS (GPS, GLONASS, Galileo, BeiDou) zapisuje dokładną pozycję trackera <strong>co 15 sekund</strong>, przechowując do <strong>500 punktów bezpośrednio na urządzeniu</strong> i przesyłając je, gdy tylko wróci ono w zasięg stacji bazowej.',
            'guard_spec_3_title'          => 'Zaprojektowany na całą zmianę',
            'guard_spec_3_content'        => 'Wbudowana bateria pozwala IN Guard pracować przez <strong>wiele godzin ciągłych obchodów</strong>. Doładujesz go standardowym kablem USB-C albo za pomocą <strong>dedykowanej stacji dokującej, która ładuje jednocześnie trzy urządzenia</strong>.',
            'guard_spec_4_title'          => 'Dwie warstwy bezpieczeństwa strażnika',
            'guard_spec_4_content'        => '<strong>Przycisk alarmowy uruchamiany jednym dotknięciem</strong> wysyła natychmiastowy priorytetowy alert do dyżurki. Wbudowany czujnik ruchu wykrywa też upadki — jeśli urządzenie pozostaje nieruchome i w pozycji poziomej dłużej niż ustalony czas, <strong>dyżurka jest powiadamiana automatycznie</strong>.',
            'guard_hardware_footnote_cta' => 'Zobacz pełną kartę specyfikacji IN Guard',

            // Wewnątrz Centrum Sterowania
            'control_center_heading'        => 'Wewnątrz Centrum Sterowania',
            'control_center_intro'          => 'Jedna aplikacja, działająca na Twoim własnym komputerze — bez zewnętrznego serwera, bez zależności od chmury, a mapa działa w pełni offline. Ten sam panel można rozszerzyć o pomiary i alerty z IN Sense — poznaj nasze drugie urządzenie poniżej.',
            'feature_1_tag'                 => 'Śledzenie na żywo',
            'feature_1_title'               => 'Podgląd na żywo',
            'feature_1_content'             => 'Wybierz dowolny tracker z listy i obserwuj jego obchód w czasie rzeczywistym — punkt po punkcie, z dokładnym czasem dotarcia do każdego z nich. Bufory czasu i odległości są w pełni konfigurowalne dla każdej trasy, więc weryfikacja odpowiada realiom Twojego obiektu.',
            'feature_2_tag'                 => 'Łatwe w zarządzaniu',
            'feature_2_title'               => 'Edytor tras i punktów kontrolnych',
            'feature_2_content'             => 'Dodawaj, edytuj lub usuwaj punkty kontrolne i całe trasy w kilku kliknięciach, bez wsparcia programisty — gdy zmienia się układ obiektu lub procedury, system zmienia się razem z Tobą.',
            'feature_3_tag'                 => 'Dane historyczne',
            'feature_3_title'               => 'Archiwum i analityka',
            'feature_3_content'             => 'Każdy punkt kontrolny jest automatycznie klasyfikowany jako zbyt wczesny, na czas, spóźniony lub pominięty. Filtruj wcześniejsze obchody po urządzeniu, dacie lub przedziale czasu, by zagłębić się w szczegóły — wychwyć wąskie gardła, powtarzające się opóźnienia czy strefy ryzyka i wykorzystaj dane do optymalizacji przyszłych tras.',
            'control_center_footnote_text'  => 'Oprogramowanie można też rozbudować i zintegrować z innymi systemami, jeśli wymaga tego Twoja działalność.',
            'control_center_footnote_cta'   => 'Porozmawiajmy o Twoich wyzwaniach',

            // Poznaj IN Sense
            'meet_sense_heading' => 'Poznaj IN Sense',
            'meet_sense_intro'   => 'Czujnik wykrywający mikroruchy związane z oddechem: mały, dyskretny i zaprojektowany tak, by nie przeszkadzać w służbie.',
            'sense_point_1'      => 'Pasuje do każdego układu posterunku: <strong>montaż sufitowy, wysięgnik lub mobilny statyw</strong>, który przeniesiesz między budkami.',
            'sense_point_2'      => '<strong>Bez kamer, bez urządzeń noszonych na ciele</strong> — kompaktowa jednostka, która po cichu wykonuje swoje zadanie w tle.',
            'sense_point_3'      => 'Umieszczony tuż nad lub obok krzesła strażnika — <strong>bez konieczności noszenia czegokolwiek na ciele</strong>.',

            // IN Sense: jak to działa
            'sense_how_heading'          => 'IN Sense: jak to działa',
            'sense_how_intro'            => 'Czujnik radarowy, który czuwa nad stałym posterunkiem — bez kamer, bez urządzeń noszonych na ciele.',
            'sense_how_point_1'          => '<strong>Działa na odległość (1-3 m):</strong> strażnik nie musi niczego zakładać.',
            'sense_how_point_2'          => '<strong>Pasywny pomiar oddechu:</strong> czujnik w tle śledzi mikroruchy klatki piersiowej, potwierdzając obecność i czujność nawet gdy strażnik pozostaje w bezruchu.',
            'sense_how_point_3'          => '<strong>Przekazanie zmiany i wykrywanie osób trzecich:</strong> system rejestruje moment przekazania zmiany i sygnalizuje, gdy na posterunku pojawi się ktoś nieoczekiwany.',
            'sense_how_point_4'          => '<strong>Inteligentne, stopniowane alerty:</strong> najpierw dyskretny sygnał budzący dla strażnika, a potem natychmiastowa eskalacja do Centrum Sterowania, jeśli sytuacja się nie zmieni.',
            'sense_how_point_5'          => '<strong>Optymalizacja grafiku:</strong> dane o spadkach czujności pomagają skuteczniej planować rotacje zmian i przerwy podczas wymagających nocnych dyżurów.',
            'sense_hardware_footnote_cta' => 'Zobacz pełną kartę specyfikacji IN Sense',

            // Od czujności do senności (przykładowy wykres)
            'chart_heading'      => 'Od czujności do senności: na jednym wykresie',
            'chart_intro'        => 'Rzeczywisty pomiar oddechu, zarejestrowany przez IN Sense.',
            'chart_point_1'      => 'Ten <strong>30-minutowy zapis</strong> pokazuje strażnika zajmującego stały posterunek, przy czujniku umieszczonym w odległości <strong>1,5 metra</strong>.',
            'chart_point_2'      => 'Po kilku minutach <strong>częstość oddechu wyraźnie zwalnia</strong> wraz ze spadkiem czujności.',
            'chart_point_3'      => 'IN Sense automatycznie oznacza to jako <strong>stopniowany alert</strong> — najpierw dyskretny sygnał budzący, bez potrzeby angażowania przełożonych.',
            'chart_footnote_text' => 'IN Sense można zainstalować w dowolnym stałym posterunku — portierni, budki lub pomieszczenia dozoru — bez zakłócania sposobu, w jaki dotychczas pracował Twój zespół.',
            'chart_footnote_cta'  => 'Porozmawiajmy o Twoim zakładzie',

            // Dlaczego się to opłaca
            'outcomes_heading'   => 'Dlaczego warto',
            'outcomes_subtitle'  => 'Więcej niż weryfikacja — mierzalny wpływ na zgodność, pokrycie i koszty.',
            'outcome_1_title'    => 'Zgodność gotowa na audyt',
            'outcome_1_content'  => 'Każdy obchód i każdy stały posterunek jest automatycznie oznaczany czasowo i weryfikowany — gotowy zapis na potrzeby audytów, klientów czy ubezpieczyciela.',
            'outcome_2_title'    => 'Nic nie umyka uwadze',
            'outcome_2_content'  => 'Pominięty punkt kontrolny jest natychmiast oznaczany. Na stałym posterunku nagły ruch, szarpanina lub inne podejrzane zachowanie wysyła alert.',
            'outcome_3_title'    => 'Mądrzejsze decyzje kadrowe',
            'outcome_3_content'  => 'Rzeczywiste dane z obchodów — nie domysły — pokazują, gdzie modyfikować pokrycie, a gdzie przebieg trasy, zwiększając efektywność bez powiększania zespołu.',
            'outcome_4_title'    => 'Pełna anonimowość',
            'outcome_4_content'  => 'Bez kamer, bez analizy obrazu — w obu narzędziach strażnicy są monitorowani pod kątem obecności i czujności, nigdy obserwowani ani nagrywani.',
            'outcome_5_title'    => 'Jedna platforma, gotowa na rozbudowę',
            'outcome_5_content'  => 'Pomiary z IN Sense i dane z obchodów IN Guard dostępne w jednej aplikacji, którą można też zintegrować z innymi systemami bezpieczeństwa.',
            'outcome_6_title'    => 'Mniejsza rotacja pracowników',
            'outcome_6_content'  => 'Przycisk SOS i detekcja upadku dają strażnikom dodatkowe poczucie bezpieczeństwa — wsparcie, pomagające tworzyć lepsze miejsce pracy.',

            // Gdzie sprawdza się IN Security
            'services_heading'  => 'Gdzie sprawdza się IN Security',
            'services_subtitle' => 'Wszędzie tam, gdzie trzeba przejść trasę obchodu albo upilnować posterunku.',
            'use_case_1'  => 'Magazyny i centra logistyczne',
            'use_case_2'  => 'Zakłady przemysłowe i produkcyjne',
            'use_case_3'  => 'Kampusy biurowe',
            'use_case_4'  => 'Infrastruktura krytyczna',
            'use_case_5'  => 'Handel i obiekty publiczne',
            'use_case_6'  => 'Place budowy',
            'use_case_7'  => 'Centra danych',
            'use_case_8'  => 'Lotniska i węzły komunikacyjne',
            'use_case_9'  => 'Placówki medyczne',
            'use_case_10' => 'Kampusy edukacyjne',
            'use_case_11' => 'Farmy słoneczne i wiatrowe',
            'use_case_12' => 'Porty i terminale morskie',
            'use_case_13' => 'Budki i portiernie',
            'use_case_14' => 'Pomieszczenia dozoru i sterowania',

            // Finalne CTA
            'final_cta_heading' => 'Zabezpiecz każdy obchód. Pilnuj każdego posterunku.',
            'final_cta_text'    => 'Porozmawiaj z naszym zespołem o wdrożeniu narzych narzędzi w Twoim obiekcie.',
            'final_cta_button'  => 'Umów konsultację',

            // page-in-guard.php / page-in-sense.php — karty produktów
            'product_card_link_how_it_works' => 'Zobacz, jak to działa',
            'product_card_link_contact'      => 'Skontaktuj się',

            'guard_card_render_placeholder' => 'Render IN Guard 01',
            'guard_card_spec_1_label'  => 'Łączność',
            'guard_card_spec_1_value'  => 'LoRaWAN, pasmo 868 MHz ISM, szyfrowanie AES-128',
            'guard_card_spec_2_label'  => 'Pozycjonowanie',
            'guard_card_spec_2_value'  => 'Wielosystemowy GNSS (GPS, GLONASS, Galileo, BeiDou)',
            'guard_card_spec_3_label'  => 'Dokładność znacznika czasu',
            'guard_card_spec_3_value'  => 'Pochodzi bezpośrednio z GNSS — precyzyjny, zsynchronizowany satelitarnie czas przy każdym zapisanym punkcie',
            'guard_card_spec_4_label'  => 'Częstotliwość aktualizacji',
            'guard_card_spec_4_value'  => 'Co 15 sekund (konfigurowalne)',
            'guard_card_spec_5_label'  => 'Pamięć na urządzeniu',
            'guard_card_spec_5_value'  => 'Do 500 punktów',
            'guard_card_spec_6_label'  => 'Czas pracy baterii',
            'guard_card_spec_6_value'  => 'Do 8 godzin',
            'guard_card_spec_7_label'  => 'Ładowanie',
            'guard_card_spec_7_value'  => 'USB-C lub stacja dokująca (3 urządzenia jednocześnie)',
            'guard_card_spec_8_label'  => 'Jeden przycisk',
            'guard_card_spec_8_value'  => 'Włączanie; krótkie naciśnięcie wysyła priorytetowy alarm do dyżurki; długie naciśnięcie (~2s) wyłącza urządzenie — reset',
            'guard_card_spec_9_label'  => 'Detekcja upadku',
            'guard_card_spec_9_value'  => 'Automatyczny alert po 20s bezruchu w pozycji poziomej, powtarzany co 60s aż do rozwiązania — wyłączona podczas ładowania',
            'guard_card_spec_10_label' => 'Zalecany sposób noszenia',
            'guard_card_spec_10_value' => 'Kieszeń użytkownika lub zaczepiony na smyczy; unikać zakrywania metalem dla najlepszego sygnału',
            'guard_card_spec_11_label' => 'Temperatura pracy',
            'guard_card_spec_11_value' => '-5°C do +40°C',
            'guard_card_spec_12_label' => 'Połączenie ze stacją bazową',
            'guard_card_spec_12_value' => 'Wi-Fi, LTE lub przewodowy Ethernet — w pełni lokalne (on-premise)',
            'guard_card_spec_13_label' => 'Dane mapy',
            'guard_card_spec_13_value' => 'Dostępna offline — bez potrzeby połączenia z internetem',
            'guard_card_spec_14_label' => 'Weryfikacja punktów kontrolnych',
            'guard_card_spec_14_value' => 'Każda zaliczony punkt automatycznie klasyfikowany jako zbyt wczesny, na czas, spóźniony lub pominięty',
            'guard_card_spec_15_label' => 'Skalowalność',
            'guard_card_spec_15_value' => 'Do 200 trackerów na stację bazową; można dodać kolejne stacje, by pokryć większy teren',
            'guard_card_spec_16_label' => 'Wskaźnik statusu',
            'guard_card_spec_16_value' => 'Wbudowana dioda LED pokazuje bieżący status urządzenia',
            'guard_card_charger_intro'   => '<strong>Ładowanie:</strong> pojedynczo (USB-C) albo za pomocą stacji dokującej do jednoczesnego ładowania do 3 urządzeń IN Guard.',
            'guard_card_charger_point_1' => 'Pojedyncze urządzenie: 5V ±5%, 500mA',
            'guard_card_charger_point_2' => 'Stacja dokująca: 5V ±5%, 1500mA',

            'sense_card_spec_1_label'  => 'Zasada pomiaru',
            'sense_card_spec_1_value'  => 'Radarowy pomiar odległości do ciała, wykrywający mikroruchy klatki piersiowej związane z oddychaniem',
            'sense_card_spec_2_label'  => 'Zasięg pomiaru',
            'sense_card_spec_2_value'  => '1-3 metry',
            'sense_card_spec_3_label'  => 'Kontakt ze strażnikiem',
            'sense_card_spec_3_value'  => 'Brak — bez opasek, bez kabli na ciele strażnika',
            'sense_card_spec_4_label'  => 'Prywatność wizualna',
            'sense_card_spec_4_value'  => 'Bez kamer, bez mikrofonów, bez analizy obrazu — nic nie jest nigdy nagrywane ani obserwowane',
            'sense_card_spec_5_label'  => 'Opcje montażu',
            'sense_card_spec_5_value'  => 'Montaż sufitowy, wysięgnik lub mobilny statyw — przenoszony między budkami lub posterunkami',
            'sense_card_spec_6_label'  => 'Transmisja danych',
            'sense_card_spec_6_value'  => 'Bezprzewodowa (Wi-Fi) do Centrum Sterowania',
            'sense_card_spec_7_label'  => 'Zachowanie alertów',
            'sense_card_spec_7_value'  => 'Stopniowane — najpierw dyskretny sygnał budzący, natychmiastowa eskalacja do Centrum Sterowania przy nagłym ruchu lub podejrzeniu upadku',
            'sense_card_spec_8_label'  => 'Wykrywanie przekazania zmiany',
            'sense_card_spec_8_value'  => 'Rejestruje moment przekazania zmiany i sygnalizuje, gdy na posterunku pojawi się ktoś nieoczekiwany',
            'sense_card_spec_9_label'  => 'W porównaniu do czujników ruchu',
            'sense_card_spec_9_value'  => 'Bardziej niezawodny niż czujniki PIR, które tracą dokładność bez dużego ruchu i łatwo je oszukać',
            'sense_card_spec_10_label' => 'Przetwarzanie danych',
            'sense_card_spec_10_value' => 'W 100% lokalne — bez chmury, bez zewnętrznego serwera',
            'sense_card_spec_11_label' => 'Zakres monitorowania',
            'sense_card_spec_11_value' => 'Ciągły, jeden czujnik na posterunek',
            'sense_card_spec_12_label' => 'Możliwa rozbudowa',
            'sense_card_spec_12_value' => 'Predykcja zmęczenia i profilowanie zachowań oparte na uczeniu maszynowym',
        ],
    ];
}
