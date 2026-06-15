<?php
/**
 * Super back button partial template
 */

use Rosecrance\App\Fields\Util;

?>
<div id="go-back-button-container" class="go-back-button-container">
    <div class="uk-container uk-container-large uk-padding-remove">
        <div class="go-back-button">
            <button class="go-back-button__button btn">
                <?php
                    echo Util::getIconHTML('go-back');
                ?>
                <span>
                <?php
                    _e('Back to Results', 'rosecrance');
                ?>
                </span>
            </button>
        </div>
    </div>
</div>
