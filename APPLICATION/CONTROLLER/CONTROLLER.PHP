<?php

// CONTROLLER.PHP
// File defining all other controllers of the application.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting\Controller;

/**
 * Interface abstracting all controllers of the application.
 */
interface Controller{

    /**
     * Takes control over application.
     */
    public function takeControl(): void;
}

?>
