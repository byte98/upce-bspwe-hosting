<?php

//
// HOMEPAGECONTROLLER.PHP
// File containing definition of controller of homepage of application.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting\Controller;

use SimpleHosting\Controller\Controller;
use SimpleHosting\Model\DREG\DREG;

/**
 * Class representing controller of main page of application.
 */
class HomePageController implements Controller {

    public function get(array $data): void{
        $_TEMP =  array();
        $_TEMP["tlds"] = $this->getTLDs();

    }

    public function post(array $data): void{
    }

    /**
     * Gets top level domains as strings.
     * @return array Array with top level domains as strings.
     */
    private function getTLDs(): array{
        $reti = array();
        $tlds = DREG::getTLDs();
        foreach($tlds as $tld){
            array_push($reti, "." . $tld->getName());
        }
        return $reti;
    }
}

?>
