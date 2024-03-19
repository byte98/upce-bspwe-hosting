<?php

//
// DOMAINSERVICE.PHP
// File containing utility functions to work with domains.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting\Model\DREG\Services;

use SimpleHosting\Application;
use SimpleHosting\Model\DatabaseFactory;
use SimpleHosting\Model\DREG\Domain;
use SimpleHosting\Model\DREG\TLD;
use SimpleHosting\Model\DREG\Services\TLDService;

/**
 * Class which makes working with domains much easier.
 */
class DomainService{

    /**
     * Creates new domain.
     * @param string $name Name of domain.
     * @param TLD $tld TLD of domain.
     * @return Domain Newly created domain,
     *                or NULL if domain cannot be created.
     */
    public static function create(string $name, TLD $tld): ?Domain{
        $reti = NULL;
        $conn = DatabaseFactory::get();
        $query = "INSERT INTO DREG_DOMAINS (name, tld) VALUES ('" . pg_escape_string($conn, $name) . "', " . $tld->getId() . ") RETURNING id";
        Application::logger()->base("Performing query " . $query);
        $result = pg_query($conn, $query);
        if ($result){
            $row = pg_fetch_assoc($result);
            $id = $row["id"];
            $reti = new Domain($id, $name, $tld);
            Application::logger()->info("Domain '" . $name . "." . $tld->getName() . "' has been created.");
        }
        return $reti;
    }


    /**
     * Reads all available domains.
     * @return array Array with all available domains.
     */
    public static function read(): array{
        $reti = array();
        $conn = DatabaseFactory::get();
        $query = "SELECT * FROM DREG_DOMAINS";
        Application::logger()->base("Performing query " . $query);
        $result = pg_query($conn, $query);
        if ($result){
            while($row = pg_fetch_assoc($result)){
                $tld = TLDService::readById($row["tld"]);
                if ($tld != NULL){
                    array_push($reti, new Domain($row["id"], $row["name"], $tld));
                }
            }
        }
        else
        {
            Application::logger()->warning("Cannot read domains!");
        }
        return $reti;
    }

    /**
     * Reads domain by its identifier.
     * @param int $id Identifier of domain.
     * @return ?Domain Domain defined by its identifier,
     *                  or NULL if such domain does not exists.
     */
    public static function readById(int $id): ?Domain{
        $reti = NULL;
        $conn = DatabaseFactory::get();
        $query = "SELECT * FROM DREG_DOMAINS WHERE id=$id";
        Application::logger()->base("Performing query ". $query);
        $result = pg_query($conn, $query);
        if ($result){
            $row = pg_fetch_assoc($result);
            $tld = TLDService::readById($row["tld"]);
            if ($tld != NULL){
                $reti =  new Domain($row["id"], $row["name"], $tld);
            }
        }
        else{
            Application::logger()->error("Cannot find domain with id $id");
        }
        return $reti;
    }

    /**
     * Reads domain by its name.
     * @param string $name Name of domain.
     * @param TLD $tld TLD of domain.
     * @return ?Domain Domain defined by its name,
     *                 or NULL if such domain does not exists.
     */
    public static function readByName(string $name, TLD $tld): ?Domain{
        $reti = NULL;
        $conn = DatabaseFactory::get();
        $query = "SELECT * FROM DREG_DOMAINS WHERE name='" . pg_escape_string($conn, $name) . "' AND tld=" . $tld->getId();
        Application::logger()->base("Performing query ". $query);
        $result = pg_query($conn, $query);
        if ($result){
            $row = pg_fetch_assoc($result);
            $reti = new Domain($row["id"], $row["name"], $tld);
        }
        else{
            Application::logger()->info("Cannot find domain with name $name!");
        }
        return $reti;
    }

    /**
     * Updates domain in database.
     * @param Domain $domain Domain which will be updated.
     */
    public static function update(Domain $domain): void{
        $conn = DatabaseFactory::get();
        $query = "UPDATE DREG_DOMAINS SET name='" . pg_escape_string($conn, $domain->getName()) . "', tld=" . $domain->getTld()->getId() . " WHERE id=" . $domain->getId();
        Application::logger()->base("Performing query " . $query);
        $result = pg_query($conn, $query);
        if ($result){
            Application::logger()->info("Domain '" . $domain->getName() . "." . $domain->getTld()->getName() . "' has been updated.");
        }
        else{
            Application::logger()->error("Update of domain '" . $domain->getName() . "." . $domain->getTld()->getName() . "' failed!");
        }
    }

    /**
     * Deletes domain from database.
     * @param Domain $domain Domain which will be deleted.
     */
    public static function delete(Domain $domain): void{
        $conn = DatabaseFactory::get();
        $query = "DELETE FROM DREG_DOMAINS WHERE id=" . $domain->getId();
        $result = pg_query( $conn, $query);
        if ($result){
            Application::logger()->info("Domain '" . $domain->getName() . "." . $domain->getTld()->getName() . "' has been deleted.");
        }
        else{
            Application::logger()->error("Delete of domain '" . $domain->getName() . "." . $domain->getTld()->getName() . "' failed!");
        }
    }

}

?>
