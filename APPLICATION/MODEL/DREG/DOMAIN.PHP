<?php

//
// DOMAIN.PHP
// File containing data definition of domain.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Parubice
//

namespace SimpleHosting\Model\DREG;

use SimpleHosting\Model\DREG\TLD;

/**
 * Class representing one domain name.
 */
class Domain{

    /**
     * Identifier of domain in database.
     */
    private int $id;

    /**
     * Name of domain.
     */
    private string $name;

    /**
     * TLD to which is domain associated to.
     */
    private TLD $tld;

    /**
     * Creates new domain.
     * @param int $id Identifier of domain in database.
     * @param string $name Name of domain.
     * @param TLD $tld TLD to which is domain associated to.
     */
    public function __construct(int $id, string $name, TLD $tld){
        $this->id = $id;
        $this->name = $name;
        $this->tld = $tld;
    }

    /**
     * Gets identifier of domain in database.
     * @return int Identifier of domain in database.
     */
    public function getId(): int{
        return $this->id;
    }

    /**
     * Gets name of domain.
     * @return string Name of domain.
     */
    public function getName(): string{
        return $this->name;
    }

    /**
     * Sets name of domain.
     * @param string $name New name of domain.
     */
    public function setName(string $name): void{
        $this->name = $name;
    }

    /**
     * Gets TLD to which is domain associated to.
     * @return TLD TLD to which is domain associated to.
     */
    public function getTLD(): TLD{
        return $this->tld;
    }

    /**
     * Sets TLD to which is domain associated to.
     * @param TLD $tld New TLD to which is domain associated to.
     */
    public function setTLD(TLD $tld): void{
        $this->tld = $tld;
    }

}

?>
