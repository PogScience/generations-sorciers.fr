<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Générations Sorciers, un événement PogScience</title>

    <link rel="preconnect" href="https://fonts.gstatic.com"/>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css"/>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;1,400;1,500&family=Rubik:ital,wght@0,400;0,500;1,400;1,500&display=swap"/>
    <link rel="stylesheet" href="assets/generations-sorciers.min.css"/>

    <!-- Primary Meta Tags -->
    <meta name="title" content="Générations Sorciers, un événement PogScience">
    <meta name="description"
          content="Générations Sorciers, c'est 8 jours où des émissions de vulgarisation sur l'héritage de C'est Pas Sorcier vont se succéder, avec l'équipe originale !">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://generations-sorciers.fr/">
    <meta property="og:title" content="Générations Sorciers, un événement PogScience">
    <meta property="og:description"
          content="Générations Sorciers, c'est 8 jours où des émissions de vulgarisation sur l'héritage de C'est Pas Sorcier vont se succéder, avec l'équipe originale !">
    <meta property="og:image" content="https://generations-sorciers.fr/assets/logo.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://generations-sorciers.fr/">
    <meta property="twitter:title" content="Générations Sorciers, un événement PogScience">
    <meta property="twitter:description"
          content="Générations Sorciers, c'est 8 jours où des émissions de vulgarisation sur l'héritage de C'est Pas Sorcier vont se succéder, avec l'équipe originale !">
    <meta property="twitter:image" content="https://generations-sorciers.fr/assets/logo.png">
</head>

<body>

<?php
    if (isset($_GET['preview']) && $_GET['preview'] === "997d097f") {
        define("GS_PREVIEW", "true");
    }

    include "sections/description.php";

    if (defined("GS_PREVIEW")) {
      include "sections/events.php";
    }

    include "sections/networks.php";
?>

<!-- Matomo -->
<script type="text/javascript">
    var _paq = window._paq = window._paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function () {
        var u = "https://generationssorciers.matomo.cloud/";
        _paq.push(['setTrackerUrl', u + 'matomo.php']);
        _paq.push(['setSiteId', '1']);
        var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
        g.type = 'text/javascript';
        g.async = true;
        g.src = '//cdn.matomo.cloud/generationssorciers.matomo.cloud/matomo.js';
        s.parentNode.insertBefore(g, s);
    })();
</script>
</body>
</html>
