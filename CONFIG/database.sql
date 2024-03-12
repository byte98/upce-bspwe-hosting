-- 
-- database.sql
-- File containing structure of database
-- used for Simple Hosting application.
--
-- Author: Jiri Skoda <jiri.skoda@student.upce.cz>
--         Faculty of Electrical Engineering and Informatics
--         University of Pardubice
--         2024, Pardubice
--

-- ### DREG (Domain REGistry) ###
-- Table with allowed TLDs
CREATE TABLE DREG_TLD(
    id         SERIAL  PRIMARY KEY,
    name       TEXT    NOT NULL
);

-- Table with registered domains
CREATE TABLE DREG_DOMAINS(
    id        SERIAL   PRIMARY KEY,
    tld       INT,
    name      TEXT     NOT NULL,

    CONSTRAINT fk_TLD
        FOREIGN KEY(tld)
            REFERENCES DREG_TLD(id)
);

-- Fill some TLDs
INSERT INTO DREG_TLD (name) VALUES ('cz');
INSERT INTO DREG_TLD (name) VALUES ('com');
INSERT INTO DREG_TLD (name) VALUES ('eu');
INSERT INTO DREG_TLD (name) VALUES ('net');
INSERT INTO DREG_TLD (name) VALUES ('org');


