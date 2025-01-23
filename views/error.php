{{ include ('layouts/header.php', {title:'page des erreurs'})}}
<div class="container">
    <h2>Error</h2>
    <strong class="error">{{ message }}</strong>
</div>
{{ include ('layouts/footer.php')}}