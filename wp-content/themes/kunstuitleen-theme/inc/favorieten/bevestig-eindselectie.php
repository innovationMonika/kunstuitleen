<section class="content-container" id="confirm-favorite-selection">
    <section class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-center text-md-right text-lg-right">
                
                <p>Geselecteerd: <span class="favorite-selection-count">0</span> van maximaal <?php echo $maxSelection; ?></p>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-center text-md-left text-lg-left">
                <a href="<?php echo get_permalink($confirmID); ?>" class="button secondary">
                    Reserveer mijn favorieten <?php locate_template('static/images/favorieten-step_mijn-favorieten.svg', true, false); ?>
                </a>
            </div>
        </div>
    </section>
</section>