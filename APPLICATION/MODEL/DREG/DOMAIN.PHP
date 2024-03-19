<?php

//
// DOMAIN.PHP
// File containing data definition of domain.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Parubice
//

NAMESPACE SimpleHosting\Model\DREG;

USE SimpleHosting\Model\DREG\TLD;

/**
 * CLASS representing one domain name.
 */
CLASS Domain{

    /**
     * Identifier of domain in database.
     */
    PRIVATE int $id;

    /**
     * Name of domain.
     */
    PRIVATE string $name;

    /**
     * TLD to which is domain associated to.
     */
    PRIVATE TLD $tld;

    /**
     * Creates NEW domain.
     * @param int $id Identifier of domain in database.
     * @param string $name Name of domain.
     * @param TLD $tld TLD to which is domain associated to.
     */
    PUBLIC FUNCTION __construct(int $id, string $name, TLD $tld){
        $this->id = $id;
        $this->name = $name;
        $this->tld = $tld;
    }

    /**
     * Gets identifier of domain in database.
     * @RETURN int Identifier of domain in database.
     */
    PUBLIC FUNCTION getId(): int{
        RETURN $this->id;
    }

    /**
     * Gets name of domain.
     * @RETURN string Name of domain.
     */
    PUBLIC FUNCTION getName(): string{
        RETURN $this->name;
    }

    /**
     * Sets name of domain.
     * @param string $name NEW name of domain.
     */
    PUBLIC FUNCTION setName(string $name): void{
        $this->name = $name;
    }

    /**
     * Gets TLD to which is domain associated to.
     * @RETURN TLD TLD to which is domain associated to.
     */
    PUBLIC FUNCTION getTLD(): TLD{
        RETURN $this->tld;
    }

    /**
     * Sets TLD to which is domain associated to.
     * @param TLD $tld NEW TLD to which is domain associated to.
     */
    PUBLIC FUNCTION setTLD(TLD $tld): void{
        $this->tld = $tld;
    }

}

?>
