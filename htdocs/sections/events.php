<?php
function twitch() {
    include "../svg/twitch.svg";
}
function caret() {
  include "../svg/caret.svg";
}
?>

<section class="section container gs-events" id="programme">
    <div class="columns is-variable is-8">
        <div class="column is-3">
            <h1><span>Demandez</span> le programme</h1>
        </div>
        <div class="column is-events-list">
            <h2>Lundi 26 avril</h2>

            <article class="box">
                <details>
                    <summary>
                        <time datetime="">
                            20h
                        </time>

                        <div class="is-event-description">
                            <h3><span class="live">LIVE</span> La littérature comme réconfort</h3>
                            <p class="streamers">
                                <a href="#">Professeur Klotho</a>
                                &nbsp;&middot;&nbsp;
                                Avec Sabine Quindou et Valérie Guerlain
                            </p>
                        </div>

                        <aside>
                            <time datetime="" class="is-mobile-time" aria-hidden="true">20h</time>

                            <a href="#" class="button is-primary is-large" title="Aller sur la chaîne sur Twitch">
                              <span class="icon is-large">
                                <?php twitch(); ?>
                              </span>
                            </a>

                            <span class="icon is-caret">
                                <?php caret(); ?>
                            </span>
                        </aside>
                    </summary>

                    <div class="content">
                        <p>Les livres ou textes feel good, avec commentaire de textes et/ou anecdotes.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam assumenda dignissimos eius enim eos exercitationem expedita facilis ipsum maiores minima mollitia pariatur perferendis quaerat, quos rerum sed sequi ullam voluptatibus.</p>
                    </div>
                </details>
            </article>

            <article class="box">
                <details>
                    <summary>
                        <time datetime="">
                            22h30
                        </time>

                        <div class="is-event-description">
                            <h3>La littérature comme révolution communiste stalinienne (long titre de test)</h3>
                            <p class="streamers">
                                <a href="#">Professeur Klotho</a>
                                &nbsp;&middot;&nbsp;
                                Avec Sabine Quindou et Valérie Guerlain et Sabine Quindou et Valérie Guerlain et Sabine
                                Quindou et Valérie Guerlain.
                            </p>
                        </div>

                        <aside>
                            <time datetime="" class="is-mobile-time" aria-hidden="true">22h30</time>

                            <a href="#" class="button is-primary is-large" title="Aller sur la chaîne sur Twitch">
                              <span class="icon is-large">
                                <?php twitch(); ?>
                              </span>
                            </a>
                            <span class="icon is-caret">
                                <?php caret(); ?>
                            </span>
                        </aside>
                    </summary>

                    <div class="content">
                        <p>Les livres ou textes feel good, avec commentaire de textes et/ou anecdotes.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam assumenda dignissimos eius enim eos exercitationem expedita facilis ipsum maiores minima mollitia pariatur perferendis quaerat, quos rerum sed sequi ullam voluptatibus.</p>
                    </div>
                </details>
            </article>

            <h2>Lundi 03 mars</h2>

            <article class="box is-final">
                <details>
                    <summary>
                        <time datetime="">
                            20h
                        </time>

                        <div class="is-event-description">
                            <h3><span class="live">LIVE</span> Sorciers Solidaires</h3>
                            <p class="subtitle">La libre-antenne de clôture avec tout le monde !</p>
                            <p class="streamers">
                                Avec Jamy Gourmaud, Fred Courant, Sabine Quindou, Valérie Guerlain (la petite voix), …
                            </p>
                        </div>

                        <aside>
                            <time datetime="" class="is-mobile-time" aria-hidden="true">20h</time>

                            <a href="#" class="button is-primary is-large" title="Aller sur la chaîne sur Twitch">
                              <span class="icon is-large">
                                <?php twitch(); ?>
                              </span>
                            </a>
                            <span class="icon is-caret">
                                <?php caret(); ?>
                            </span>
                        </aside>
                    </summary>

                    <div class="content">
                        <p>Les livres ou textes feel good, avec commentaire de textes et/ou anecdotes.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam assumenda dignissimos eius enim eos exercitationem expedita facilis ipsum maiores minima mollitia pariatur perferendis quaerat, quos rerum sed sequi ullam voluptatibus.</p>
                    </div>
                </details>
            </article>
        </div>
    </div>
</section>
