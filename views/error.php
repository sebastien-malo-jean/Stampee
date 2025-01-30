{{ include ('layouts/header.php', {title:'page des erreurs'})}}
<div class="general-container">
    <div class="container">

        <h2>Oups... Cette page est introuvable</h2>
        <p><strong class="error">{{ message }}</strong></p>
        <p>Il semble que la page que vous recherchez n'existe plus ou que l'URL soit incorrecte.</p>
        <p>Voici quelques options qui pourraient vous aider :</p>
        <ul>
            <li>Vérifiez l'adresse saisie</li>
            <li>Retournez à la page d'accueil</li>
            <li>Contactez-nous si vous avez besoin d’aide</li>
        </ul>
        <p>Nous vous remercions pour votre compréhension.</p>
    </div>
</div>
{{ include ('layouts/footer.php')}}