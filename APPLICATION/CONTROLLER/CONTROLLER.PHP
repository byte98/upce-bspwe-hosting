<?php

// CONTROLLER.PHP
// File defining all other controllers of the application.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting\Controller;

/**
 * INTERFACE abstracting all controllers of the application.
 */
INTERFACE Controller{

    /**
     * Handles HTTP get request.
     * @param ARRAY $data Data of request.
     */
    PUBLIC FUNCTION get(ARRAY $data): void;

    /**
     * Handles HTTP post request.
     * @param ARRAY $data Data of request.
     */
    PUBLIC FUNCTION post(ARRAY $data): void;
}

?>
