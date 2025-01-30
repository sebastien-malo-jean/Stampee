<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="author" content="Sebastien Malo Jean">
    <meta name="description" content="">
    <meta charset='UTF-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset}}css/styles.css">
    <script type="module" src="{{asset}}js/main.js" defer></script>
    <title>{{title}}</title>
</head>

<body>

    <header class='header'>
        <div class='header__logo'>
            <a href='{{base}}/home' class='header__logo-link'>
                <img src='{{asset}}/img/logo/logo-2-alt.png' alt='logo Stampee' class='header__logo-img'>
            </a>
        </div>
        <nav class='header__nav'>
            <ul class='header__menu'>
                <li class='header__menu-item'><a href='' class='header__menu-link'>Enchères</a></li>
                <li class='header__menu-item'><a href='' class='header__menu-link'>Favoris</a></li>

            </ul>
            <ul class='header__devise'>
                <li class='header__devise-item'>
                    <label for='devise' class='header__devise-item-label'>devise</label>
                    <select name='devise' id='devise'>
                        <option value='#UK'>Angleterre £</option>
                        <option value='#CA'>Canada $</option>
                        <option value='#USA'>États-Unis $</option>
                        <option value='#AU'>Australie $</option>
                    </select>
                </li>
            </ul>
        </nav>
        <section class='header__connexion'>
            <ul class='header__connexion-list'>
                {% if guest %}
                <li class='header__connexion-list-item'>
                    <a href='{{base}}/login' class='header__connexion-link btn'>Connection</a>
                </li>
                <li class='header__connexion-list-item'>
                    <a href='{{base}}/user/create' class='header__connexion-link btn btn__CTA'>Inscription</a>
                </li>
                {% else %}
                <p>
                    {% if guest is empty %}
                    Hello {{ session.user_name }}!
                    {% endif %}
                </p>
                <li class='header__connexion-list-item'>
                    <a href='' class='header__connexion-link btn'>Profil</a>
                </li>
                <li class='header__connexion-list-item'>
                    <a href='{{base}}/logout' class='header__connexion-link btn'>Déconnection</a>
                </li>
                {% endif %}
            </ul>
            <form action=''>
                <label for='recherche' class='header__connexion-label'><span class='header__hidden'>Recherche</span>
                    <input type='text' id='recherche' name='recherche' class='header__searchBar'
                        placeholder='Recherche...'>
                </label>
            </form>
        </section>
    </header>
    <main>