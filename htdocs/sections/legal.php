<footer class="footer">
    <p>
        <a href="https://collectifconscience.org/pogscience/">PogScience</a>, 2021 —
        Site développé par <a href="https://amaury.carrade.eu">Amaury Carrade</a>, avec l'aide de
        <a href="https://www.qtg.fr/">Flo de QTG</a>, <a href="https://twitter.com/der_7e_schatten">Der Siebte Schatten</a>
        et Alexandre Arrivé
    </p>

    <details class="has-modal">
        <summary>Mentions légales</summary>

        <div class="modal is-active">
            <div class="modal-background"></div>
            <div class="modal-content">
                <div class="box">
                    <article class="content">
                        <p>
                            Le site <em>Générations Sorciers</em> a été développé par Amaury Carrade, Flo de QTG, Der Siebte
                            Schatten et Alexandre Arrivé pour PogScience, à l'occasion de l'événement éponyme.
                        </p>
                        <p>
                            Le site est hébergé par Gandi.
                        </p>
                        <address>
                            <strong>Gandi SAS</strong><br />
                            63, 65 Boulevard Massena<br />
                            75013 Paris<br />
                            France<br />
                            Tel : +33170377661
                        </address>
                        <p>
                            Directeur de la publication : Théo Silvagno.
                        </p>

                        <h3>Cookies et données personnelles</h3>
                        <p>
                            Nous déposons un cookie de mesure d'audience via Matomo, une solution open-source. Matomo
                            est configuré de façon à ne pas stocker de données personnelles, dans le strict respect
                            du RGPD.
                        </p>
                        <p>
                            Ce site inclue des contenus tiers provenant de Twitter, Inc. et Discord, Inc., qui peuvent
                            déposer des cookies. Ces contenus sont intégrés en demandant la désactivation du suivi.
                        </p>
                    </article>
                </div>
            </div>
            <button class="modal-close is-large" aria-label="close"></button>
        </div>
    </details>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll("details.has-modal").forEach(modal => {
            const closers = modal.querySelectorAll(".modal-background, .modal-close")
            closers.forEach(closer => closer.addEventListener("click", () => {
                modal.removeAttribute("open")
            }))
        })
    })
</script>
