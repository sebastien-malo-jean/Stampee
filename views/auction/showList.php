{{ include('layouts/header.php', { title: "Liste des enchères" }) }}
<div class="auction-page">

    {{ include('layouts/filter.php', { origins: origins, stamp_states: stamp_states }) }}


    <section class="content__frame-auction-page">
        <header class="content__frame-header">
            <h1 class="content__frame-title">Les enchères</h1>
            <h2 class="content__frame-under-title">La liste des enchères</h2>
        </header>
        <div class="cards__box">
            {% for a in auctions %}
            {{include('layouts/card.php', {
                images: a.images,
                auction: a.auction,
                stamp: a.stamp,
                biggestBidValue: a.biggestBidValue,
                bids: a.bids
                 })}}
            {% endfor %}

        </div>
    </section>
</div>
</div>
{{ include('layouts/footer.php') }}