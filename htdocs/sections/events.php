<?php
function twitch() {
    include "../svg/twitch.svg";
}
function caret() {
  include "../svg/caret.svg";
}
$film = file_get_contents("../svg/film.svg");

$fmt = new IntlDateFormatter(
    'fr_FR',
    IntlDateFormatter::FULL,
    IntlDateFormatter::FULL,
    'Europe/Paris',
    IntlDateFormatter::GREGORIAN,
    'EEEE d MMMM'
);

$tz = new DateTimeZone('Europe/Paris');
?>

<section class="section container gs-events" id="programme">
    <div class="columns is-desktop is-variable is-8">
        <div class="column is-3 is-12-touch">
            <div class="column-title-sticker">
                <h1><span>Demandez</span> le programme</h1>
                <aside class="current-timezone">
                    <p>Heure de <span id="timezone">Paris</span></p>
                </aside>
                <?php if ($events->has_hidden_events): ?>
                <aside>
                    <p>D'autres événements s'ajouteront…</p>
                </aside>
                <?php endif; ?>
                <aside class="calendar">
                    <p>
                    <details class="has-modal">
                        <summary>Ajouter à votre calendrier</summary>

                        <div class="modal is-active">
                            <div class="modal-background"></div>
                            <div class="modal-content">
                                <div class="box">
                                    <article class="content">
                                        <h3>Ajouter les streams à mon agenda</h3>
                                        <p>
                                            Vous pouvez ajouter les streams de Générations Sorciers à votre agenda. Ils
                                            seront automatiquement mis à jour ! Ajoutez un agenda externe depuis une URL,
                                            et entrez l'adresse suivante :
                                        </p>
                                        <pre class="cal-url">https://generations-sorciers.fr/?streams.ics</pre>
                                        <p>
                                            Vous pouvez aussi <a href="/?streams.ics">télécharger le calendrier directement</a>,
                                            mais il ne sera pas synchronisé en cas de changements.
                                        </p>
                                    </article>
                                </div>
                            </div>
                            <button class="modal-close is-large" aria-label="close"></button>
                        </div>
                    </details>
                    </p>
                </aside>
            </div>
        </div>

        <div class="column is-events-list">
            <?php foreach ($events->events as $day => $day_events): ?>
                <?php $day_date = DateTime::createFromFormat('Y-m-d', $day, $tz)->setTime(23, 0) ?>
                <h2>
                    <time datetime="<?php echo $day_date->format(DATE_ISO8601) ?>" class="has-auto-timezone is-date"><?php echo ucfirst($fmt->format($day_date)) ?></time>
                </h2>

                <?php /** @var \PogScience\Event $event */
                foreach ($day_events as $event): ?>

                    <article class="box<?php if ($event->final) echo ' is-final' ?><?php if ($event->past() && !$events->all_finished) echo ' is-past' ?>">
                        <details>
                            <summary>
                                <time datetime="<?php echo $event->dateISO() ?>" class="has-auto-timezone">
                                    <?php echo $event->hour() ?>
                                </time>

                                <div class="is-event-description">
                                    <h3>
                                        <?php if ($event->live()): ?><a href="<?php echo $event->link ?>" class="live" title="<?php echo strip_tags($event->streamer) ?> est actuellement en direct ! Cliquez pour accéder au live">LIVE</a><?php endif; ?>
                                        <?php if ($event->hidden): ?>[NON PUBLIÉ]<?php endif; ?>
                                        <a href="<?php echo $event->past() && $event->replay ? $event->replay : $event->link ?>"><?php echo $event->title ?></a>
                                    </h3>

                                    <?php if ($event->subtitle): ?>
                                    <p class="subtitle"><?php echo $event->subtitle ?></p>
                                    <?php endif ?>

                                    <p class="streamers">
                                        <?php
                                        $meta_items = [];
                                        if ($event->streamer) {
                                            $meta_items[] = '<a href="' . $event->link . '">' . $event->streamer . '</a>';
                                        }
                                        if ($event->with) {
                                            $meta_items[] = $event->with;
                                        }
                                        if ($event->replay && $event->past()) {
                                            $meta_items[] = '<a href="' . $event->replay . '" class="replay">' . $film . '&nbsp;Rediffusion</a>';
                                        }
                                        echo join(" &nbsp;&middot;&nbsp; ", $meta_items);
                                        ?>
                                    </p>
                                </div>

                                <aside>
                                    <time datetime="<?php echo $event->dateISO() ?>" class="is-mobile-time has-auto-timezone has-real-day-prepended" aria-hidden="true"><?php echo $event->hour() ?></time>

                                    <a href="<?php echo $event->link ?>" class="<?php if (!$event->icon): ?>button is-primary is-large<?php endif; ?>" title="Aller sur la chaîne sur Twitch<?php if($event->streamer): ?> de <?php echo strip_tags($event->streamer) ?><?php endif; ?>">
                                        <?php if ($event->icon): ?>
                                            <span class="streamer-icon">
                                                <img src="<?php echo $event->icon ?>" alt="<?php echo strip_tags($event->streamer) ?>" />
                                            </span>
                                        <?php else: ?>
                                            <span class="icon is-large">
                                            <?php twitch(); ?>
                                            </span>
                                        <?php endif; ?>
                                    </a>

                                    <span class="icon is-caret">
                                        <?php caret(); ?>
                                    </span>
                                </aside>
                            </summary>

                            <div class="content">
                                <?php echo $event->description ?>
                                <p class="meta">
                                    De <time datetime="<?php echo $event->dateISO() ?>" class="has-auto-timezone has-real-day-prepended"><?php echo $event->hour() ?></time>
                                    à <time datetime="<?php echo $event->endDateISO() ?>" class="has-auto-timezone has-real-day-prepended"><?php echo $event->hour_end() ?></time>
                                    (<?php echo $event->duration->h > 1 ? $event->duration->h . ' heures' : 'une heure'; if ($event->duration->i > 0): echo $event->duration->format(' et %i minutes'); endif; ?>).
                                </p>
                            </div>
                        </details>
                    </article>

                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
