<?php
use Native5\Control\DefaultController;

class errorController extends DefaultController {
    public function _default($request) {
        echo '<h3>Invalid route specified</h3>';
    }
}
?>
