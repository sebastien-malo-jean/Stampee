{{ include('layouts/header.php', { title: 'Création de Timbre' }) }}

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
        <!-- ajouter l’attribut enctype pour l’upload d’images -->
        <form class="form" method="post" enctype="multipart/form-data">
            <h2 class="form__title">Création d'un Timbre</h2>

            <!-- Nom -->
            <label class="form__label">
                Nom
                <input type="text" class="form__input" name="name" value="{{ stamp.name|default('') }}">
            </label>

            <!-- Date de création -->
            <label class="form__label">
                Date de création
                <input type="date" class="form__input" name="date" value="{{ stamp.date|default('') }}">
            </label>

            <!-- Tirage -->
            <label class="form__label">
                Tirage
                <input type="number" class="form__input" name="print_run" value="{{ stamp.print_run|default('') }}">
            </label>

            <!-- Dimensions -->
            <label class="form__label">
                Dimensions
                <input type="text" class="form__input" name="dimensions" value="{{ stamp.dimensions|default('') }}">
            </label>

            <!-- Certifié -->
            <label class="form__label">
                Certifié
                <select class="form__select" name="certified">
                    <option value="0" {% if stamp.certified is defined and stamp.certified == 0 %}selected{% endif %}>
                        Non</option>
                    <option value="1" {% if stamp.certified is defined and stamp.certified == 1 %}selected{% endif %}>
                        Oui</option>
                </select>
            </label>

            <!-- Description -->
            <label class="form__label">
                Certifié
                <input type="text" class="form__input" name="description" value="{{ stamp.description|default('') }}">
            </label>

            <!-- Condition -->
            <label class="form__label">
                Condition
                <select class="form__select" name="condition_id">
                    <option value="">-- Sélectionner une condition --</option>
                    <!-- faire logique pour la condition -->
                </select>
            </label>

            <!-- Pays d’origine -->
            <label class="form__label">
                Pays d’origine
                <select class="form__select" name="origin_id">
                    <option value="">-- Sélectionner un pays --</option>
                    <!-- faire logique pour les pays -->
                </select>
            </label>

            <!-- Couleur(s) -->
            <label class="form__label">
                Couleur(s)
                <select class="form__select" name="color_id">
                    <option value="">-- Sélectionner une condition --</option>
                    <!-- faire logique pour la couleur -->
                </select>
            </label>

            <!-- Image principale -->
            <label class="form__label">
                Image principale
                <input type="file" class="form__input" name="image_principale">
            </label>

            <!-- Images supplémentaires (pour plusieurs fichiers) -->
            <label class="form__label">
                Images supplémentaires
                <input type="file" class="form__input" name="images_supplementaires[]" multiple>
            </label>

            <!-- user_id -->
            <label class="form__label">
                <input type="text" class="form__input" name="user_id" value="{{ user_id }}" readonly>
            </label>

            <!-- Bouton de soumission -->
            <button type="submit" class="form__button">Enregistrer</button>
        </form>
    </div>
</div>

{{ include('layouts/footer.php') }}