<?php

//
// HOMEPAGECONTROLLER.PHP
// File containing definition of controller of homepage of application.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting\Controller;

USE SimpleHosting\Controller\Controller;
USE SimpleHosting\Model\DREG\DREG;

/**
 * CLASS representing controller of main page of application.
 */
CLASS HomePageController IMPLEMENTS Controller {

    PUBLIC FUNCTION get(ARRAY $data): void{
        $_TEMP =  ARRAY();
        $_TEMP["tlds"] = $this->getTLDs();

    }

    PUBLIC FUNCTION post(ARRAY $data): void{
    }

    /**
     * Gets top level domains AS strings.
     * @RETURN ARRAY ARRAY with top level domains AS strings.
     */
    PRIVATE FUNCTION getTLDs(): ARRAY{
        $reti = ARRAY();
        $tlds = DREG::getTLDs();
        FOREACH($tlds AS $tld){
            array_push($reti, "." . $tld->getName());
        }
        RETURN $reti;
    }
}

?>
