<?php

//
// TLDSERVICE.PHP
// File containing service functions to work with top level domains.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting\Model\DREG\Services;

use SimpleHosting\Application;
use SimpleHosting\Model\DREG\TLD;
use SimpleHosting\Model\DatabaseFactory;

/**
 * Class which contains service functions to work with top level domains.
 */
class TLDService{
    
    /**
     * Creates new top level domain.
     * @param string $name Name of top level domain.
     * @return ?TLD New top level domain,
     *              or NULL if top level domain couldn't be created.
     */
    public static function create(string $name): ?TLD{
        $reti = NULL;
        $conn = DatabaseFactory::get();
        $name = pg_escape_string($conn, $name);
        $query = "INSERT INTO DREG_TLDS (name) VALUES ('$name') RETURNING id";
        Application::logger()->base("Performing query " . $query);
        $result = pg_query($conn, $query);
        if ($result){
            $row = pg_fetch_assoc($result);
            $id = $row["id"];
            $reti = new TLD($id, $name);
            Application::logger()->info("TLD '" . $name . "' has been created!");
        }
        return $reti;
    }

    /**
     * Reads all available top level domains.
     * @return array Array with all available top level domains
     */
    public static function read(): array{
        $reti = array();
        $conn = DatabaseFactory::get();
        $query = "SELECT * FROM DREG_TLDS";
        Application::logger()->base("Performing query " . $query);
        $result = pg_query($conn, $query);
        if ($result){
            while ($row = pg_fetch_assoc($result)) {
                array_push($reti, new TLD($row["id"], $row["name"]));
            }
        }
        else{
            Application::logger()->error("Cannot read TLDs.!");
        }
        return $reti;
    }

    /**
     * Reads top level domain by its identifier.
     * @param int $id Identifier of top level domain.
     * @return ?TLD Top level domain,
     *              or NULL if such top level domain does not exists.
     */
    public static function readById(int $id): ?TLD{
        $reti = NULL;
        $conn = DatabaseFactory::get();
        $query = "SELECT * FROM DREG_TLDS WHERE id=$id";
        Application::logger()->base("Performing query " . $query);
        $result = pg_query($conn, $query);
        if ($result){
            $row = pg_fetch_assoc($result);
            $reti = new TLD($row["id"], $row["name"]);
        }
        else
        {
            Application::logger()->warning("Cannot find TLD with id $id");
        }
        return $reti;
    }

    /**
     * Reads top level domain by its name.
     * @param string $name Name of top level domain.
     * @return ?TLD Top level domain,
     *              or NULL if such top level domain does not exists.
     */
    public static function readByName(string $name): ?TLD{
        $reti = NULL;
        $conn = DatabaseFactory::get();
        $query = "SELECT * FROM DREG_TLDS WHERE name='" . pg_escape_string($conn, $name) . "'";
        Application::logger()->base("Performing query ". $query);
        $result = pg_query($conn, $query);
        if ($result){
            $row = pg_fetch_assoc($result);
            $reti = new TLD($row["id"], $row["name"]);
        }
        else{
            Application::logger()->info("Cannot find TLD with name $name");
        }
        return $reti;
    }

    /**
     * Updates top level domain.
     * @param TLD $tld Top level domain which will be updated.
     */
    public static function update(TLD $tld): void{
        $conn = DatabaseFactory::get();
        $query = "UPDATE DREG_TLDS SET name='" . pg_escape_string($conn, $tld->getName()) . "' WHERE id=" . $tld->getId();
        Application::logger()->base("Performing query " . $query);
        $result = pg_query( $conn, $query);
        if ($result){
            Application::logger()->info("TLD '" . $tld->getName() . "' has been updated.");
        }
        else{
            Application::logger()->error("Update of TLD '" . $tld->getName() . "' failed!");
        }
    }

    /**
     * Deletes top level domain.
     * @param TLD $tld Top level domain which will be deleted.
     */
    public static function delete(TLD $tld): void{
        $conn = DatabaseFactory::get();
        $query = "DELETE FROM DREG_TLDS WHERE id=" . $tld->getId();
        $result = pg_query( $conn, $query);
        if ($result){
            Application::logger()->info("TLD '" . $tld->getName() . "' has been deleted.");
        }
        else{
            Application::logger()->error("Delete of TLD '". $tld->getName() . "' failed!");
        }
    }
}

?>
