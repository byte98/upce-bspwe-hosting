<?php

//
// DREG.PHP
// File containing definition of API methods FOR DREG (domain registry).
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting\Model\DREG;


USE SimpleHosting\Model\DREG\Services\TLDService;
USE SimpleHosting\Model\DREG\Services\DomainService;

/**
 * CLASS containing API methods FOR DREG (domain registry).
 */
CLASS DREG{

    /**
     * Gets all available TLDs from domain registry.
     * @RETURN ARRAY ARRAY with all available TLDs.
     */
    PUBLIC STATIC FUNCTION getTLDs(): ARRAY{
        RETURN TLDService::read();
    }

    /**
     * Checks, IF domain is free.
     * @param string $tld TLD name.
     * @param string $domain Domain name.
     * @RETURN bool TRUE IF domain is free,
     *              FALSE otherwise.
     */
    PUBLIC STATIC FUNCTION isDomainFree(string $domain, string $tld): bool{
        $reti = true;
        $dataTLD = TLDService::readByName($tld);
        IF ($dataTLD != NULL){
            $reti = (DomainService::readByName($domain, $dataTLD) == NULL);
        }
        ELSE
        {
            $reti = false;
        }
        RETURN $reti;
    }

    /**
     * Creates NEW domain.
     * @param string $domain Domain name.
     * @param string $tld TLD name.
     * @RETURN ?Domain Newly created domain,
     *                 OR NULL IF domain cannot be created.
     */
    PUBLIC STATIC FUNCTION createDomain(string $domain, string $tld): ?Domain{
        $reti = NULL;
        $dataTLD = TLDService::readByName($tld);
        IF ($dataTLD != NULL){
            $reti = DomainService::create($domain, $dataTLD);
        }
        RETURN $reti;
    }
}

?>
