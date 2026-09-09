<footer id="contact-footer">
    <div class="footer-container">
        <div class="footer-bar">

            <div class="footer-col-brand">
                <div class="footer-contact-details">
                    <div class="footer-contact-col">
                        <p class="footer-address">
                            <span class="footer-company-name">IndoorNavi Sp. z o.o.</span><br>
                            Mikołaja Kopernika 16<br>
                            80-208 Gdańsk<br>
                            VAT: PL5783121129
                        </p>
                    </div>

                    <div class="footer-contact-col footer-contact-col-phone">
                        <div id="safe-phone"></div>
                        <div id="safe-email"></div>
                        <noscript>
                            +48 533 334 383<br>
                            office (at) indoornavi.me
                        </noscript>
                    </div>
                </div>
            </div>

            <div class="footer-col-right">
                <div class="footer-legal">
                    <a href="https://pl.linkedin.com/company/indoornavi" class="linkedin-box" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M20.45 20.45h-3.55v-5.57c0-1.33-.02-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.94v5.67H9.36V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.38-1.85 3.61 0 4.28 2.38 4.28 5.47v6.27zM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12zM7.12 20.45H3.56V9h3.56v11.45z" />
                        </svg>
                    </a>
                    <p>© <?php echo date( 'Y' ); ?> <?php echo esc_html( in_security_t( 'footer_rights' ) ); ?></p>
                    <div class="legal-links">
                        <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php echo esc_html( in_security_t( 'footer_privacy_policy' ) ); ?></a>
                        <span class="legal-separator">|</span>
                        <a href="<?php echo esc_url( home_url( '/cookie-policy/' ) ); ?>"><?php echo esc_html( in_security_t( 'footer_cookie_policy' ) ); ?></a>
                    </div>
                </div>
            </div>

        </div>

        <nav class="footer-nav">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( in_security_t( 'nav_home' ) ); ?></a>
            <a href="<?php echo esc_url( home_url( '/in-guard/' ) ); ?>"><?php echo esc_html( in_security_t( 'nav_in_guard' ) ); ?></a>
            <a href="<?php echo esc_url( home_url( '/in-sense/' ) ); ?>"><?php echo esc_html( in_security_t( 'nav_in_sense' ) ); ?></a>
            <a href="https://indoornavi.me/#branches" target="_blank" rel="noopener noreferrer"><?php echo esc_html( in_security_t( 'nav_other_products' ) ); ?></a>
            <a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer"><?php echo esc_html( in_security_t( 'nav_contact' ) ); ?></a>
            <a href="https://indoornavi.me/blog/" target="_blank" rel="noopener noreferrer"><?php echo esc_html( in_security_t( 'nav_blog' ) ); ?></a>
        </nav>
    </div>
</footer>

<script>
    (function () {
        var prefix = '+48';
        var p1 = '533', p2 = '334', p3 = '383';
        var fullTel = prefix + p1 + p2 + p3;
        var phoneEl = document.getElementById('safe-phone');
        if (phoneEl) phoneEl.innerHTML = '<a href="tel:' + fullTel + '">' + prefix + ' ' + p1 + ' ' + p2 + ' ' + p3 + '</a>';

        var user = 'office', domain = 'indoornavi.me';
        var emailEl = document.getElementById('safe-email');
        if (emailEl) emailEl.innerHTML = '<a href="mailto:' + user + '@' + domain + '">' + user + '@' + domain + '</a>';
    })();
</script>

<script>
(function () {
    var btn = document.querySelector('.mobile-menu-btn');
    var nav = document.querySelector('header nav');

    if (btn && nav) {
        btn.addEventListener('click', function () {
            btn.classList.toggle('active');
            nav.classList.toggle('active');
            document.body.style.overflow = nav.classList.contains('active') ? 'hidden' : 'auto';
        });

        document.querySelectorAll('header nav a').forEach(function (link) {
            link.addEventListener('click', function () {
                btn.classList.remove('active');
                nav.classList.remove('active');
                document.body.style.overflow = 'auto';
            });
        });
    }
}());
</script>

<script>
(function () {
    var targets = document.querySelectorAll(
        '.security-page .container > *, .step-card, .device-spec-card, .feature-row, .roadmap-connect-line'
    );
    if (!targets.length) return;

    var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    targets.forEach(function (el, i) {
        el.classList.add('reveal-on-scroll');
        // Linia leży za kartami (niższy z-index) — dopóki karty są półprzezroczyste
        // w trakcie fade-in, linia prześwituje przez nie i wygląda jakby była na
        // wierzchu. Wchodzi więc dopiero po tym, jak reszta sekwencji się skończy.
        if (el.classList.contains('roadmap-connect-line')) {
            el.style.transitionDelay = '0.45s';
        } else {
            el.style.transitionDelay = (i % 5) * 0.08 + 's';
        }
    });

    if (prefersReducedMotion || !('IntersectionObserver' in window)) {
        targets.forEach(function (el) {
            el.classList.add('is-visible', 'reveal-settled');
            el.style.transitionDelay = '';
        });
        return;
    }

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                var el = entry.target;
                el.classList.add('is-visible');
                observer.unobserve(el);
                // transitionDelay było tylko po to, żeby wejście na scrollu
                // "falowało" — zostawione na stałe kazałoby też hoverowi czekać
                // te same 0-0.45s. .reveal-settled podmienia też czas trwania
                // transform na szybszy, żeby hover nie dziedziczył wolnego wjazdu.
                // Robimy to dopiero, gdy wejście na pewno się skończyło (delay+duration).
                window.setTimeout(function () {
                    el.style.transitionDelay = '';
                    el.classList.add('reveal-settled');
                }, 1150);
            }
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -60px 0px' });

    targets.forEach(function (el) { observer.observe(el); });
}());
</script>

<script>
(function () {
    // Na mobile 14 pigułek "Where IN Security Fits" pokazuje się po kilka
    // naraz (grupy po 4, owinięte w .tags-group), zmieniając się co 3s z
    // płynnym przenikaniem (position:absolute + opacity w @media, patrz
    // style.css) — dzięki temu sekcja ma stałą wysokość, a nie "skacze" w
    // dół, gdy kolejna grupa ma więcej wierszy. Na desktopie
    // .tags-group{display:contents} usuwa wrapper z layoutu, więc to
    // grupowanie nie ma tam żadnego efektu wizualnego.
    var container = document.querySelector('.services .tags');
    var tagsList = container ? container.querySelectorAll('.tag') : null;
    if (!container || !tagsList || !tagsList.length) return;

    var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) return; // zostają płaskie, wszystkie widoczne naraz, bez rotacji

    var groupSize = 4;
    var tagsArray = Array.prototype.slice.call(tagsList);
    var groups = [];
    for (var i = 0; i < tagsArray.length; i += groupSize) {
        groups.push(tagsArray.slice(i, i + groupSize));
    }
    if (groups.length <= 1) return;

    var groupEls = groups.map(function (group) {
        var groupEl = document.createElement('div');
        groupEl.className = 'tags-group';
        group.forEach(function (tag) { groupEl.appendChild(tag); });
        container.appendChild(groupEl);
        return groupEl;
    });

    var current = 0;
    groupEls[current].classList.add('is-tag-active');
    setInterval(function () {
        groupEls[current].classList.remove('is-tag-active');
        current = (current + 1) % groupEls.length;
        groupEls[current].classList.add('is-tag-active');
    }, 3000);
}());
</script>

<?php wp_footer(); ?>
</body>
</html>
