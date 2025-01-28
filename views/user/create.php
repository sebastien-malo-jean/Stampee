{{ include ('layouts/header.php', {title:'Inscription'})}}

<div class="general-container">
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
        <form class="form" method="post">
            <h2 class="form__title">Inscription</h2>

            <label class="form__label">
                Nom
                <input type="text" class="form__input" name="name" value="{{ user.name }}">
            </label>

            <label class="form__label">
                Email
                <input type="email" class="form__input" name="username" value="{{ user.username }}">
            </label>

            <label class="form__label">
                Confirmation du Email
                <input type="email" class="form__input" name="email" value="{{ user.email }}">
            </label>

            <label class="form__label">
                Mot de passe
                <input type="password" class="form__input" name="password">
            </label>

            <label class="form__label" hidden>
                <!--Privilege-->
                <select class="form__select" name="privilege_id" hidden>
                    <option value="2">Select privilege</option>
                    {% for privilege in privileges %}
                    <option value="{{ privilege.id }}" {% if privilege.id == user.privilege_id %} selected {% endif %}>
                        {{ privilege.privilege }}
                    </option>
                    {% endfor %}
                </select>
            </label>

            <button type="submit" class="form__button">Save</button>
        </form>
    </div>
</div>

{{ include ('layouts/footer.php')}}