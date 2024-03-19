<?php

//
// TLD.PHP
// File containing data definition of top level domains.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting\Model\DREG;

/**
 * CLASS representing top level domain.
 */
CLASS TLD{

    /**
     * Identifier of top level domain in database.
     */
    PRIVATE int $id;

    /**
     * Name of top level domain.
     */
    PRIVATE string $name;

    /**
     * Creates NEW top level domain.
     * @param int $id Identifier of top level domain in database.
     * @param string $name Name of top level domain.
     */
    PUBLIC FUNCTION __construct(int $id, string $name){
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Gets identifier of top level domain in database.
     * @RETURN int Identifier of top level domain in database.
     */
    PUBLIC FUNCTION getId(): int{
        RETURN $this->id;
    }

    /**
     * Sets NEW name of top level domain.
     * @param string $name NEW name of top level domain.
     */
    PUBLIC FUNCTION setName(string $name){
        $this->name = $name;
    }

    /**
     * Gets name of top level domain.
     * @RETURN string Name of top level domain.
     */
    PUBLIC FUNCTION getName(): string{
        RETURN $this->name;
    }

}

?>
