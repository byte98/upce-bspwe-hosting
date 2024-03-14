<?php

//
// TLD.PHP
// File containing data definition of top level domains.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting\Model\DREG;

/**
 * Class representing top level domain.
 */
class TLD{

    /**
     * Identifier of top level domain in database.
     */
    private int $id;

    /**
     * Name of top level domain.
     */
    private string $name;

    /**
     * Creates new top level domain.
     * @param int $id Identifier of top level domain in database.
     * @param string $name Name of top level domain.
     */
    public function __construct(int $id, string $name){
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Gets identifier of top level domain in database.
     * @return int Identifier of top level domain in database.
     */
    public function getId(): int{
        return $this->id;
    }

    /**
     * Sets new name of top level domain.
     * @param string $name New name of top level domain.
     */
    public function setName(string $name){
        $this->name = $name;
    }

    /**
     * Gets name of top level domain.
     * @return string Name of top level domain.
     */
    public function getName(): string{
        return $this->name;
    }

}

?>
