</main>
<footer class='footer'>
    <nav class='footer__nav'>
        <!-- Section Membre -->
        <div class="footer__nav-section">
            <input type="radio" id="section1" name="accordion" class="accordion-radio">
            <label for="section1" class="footer__nav-section-title">Membre</label>
            <ul class='footer__nav-list'>
                {% if guest %}
                <li class='footer__nav-item'><a href='{{base}}/login' class='footer__link'>Connection</a></li>
                <li class='footer__nav-item'><a href='{{base}}/user/create' class='footer__link'>Insciption</a></li>
                {% else %}
                <li class='footer__nav-item'><a href='' class='footer__link'>Profil</a></li>
                <li class='footer__nav-item'><a href='{{base}}/logout' class='footer__link'>Déconnection</a></li>
                {% endif %}
            </ul>
        </div>

        <!-- Section À propos -->
        <div class="footer__nav-section">
            <input type="radio" id="section2" name="accordion" class="accordion-radio">
            <label for="section2" class="footer__nav-section-title">À propos</label>
            <ul class='footer__nav-list'>
                <li class='footer__nav-item'><a href='' class='footer__link'>À propos de Lord Reginald Stampee III</a>
                </li>
                <li class='footer__nav-item'><a href='' class='footer__link'>Biographie du Lord</a></li>
                <li class='footer__nav-item'><a href='' class='footer__link'>Historique familial</a></li>
                <li class='footer__nav-item'><a href='' class='footer__link'>Actualités</a></li>
            </ul>
        </div>

        <!-- Section Timbres & Enchères -->
        <div class="footer__nav-section">
            <input type="radio" id="section3" name="accordion" class="accordion-radio">
            <label for="section3" class="footer__nav-section-title">Timbres & Enchères</label>
            <ul class='footer__nav-list'>
                <li class='footer__nav-item'><a href='{{base}}/stamp/create' class='footer__link'>Timbres</a></li>
                <li class='footer__nav-item'><a href='' class='footer__link'>Enchères</a></li>
            </ul>
        </div>

        <!-- Section Fonctionnalités -->
        <div class="footer__nav-section">
            <input type="radio" id="section4" name="accordion" class="accordion-radio">
            <label for="section4" class="footer__nav-section-title">Fonctionnalités</label>
            <ul class='footer__nav-list'>
                <li class='footer__nav-item'><a href='' class='footer__link'>Fonctionnement de la plateforme</a></li>
                <li class='footer__nav-item'><a href='' class='footer__link'>Aide « Profil »</a></li>
                <li class='footer__nav-item'><a href='' class='footer__link'>Aide « Comment placer une offre »</a></li>
                <li class='footer__nav-item'><a href='' class='footer__link'>Aide « Suivre une enchère »</a></li>
                <li class='footer__nav-item'><a href='' class='footer__link'>Aide « Trouver l’enchère désirée »</a></li>
            </ul>
        </div>

        <!-- Section Contact -->
        <div class="footer__nav-section">
            <input type="radio" id="section5" name="accordion" class="accordion-radio">
            <label for="section5" class="footer__nav-section-title">Contact</label>
            <ul class='footer__nav-list'>
                <li class='footer__nav-item'><a href='' class='footer__link'>Contacter le webmestre</a></li>
                <li class='footer__nav-item'><a href='' class='footer__link'>Contactez-nous</a></li>
            </ul>
        </div>
    </nav>

    <section class='footer__copyright'>
        <p>Copyright © 2024 Stampee. Tous droits réservés.</p>
    </section>
</footer>

</body>

</html>