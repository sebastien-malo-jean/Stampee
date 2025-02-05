<div class="content__frame-filter">
    <input type="checkbox" id="filter-toggle">
    <!-- Label pour ouvrir/fermer le menu -->
    <label for="filter-toggle">
        <span class="filter__hidden">Recherche</span>
        <span class="menu-icon"></span>
        <span class="menu-icon"></span>
        <span class="menu-icon"></span>
    </label>
    <div class="overlay"></div>
    <form class="filter" method="get" action="">
        <h2 class="filter__title">Filtrer<br>les enchères</h2>

        <label class="filter__label">
            <span class="filter__label-title title">Rechercher : </span>
            <input type="text" name="search" class="filter__input" placeholder="Enchère/timbre...">
        </label>

        <label class="filter__label">
            <span class="filter__label-title title">Prix : </span>
            <input type="number" name="price" class="filter__input" value="{{  }}">
        </label>

        <!-- Pays d'origine depuis la base -->
        <label class="filter__label" for="pays">
            <span class="filter__label-title title">Pays d'origine : </span>
            <select name="pays" id="pays">
                <option value="">Tous les pays</option>
                {% for origin in origins %}
                <option value="{{ origin.id }}">{{ origin.country }}</option>
                {% endfor %}
            </select>
        </label>

        <label class="filter__label">
            <span class="filter__label-title title">Année de publication : </span>
            <input type="number" name="year" class="filter__input">
        </label>

        <!-- Condition (état du timbre) depuis la base -->
        <label class="filter__label">
            <span class="filter__label-title title">Condition : </span>
            <select name="condition" id="condition">
                <option value="">Toutes les conditions</option>
                {% for state in stamp_states %}
                <option value="{{ state.id }}">{{ state.state }}</option>
                {% endfor %}
            </select>
        </label>

        <label class="filter__label">
            <span class="filter__label-title title">Date de début : </span>
            <input type="date" name="start_date" class="filter__input">
        </label>

        <label class="filter__label">
            <span class="filter__label-title title">Date de fin : </span>
            <input type="date" name="end_date" class="filter__input">
        </label>

        <button type="submit" class="filter__btn btn">Rechercher</button>
    </form>
</div>