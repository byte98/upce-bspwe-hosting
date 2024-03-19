<?php

//
// TLDSERVICE.PHP
// File containing service functions to work with top level domains.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting\Model\DREG\Services;

USE SimpleHosting\Application;
USE SimpleHosting\Model\DREG\TLD;
USE SimpleHosting\Model\DatabaseFactory;

/**
 * CLASS which contains service functions to work with top level domains.
 */
CLASS TLDService{
    
    /**
     * Creates NEW top level domain.
     * @param string $name Name of top level domain.
     * @RETURN ?TLD NEW top level domain,
     *              OR NULL IF top level domain couldn't be created.
     */
    PUBLIC STATIC FUNCTION create(string $name): ?TLD{
        $reti = NULL;
        $conn = DatabaseFactory::get();
        $name = pg_escape_string($conn, $name);
        $query = "INSERT INTO DREG_TLDS (name) VALUES ('$name') RETURNING id";
        Application::logger()->base("Performing query " . $query);
        $result = pg_query($conn, $query);
        IF ($result){
            $row = pg_fetch_assoc($result);
            $id = $row["id"];
            $reti = NEW TLD($id, $name);
            Application::logger()->info("TLD '" . $name . "' has been created!");
        }
        RETURN $reti;
    }

    /**
     * Reads all available top level domains.
     * @RETURN ARRAY ARRAY with all available top level domains
     */
    PUBLIC STATIC FUNCTION read(): ARRAY{
        $reti = ARRAY();
        $conn = DatabaseFactory::get();
        $query = "SELECT * FROM DREG_TLDS";
        Application::logger()->base("Performing query " . $query);
        $result = pg_query($conn, $query);
        IF ($result){
            WHILE ($row = pg_fetch_assoc($result)) {
                array_push($reti, NEW TLD($row["id"], $row["name"]));
            }
        }
        ELSE{
            Application::logger()->error("Cannot read TLDs.!");
        }
        RETURN $reti;
    }

    /**
     * Reads top level domain by its identifier.
     * @param int $id Identifier of top level domain.
     * @RETURN ?TLD Top level domain,
     *              OR NULL IF such top level domain does not exists.
     */
    PUBLIC STATIC FUNCTION readById(int $id): ?TLD{
        $reti = NULL;
        $conn = DatabaseFactory::get();
        $query = "SELECT * FROM DREG_TLDS WHERE id=$id";
        Application::logger()->base("Performing query " . $query);
        $result = pg_query($conn, $query);
        IF ($result){
            $row = pg_fetch_assoc($result);
            $reti = NEW TLD($row["id"], $row["name"]);
        }
        ELSE
        {
            Application::logger()->warning("Cannot find TLD with id $id");
        }
        RETURN $reti;
    }

    /**
     * Reads top level domain by its name.
     * @param string $name Name of top level domain.
     * @RETURN ?TLD Top level domain,
     *              OR NULL IF such top level domain does not exists.
     */
    PUBLIC STATIC FUNCTION readByName(string $name): ?TLD{
        $reti = NULL;
        $conn = DatabaseFactory::get();
        $query = "SELECT * FROM DREG_TLDS WHERE name='" . pg_escape_string($conn, $name) . "'";
        Application::logger()->base("Performing query ". $query);
        $result = pg_query($conn, $query);
        IF ($result){
            $row = pg_fetch_assoc($result);
            $reti = NEW TLD($row["id"], $row["name"]);
        }
        ELSE{
            Application::logger()->info("Cannot find TLD with name $name");
        }
        RETURN $reti;
    }

    /**
     * Updates top level domain.
     * @param TLD $tld Top level domain which will be updated.
     */
    PUBLIC STATIC FUNCTION update(TLD $tld): void{
        $conn = DatabaseFactory::get();
        $query = "UPDATE DREG_TLDS SET name='" . pg_escape_string($conn, $tld->getName()) . "' WHERE id=" . $tld->getId();
        Application::logger()->base("Performing query " . $query);
        $result = pg_query( $conn, $query);
        IF ($result){
            Application::logger()->info("TLD '" . $tld->getName() . "' has been updated.");
        }
        ELSE{
            Application::logger()->error("Update of TLD '" . $tld->getName() . "' failed!");
        }
    }

    /**
     * Deletes top level domain.
     * @param TLD $tld Top level domain which will be deleted.
     */
    PUBLIC STATIC FUNCTION delete(TLD $tld): void{
        $conn = DatabaseFactory::get();
        $query = "DELETE FROM DREG_TLDS WHERE id=" . $tld->getId();
        $result = pg_query( $conn, $query);
        IF ($result){
            Application::logger()->info("TLD '" . $tld->getName() . "' has been deleted.");
        }
        ELSE{
            Application::logger()->error("Delete of TLD '". $tld->getName() . "' failed!");
        }
    }
}

?>
