<article class='card'>
    <div class='card__picture'>
        <img src="{{ images[0].url }}" alt='Collection de timbres rares - Série 1940' class='card__img'>
    </div>
    <ul class='card__list'>
        <li class='card__list-header'>
            <div class='card__list-data title'>
                <h3 class='card__title'>{{ stamp.name }}</h3>
            </div>
        </li>

        <li class='card__list-row'>
            <div class='card__list-data title'>Coup de coeur : </div>
            <div class='card__list-data answer'>
                {% if auction.featured %}
                <img src='{{ asset }}/img/logo/gold_heart.svg' alt='heart' class='card__list-img stampeeChoice'>
                {% endif %}
            </div>
        </li>
        <li class='card__list-row'>
            <div class='card__list-data title'>Période d'activité : </div>
            <div class='card__list-data answer'>
                {% set startTimestamp = auction.start_date|date('U') %}
                {% set endTimestamp = auction.end_date|date('U') %}
                {% set diffSeconds = endTimestamp - startTimestamp %}
                {% set diffDays = (diffSeconds / 86400)|round(0, 'floor') %}
                {{ diffDays }} jours
            </div>
        </li>
        <li class='card__list-row'>
            <div class='card__list-data title'>Date de début : </div>
            <div class='card__list-data answer'>{{ auction.start_date }}</div>
        </li>
        <li class='card__list-row'>
            <div class='card__list-data title'>Date de fin : </div>
            <div class='card__list-data answer'>{{ auction.end_date }}</div>
        </li>
        <li class='card__list-row'>
            <div class='card__list-data title'>Prix plancher : </div>
            <div class='card__list-data answer'>€ {{ auction.floor_price }}</div>
        </li>
        <li class='card__list-row'>
            <div class='card__list-data title'>Offre actuelle :</div>
            <div class='card__list-data answer'>{{biggestBidValue.value}}</div>
        </li>
        <li class='card__list-row'>
            <div class='card__list-data title'>Nom du dernier miseur : </div>
            <div class='card__list-data answer'>{{ biggestBidValue.user_name}}</div>
        </li>
        <li class='card__list-row'>
            <div class='card__list-data title'>Quantité de mises : </div>
            <div class='card__list-data answer'>
                {{ bids|length }}
            </div>
        </li>
    </ul>
    <a class='card__btn btn' href="{{ base }}/auction/show?id={{ auction.id }}">Miser</a>
</article>