<footer id="contact-footer" class="subpage-footer">
    <div class="footer-container">
        <div class="footer-layout">

            <div class="footer-contact">
                <p class="footer-email">
                    <span id="safe-email"></span>
                    <noscript><a href="mailto:office@indoornavi.me">office@indoornavi.me</a></noscript>
                </p>
                <p class="footer-address">
                    IndoorNavi Sp. z o.o.<br>
                    Mikołaja Kopernika 16<br>
                    80-208 Gdańsk<br>
                    VAT: PL5783121129
                </p>
            </div>

            <div class="footer-nav-legal">
                <nav class="footer-bottom-nav">
                    <ul>
                        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/in-guard/' ) ); ?>">IN Guard</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/in-sense/' ) ); ?>">IN Sense</a></li>
                        <li><a href="https://indoornavi.me/#branches" target="_blank" rel="noopener noreferrer">Other products</a></li>
                        <li><a href="https://indoornavi.me/#contact" target="_blank" rel="noopener noreferrer">Contact</a></li>
                        <li><a href="https://indoornavi.me/blog/" target="_blank" rel="noopener noreferrer">Blog</a></li>
                    </ul>
                </nav>
                <div class="footer-legal-text">
                    <p>© <?php echo date('Y'); ?> IndoorNavi. All rights reserved.</p>
                    <p>
                        <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a>
                        <span class="legal-separator">|</span>
                        <a href="<?php echo esc_url( home_url( '/cookie-policy/' ) ); ?>">Cookie Policy</a>
                    </p>
                </div>
            </div>

        </div>
    </div>
</footer>

<script>
    (function () {
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
