{{ include('layouts/header.php', { title: 'Vue sur le timbre' }) }}

<section class="content__frame">
    <div class="content__frame-stampCard-page">
        <h1 class="content__frame-title">Detail du timbre</h1>
        <h2 class="content__frame-under-title">{{stamp.name}}</h2>

        <article class='stampCard'>
            <section class='stampCard__gallery'>
                <figure class='stampCard__gallery-figure'>
                    <img id='main_img' src='{{ images[0].url }}' alt='image principale'
                        class='stampCard__gallery-figure--img'>
                </figure>
                <div class='stampCard__gallery-thumbnails'>
                    {% for image in images %}
                    <img src='{{ image.url }}' alt='{{ image.name }}' class='stampCard__gallery-thumbnails--img'>
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
                        <p class='stampCard__details-box-detail'>{{stamp.color_id}}</p>
                    </div>
                    <div class='stampCard__details-box'>
                        <p class='stampCard__details-box--label'>Pays d'origine</p>
                        <p class='stampCard__details-box-detail'>{{stamp.origin_id}}</p>
                    </div>
                    <div class='stampCard__details-box'>
                        <p class='stampCard__details-box--label'>Condition</p>
                        <p class='stampCard__details-box-detail'>{{stamp.stamp_state_id}}</p>
                    </div>
                    <div class='stampCard__details-box'>
                        <p class='stampCard__details-box--label'>Tirage</p>
                        <p class='stampCard__details-box-detail'>{{stamp.print_run}}</p>
                    </div>
                    <div class='stampCard__details-box'>
                        <p class='stampCard__details-box--label'>Dimensions</p>
                        <p class='stampCard__details-box-detail'>{{stamp.dimension}}</p>
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
                <section class='stampCard__auction'>
                    <button class='stampCard__button'>Misé</button>
                </section>
            </section>
        </article>

    </div>
</section>

{{ include('layouts/footer.php') }}