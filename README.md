# Générations Sorciers – Le site web

Ce site est celui du projet [Générations Sorciers](https://generations-sorciers.fr)
pour lister l'ensemble des événements disponible et afficher lesquels étaient
_live_. Les dates et heures sont affichées dans le fuseau horaire local du navigateur.

Un export iCalendar est également disponible, afin d'avoir les événements dans
le calendrier.

## Technologie

Ce site est développé en PHP avec quelques modules installés via Composer. Pour
des raisons historiques de simplicité (le site ayant été développé dans de délais
très courts, sans CI au début, et devant être déployé sur Gandi Simple Hosting
qui ne permettait pas d'installer les dépendances côté serveur), les dépendances
sont directement dans le dépôt, mais elles sont gérées par Composer donc ce ne
serait pas nécessaire.

Côté interface graphique, le site utilise SASS et le framework Bulma, ainsi qu'un
soupçon de [VanillaJS](http://vanilla-js.com). Pour la même raison que plus haut,
le CSS compilé est directement dans le dépôt.

## Développement

### Interface

Pour compiler le SASS, lancer :

```shell
./build.sh
```

En développement, pour recompiler au moindre changement :

```shell
./build.sh watch
```

Ça active également les _source maps_ pour avoir les références des fichiers
SASS dans la console du navigateur, et ne compresse pas le CSS.

[SASS doit être installé.](https://sass-lang.com/install)

Ne pas oublier de compiler avant de commit en cas de changement :) .

### Backend

Les dépendances PHP sont gérées par Composer (le standard du marché).
Une fois installé (cf. site officiel),

```shell
composer install -a
```

permet de télécharger et d'installer les dépendances. Pour plus de
simplicité, les dépendances sont dans le dépôt, donc normalement y'a
rien à faire. Elles sont stockées dans le dossier vendor (il ne faut
pas y toucher !).

Composer gère également l'autoload, pour éviter d'avoir à require_once
toutes les classes. En cas d'ajout ou de déplacement de classes, comme
on utilise l'autoloader optimisé, il faut exécuter :

```shell
composer dump-autoload -a
```

L'extension PHP `intl` est nécessaire.

## Stockage des événements

Les événements sont dans `data/events.yaml`. C'est une liste d'objets
(reprendre le modèle existant, sans oublier le tiret de la liste)
avec ces propriétés possibles :

```yaml
- title: Le titre qui s'affiche en gros
  subtitle: Le sous-titre (facultatif, affiché moins gros dessous)
  streamer: Le nom du ou de la streamer/euse (affiché en dessous avec le lien) (facultatif si on ne veut pas mettre le streamer en avant)
  link: Un lien (https://…), ou juste un nom de chaîne twitch
  with: Texte écrit à côté du nom du streamer après le point de séparation (facultatif)
  description: |
    Une description qui peut s'étendre sur plusieurs lignes
    de l'événement. Elle sera affichée au clic sur l'événement, dans une zone à part.

    On peut vraiment prendre la place.
  date: 2021-04-26 20:00:00
  duration: 2 hours
  final: true/false (si true, l'événement sera affiché avec plus de marges et un fond différent).
  replay: Un lien vers la rediffusion de la diffusion (ce lien peut être ajouté avant que la diffusion n'ait lieue ; il ne sera affiché qu'une fois cette dernière terminée). 
```

Le format de `date` est n'importe quel format de date supporté par YAML (le
plus simple étant probablement `YYYY-MM-DD HH:mm`).

Le format de `duration` est du style de « 2 hours » ou « 30 minutes » ou une
combinaison (possible aussi d'utiliser days, years, months, mais je doute que
ce soit utile c: ).

Tous les champs qui acceptent du texte peuvent être
[formatés en Markdown](https://www.markdownguide.org/cheat-sheet/). Discord
utilise une version simplifiée du Markdown, donc ce qui marche sur Discord
marchera ici, mais certains trucs en plus comme des titres, listes, ou liens,
marcheront aussi. La seule différence est qu'en Markdown, il faut laisser une
ligne vide pour sauter une ligne.
