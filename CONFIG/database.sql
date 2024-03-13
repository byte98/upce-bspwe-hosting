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
CREATE TABLE DREG_TLDS(
    id         SERIAL  PRIMARY KEY,
    name       TEXT    UNIQUE NOT NULL
);

-- Table with registered domains
CREATE TABLE DREG_DOMAINS(
    id        SERIAL           PRIMARY KEY,
    tld       INT,
    name      VARCHAR(256)     NOT NULL,

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




-- ### APPLICATION ###

-- Table with addresses
CREATE TABLE ADDRESSES(
    id            SERIAL        PRIMARY KEY,
    street        VARCHAR(128)  NOT NULL,
    city          VARCHAR(128)  NOT NULL,
    province      VARCHAR(128)  NOT NULL,
    country_code  CHAR(2)       NOT NULL,
);

-- Table with clients (a.k.a. personal data of users)
CREATE TABLE CLIENTS(
    id            SERIAL            PRIMARY KEY,
    name          VARCHAR(128)      NOT NULL,
    surname       VARCHAR(128)      NOT NULL,
    email         VARCHAR(384)      NOT NULL,
    address       INT               NOT NULL,
    company       VARCHAR(128)      NOT NULL,
    company_unit  VARCHAR(128)      NOT NULL,

    CONSTRAINT fk_address
        FOREIGN KEY (address)
            REFERENCES ADDRESSES(id)
);

-- Table with users of system
CREATE TABLE USERS(
    id           SERIAL           PRIMARY KEY,
    password     VARCHAR(1024)    NOT NULL,
    client       INT              UNIQUE        NOT NULL,

    CONSTRAINT fk_client
        FOREIGN KEY (client)
            REFERENCES CLIENTS(id)
);

-- Table with hostings
CREATE TABLE HOSTINGS(
    id           SERIAL           PRIMARY KEY,
    domain       INT              NOT NULL,
    disk         INT              NOT NULL,
    database     INT              NOT NULL,
    
);


-- Table mapping users to its owned hostings
CREATE TABLE USER_HOSTINGS(
    id          SERIAL            PRIMARY KEY,
    user        INT               NOT NULL,
    hosting     INT               NOT NULL,

    CONSTRAINT fk_user
        FOREIGN KEY (user)
            REFERENCES USERS(id)
);

