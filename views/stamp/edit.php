{{ include('layouts/header.php', { title: 'Création de Timbre' }) }}

<div class="general-container">

    <section class='stampCard__gallery'>
        <figure class='stampCard__gallery-figure'>
            <img id='main_img' src='{{ images[0].url }}' alt='image principale' class='stampCard__gallery-figure--img'>
        </figure>
        <div class='stampCard__gallery-thumbnails'>
            {% for image in images %}
            <picture class='stampCard__gallery-thumbnails--picture'>
                <img src='{{ image.url }}' alt='{{ image.name }}' class='stampCard__gallery-thumbnails--img'>
                <form action="{{ base }}/stamp/deleteImage" method="post" class="form__button-delete-image">
                    <input type="text" name="id" value="{{ image.id }}" hidden>
                    <button type="submit">X</button>
                </form>
            </picture>
            {% endfor %}

        </div>
    </section>
    <div class="form-container">
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
                <input type="number" year class="form__input" name="date" value="{{ stamp.date|default('') }}">
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
                Description
                <input type="text" class="form__input" name="description" value="{{ stamp.description|default('') }}">
            </label>

            <!-- Condition -->
            <label class="form__label">
                Condition
                <select class="form__select" name="stamp_state_id">
                    <option value="">-- Sélectionner une condition --</option>
                    <!-- faire logique pour la condition -->
                    {% for s in stamp_states %}
                    <option value="{{ s.id }}"
                        {% if stamp.stamp_state_id is defined and stamp.stamp_state_id == s.id %}selected{% endif %}>
                        {{ s.state }}
                    </option>
                    {% endfor %}
                </select>
            </label>

            <!-- Pays d’origine -->
            <label class="form__label">
                Pays d’origine
                <select class="form__select" name="origin_id">
                    <option value="">-- Sélectionner un pays --</option>
                    <!-- faire logique pour les pays -->
                    {% for o in origins %}
                    <option value="{{ o.id }}"
                        {% if stamp.origin_id is defined and stamp.origin_id == o.id %}selected{% endif %}>
                        {{ o.country }}
                    </option>
                    {% endfor %}

                </select>
            </label>

            <!-- Couleur(s) -->
            <label class="form__label">
                Couleur(s)
                <select class="form__select" name="color_id">
                    <option value="">-- Sélectionner une couleur --</option>
                    <!-- faire logique pour la couleur -->
                    {% for c in colors %}
                    <option value="{{ c.id }}"
                        {% if stamp.color_id is defined and stamp.color_id == c.id %}selected{% endif %}>
                        {{ c.name }}
                    </option>
                    {% endfor %}
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
                {{ user.id }}
                <input type="text" class="form__input" name="user_id" value="{{ user }}" readonly
                    placeholder="{{ user }}">
            </label>

            <!-- Bouton de soumission -->
            <button type="submit" class="form__button">Enregistrer</button>
        </form>
        <form action="{{ base }}/stamp/delete" method="post">
            <input type="hidden" name="id" value="{{ stamp.id }}">
            <button type="submit" class="form__button">Supprimer</button>
        </form>

    </div>
</div>

{{ include('layouts/footer.php') }}