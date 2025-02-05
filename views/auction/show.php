{{ include('layouts/header.php', { title: 'Vue sur l\'enchère' }) }}
<meta http-equiv="refresh" content="10">

<section class="content__frame">
    <div class="content__frame-stampCard-page">
        <h1 class="content__frame-title">Detail de l'enchère</h1>

        <article class='stampCard'>
            <section class='stampCard__gallery'>
                <figure class='stampCard__gallery-figure'>
                    <img id='main_img' src='{{ images[0].url }}' alt='image principale'
                        class='stampCard__gallery-figure--img'>
                </figure>
                <div class='stampCard__gallery-thumbnails'>
                    {% for image in images %}
                    <picture class='stampCard__gallery-thumbnails--picture'>
                        <img src='{{ image.url }}' alt='{{ image.name }}' class='stampCard__gallery-thumbnails--img'>
                    </picture>
                    {% endfor %}

                </div>
            </section>
            <section class='stampCard__box-details'>
                <section class='stampCard__details'>
                    <h3 class='stampCard__details-title'>{{stamp.name}}</h3>
                    <div class='stampCard__details-box'>
                        <p class='stampCard__details-box--label'>Date de création</p>
                        <p class='stampCard__details-box-detail'>{{stamp.date}}</p>
                    </div>
                    <div class='stampCard__details-box'>
                        <p class='stampCard__details-box--label'>Couleur(s)</p>
                        <p class='stampCard__details-box-detail'>
                            {% for color in colors %}
                            {% if loop.index == stamp.color_id %}
                            {{ color.name }}
                            {% endif %}
                            {% endfor %}
                        </p>
                    </div>
                    <div class='stampCard__details-box'>
                        <p class='stampCard__details-box--label'>Pays d'origine</p>
                        <p class='stampCard__details-box-detail'>
                            {% for origin in origins %}
                            {% if origin.id == stamp.origin_id %}
                            {{ origin.country }}
                            {% endif %}
                            {% endfor %}
                        </p>
                    </div>
                    <div class='stampCard__details-box'>
                        <p class='stampCard__details-box--label'>Condition</p>
                        <p class='stampCard__details-box-detail'>
                            {% for stamp_state in stamp_states %}
                            {% if stamp_state.id == stamp.stamp_state_id %}
                            {{ stamp_state.state }}
                            {% endif %}
                            {% endfor %}
                        </p>
                    </div>
                    <div class='stampCard__details-box'>
                        <p class='stampCard__details-box--label'>Tirage</p>
                        <p class='stampCard__details-box-detail'>{{stamp.print_run}}</p>
                    </div>
                    <div class='stampCard__details-box'>
                        <p class='stampCard__details-box--label'>Dimensions</p>
                        <p class='stampCard__details-box-detail'>{{stamp.dimensions}}</p>
                    </div>
                    <div class='stampCard__details-box'>
                        <p class='stampCard__details-box--label'>Certifié</p>
                        <p class='stampCard__details-box-detail'>{{stamp.certified}}</p>
                    </div>
                    <div class='stampCard__details-box stampCard__desciption'>
                        <p class='stampCard__details-box--label'>Desciption</p>
                        <p class='stampCard__details-box-detail'>{{stamp.description}}</p>
                    </div>
                </section>
                <!-- Détails de l'enchère -->
                <section class="auctionCard__box-details">
                    <section class="auctionCard__details">
                        <h3 class="auctionCard__details-title">{{auction.stamp.name}}</h3>
                        <div class="auctionCard__details-box">
                            <p class="auctionCard__details-box--label">Date de début</p>
                            <p class="auctionCard__details-box-detail">{{auction.start_date}}</p>
                        </div>
                        <div class="auctionCard__details-box">
                            <p class="auctionCard__details-box--label">Date de fin</p>
                            <p class="auctionCard__details-box-detail">{{auction.end_date}}</p>
                        </div>
                        <div class="auctionCard__details-box">
                            <p class="auctionCard__details-box--label">Prix de départ</p>
                            <p class="auctionCard__details-box-detail auctionCard__details-box--value">
                                {{auction.floor_price}} €
                            </p>
                        </div>
                        <div class="auctionCard__details-box">
                            <p class="auctionCard__details-box--label">Statut de l'enchère</p>
                            <p class="auctionCard__details-box-detail">{{status.state}}</p>
                        </div>
                    </section>

                    <!-- Timer de l'enchère -->
                    {% if auction.status_id == '1' %}
                    <section class="auctionCard__timer">
                        Fin de l'enchère dans : {{ auction.timer }}
                    </section>
                    {% endif %}
                </section>

                <!-- Liste des enchères placées -->
                <section id="bids-section" class="auctionCard__bids">
                    <h3 class="auctionCard__bids-title">Historique des enchères</h3>

                    {% if bids is not empty %}
                    <div class="auctionCard__bids-lastBid">
                        <div class="auctionCard__bids-lastBid-header">
                            <p>Utilisateur : </p>
                            <p>Prix : </p>
                        </div>
                        <div class="auctionCard__bids-lastBid-body">
                            <p>{{ biggestBidValue.user_name}}</p>
                            <p>{{ biggestBidValue.value }} €</p>
                        </div>
                    </div>




                    {% else %}
                    <p class="auctionCard__bids-empty">Aucune enchère placée pour cette enchère.</p>
                    {% endif %}
                </section>
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

                <!-- Actions -->
                <section class="auctionCard__auction">
                    {% if guest is empty %}
                    <form method="post" action="{{ base }}/auction/show?id={{auction.id}}"
                        class="auctionCard__auction-form">
                        <input type="hidden" name="id" value="{{ auction.id }}">

                        <label for="bidValue" class="auctionCard__auction-form-label">
                            <p>Valeur actuelle : </p>
                            <input type="number" name="value" id="bidValue" min="{{ auction.floor_price + 1 }}" step="5"
                                required value="{{biggestBidValue.value}}">
                        </label>

                        <button type="submit" class="auctionCard__button">Placer une enchère</button>
                    </form>
                    {% else %}
                    <p class="auctionCard__auction-status">Vous devez vous connecter pour participer.</p>
                    {% endif %}
                </section>
            </section>
        </article>

    </div>
</section>
{{ include('layouts/footer.php') }}