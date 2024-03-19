<?php

//
// DOMAINSERVICE.PHP
// File containing utility functions to work with domains.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting\Model\DREG\Services;

USE SimpleHosting\Application;
USE SimpleHosting\Model\DatabaseFactory;
USE SimpleHosting\Model\DREG\Domain;
USE SimpleHosting\Model\DREG\TLD;
USE SimpleHosting\Model\DREG\Services\TLDService;

/**
 * CLASS which makes working with domains much easier.
 */
CLASS DomainService{

    /**
     * Creates NEW domain.
     * @param string $name Name of domain.
     * @param TLD $tld TLD of domain.
     * @RETURN Domain Newly created domain,
     *                OR NULL IF domain cannot be created.
     */
    PUBLIC STATIC FUNCTION create(string $name, TLD $tld): ?Domain{
        $reti = NULL;
        $conn = DatabaseFactory::get();
        $query = "INSERT INTO DREG_DOMAINS (name, tld) VALUES ('" . pg_escape_string($conn, $name) . "', " . $tld->getId() . ") RETURNING id";
        Application::logger()->base("Performing query " . $query);
        $result = pg_query($conn, $query);
        IF ($result){
            $row = pg_fetch_assoc($result);
            $id = $row["id"];
            $reti = NEW Domain($id, $name, $tld);
            Application::logger()->info("Domain '" . $name . "." . $tld->getName() . "' has been created.");
        }
        RETURN $reti;
    }


    /**
     * Reads all available domains.
     * @RETURN ARRAY ARRAY with all available domains.
     */
    PUBLIC STATIC FUNCTION read(): ARRAY{
        $reti = ARRAY();
        $conn = DatabaseFactory::get();
        $query = "SELECT * FROM DREG_DOMAINS";
        Application::logger()->base("Performing query " . $query);
        $result = pg_query($conn, $query);
        IF ($result){
            WHILE($row = pg_fetch_assoc($result)){
                $tld = TLDService::readById($row["tld"]);
                IF ($tld != NULL){
                    array_push($reti, NEW Domain($row["id"], $row["name"], $tld));
                }
            }
        }
        ELSE
        {
            Application::logger()->warning("Cannot read domains!");
        }
        RETURN $reti;
    }

    /**
     * Reads domain by its identifier.
     * @param int $id Identifier of domain.
     * @RETURN ?Domain Domain defined by its identifier,
     *                  OR NULL IF such domain does not exists.
     */
    PUBLIC STATIC FUNCTION readById(int $id): ?Domain{
        $reti = NULL;
        $conn = DatabaseFactory::get();
        $query = "SELECT * FROM DREG_DOMAINS WHERE id=$id";
        Application::logger()->base("Performing query ". $query);
        $result = pg_query($conn, $query);
        IF ($result){
            $row = pg_fetch_assoc($result);
            $tld = TLDService::readById($row["tld"]);
            IF ($tld != NULL){
                $reti =  NEW Domain($row["id"], $row["name"], $tld);
            }
        }
        ELSE{
            Application::logger()->error("Cannot find domain with id $id");
        }
        RETURN $reti;
    }

    /**
     * Reads domain by its name.
     * @param string $name Name of domain.
     * @param TLD $tld TLD of domain.
     * @RETURN ?Domain Domain defined by its name,
     *                 OR NULL IF such domain does not exists.
     */
    PUBLIC STATIC FUNCTION readByName(string $name, TLD $tld): ?Domain{
        $reti = NULL;
        $conn = DatabaseFactory::get();
        $query = "SELECT * FROM DREG_DOMAINS WHERE name='" . pg_escape_string($conn, $name) . "' AND tld=" . $tld->getId();
        Application::logger()->base("Performing query ". $query);
        $result = pg_query($conn, $query);
        IF ($result){
            $row = pg_fetch_assoc($result);
            $reti = NEW Domain($row["id"], $row["name"], $tld);
        }
        ELSE{
            Application::logger()->info("Cannot find domain with name $name!");
        }
        RETURN $reti;
    }

    /**
     * Updates domain in database.
     * @param Domain $domain Domain which will be updated.
     */
    PUBLIC STATIC FUNCTION update(Domain $domain): void{
        $conn = DatabaseFactory::get();
        $query = "UPDATE DREG_DOMAINS SET name='" . pg_escape_string($conn, $domain->getName()) . "', tld=" . $domain->getTld()->getId() . " WHERE id=" . $domain->getId();
        Application::logger()->base("Performing query " . $query);
        $result = pg_query($conn, $query);
        IF ($result){
            Application::logger()->info("Domain '" . $domain->getName() . "." . $domain->getTld()->getName() . "' has been updated.");
        }
        ELSE{
            Application::logger()->error("Update of domain '" . $domain->getName() . "." . $domain->getTld()->getName() . "' failed!");
        }
    }

    /**
     * Deletes domain from database.
     * @param Domain $domain Domain which will be deleted.
     */
    PUBLIC STATIC FUNCTION delete(Domain $domain): void{
        $conn = DatabaseFactory::get();
        $query = "DELETE FROM DREG_DOMAINS WHERE id=" . $domain->getId();
        $result = pg_query( $conn, $query);
        IF ($result){
            Application::logger()->info("Domain '" . $domain->getName() . "." . $domain->getTld()->getName() . "' has been deleted.");
        }
        ELSE{
            Application::logger()->error("Delete of domain '" . $domain->getName() . "." . $domain->getTld()->getName() . "' failed!");
        }
    }

}

?>
