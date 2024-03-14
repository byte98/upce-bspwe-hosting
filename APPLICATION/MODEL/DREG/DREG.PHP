<?php

//
// DREG.PHP
// File containing definition of API methods for DREG (domain registry).
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting\Model\DREG;


use SimpleHosting\Model\DREG\Services\TLDService;
use SimpleHosting\Model\DREG\Services\DomainService;

/**
 * Class containing API methods for DREG (domain registry).
 */
class DREG{

    /**
     * Gets all available TLDs from domain registry.
     * @return array Array with all available TLDs.
     */
    public static function getTLDs(): array{
        return TLDService::read();
    }

    /**
     * Checks, if domain is free.
     * @param string $tld TLD name.
     * @param string $domain Domain name.
     * @return bool TRUE if domain is free,
     *              FALSE otherwise.
     */
    public static function isDomainFree(string $domain, string $tld): bool{
        $reti = true;
        $dataTLD = TLDService::readByName($tld);
        if ($dataTLD != NULL){
            $reti = (DomainService::readByName($domain, $dataTLD) == NULL);
        }
        else
        {
            $reti = false;
        }
        return $reti;
    }

    /**
     * Creates new domain.
     * @param string $domain Domain name.
     * @param string $tld TLD name.
     * @return ?Domain Newly created domain,
     *                 or NULL if domain cannot be created.
     */
    public static function createDomain(string $domain, string $tld): ?Domain{
        $reti = NULL;
        $dataTLD = TLDService::readByName($tld);
        if ($dataTLD != NULL){
            $reti = DomainService::create($domain, $dataTLD);
        }
        return $reti;
    }
}

?>
