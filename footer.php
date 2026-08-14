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
                    <p>© <?php echo date( 'Y' ); ?> IndoorNavi. All rights reserved.</p>
                    <div class="legal-links">
                        <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a>
                        <span class="legal-separator">|</span>
                        <a href="<?php echo esc_url( home_url( '/cookie-policy/' ) ); ?>">Cookie Policy</a>
                    </div>
                </div>
            </div>

        </div>

        <nav class="footer-nav">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
            <a href="https://indoornavi.me/#branches" target="_blank" rel="noopener noreferrer">Other products</a>
            <a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer">Contact</a>
            <a href="https://indoornavi.me/blog/" target="_blank" rel="noopener noreferrer">Blog</a>
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

<?php wp_footer(); ?>
</body>
</html>
