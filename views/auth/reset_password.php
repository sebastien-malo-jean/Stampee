{{ include ('layouts/header.php', {title:'Réinitialisation du mot de passe'})}}
<div class="general-container">
    <!-- Bloc pour les messages -->
    {% if message %}
    <div class="form-container__message">
        <p>{{ message }}</p>
    </div>
    {% endif %}
    <!-- Bloc pour les erreurs -->
    {% if errors is defined %}
    <div class="form-container__error">
        <ul class="form-container__error-list">
            {% for error in errors %}
            <li class="form-container__error-item">{{ error }}</li>
            {% endfor %}
        </ul>
    </div>
    {% endif %}
    <div class="form-container">

        <!-- Formulaire principal -->
        <form class="form" method="post" action="{{base}}/reset_password">
            <h2 class="form__title">Réinitialisation du mot de passe</h2>

            <label class="form__label">
                Email
                <input type="email" class="form__input" name="email" required>
            </label>

            <button type="submit" class="form__button">Réinitialiser</button>
        </form>
    </div>
</div>

{{ include ('layouts/footer.php')}}