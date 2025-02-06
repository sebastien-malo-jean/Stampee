<a href="{{ base }}/auction/show?id={{ auction.id }}" class='littleCard'>
    <div class='littleCard__picture'>
        <img src='{{ images[0].url }}' alt='Collection de timbres rares - Série 1940' class='littleCard__img'>
    </div>
    <div class='littleCard__detail'>
        <p class='littleCard__title'>{{ stamp.name }}</p>
        <p class='littleCard__price'>prix : {{biggestBidValue.value}} €</p>
        <div class='littleCard__auction-timeDetail'>
            <p class='littleCard__auction-timeLeft'>{{ auction.end_date }}</p>
            <p class='littleCard__auction-bidPlaced'>{{ bids|length }}</p>
        </div>
    </div>
</a>