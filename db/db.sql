SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `xzindor_db1` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `xzindor_db1` ;

-- -----------------------------------------------------
-- Table `xzindor_db1`.`postnr`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `xzindor_db1`.`postnr` ;

CREATE  TABLE IF NOT EXISTS `xzindor_db1`.`postnr` (
  `postnr` INT(4) NOT NULL ,
  `Sted` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`postnr`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `xzindor_db1`.`bruker`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `xzindor_db1`.`bruker` ;

CREATE  TABLE IF NOT EXISTS `xzindor_db1`.`bruker` (
  `idbruker` INT NOT NULL AUTO_INCREMENT ,
  `brukernavn` VARCHAR(45) NOT NULL ,
  `passord` VARCHAR(45) NOT NULL ,
  `fornavn` VARCHAR(45) NOT NULL ,
  `etternavn` VARCHAR(45) NOT NULL ,
  `adresse` VARCHAR(45) NOT NULL ,
  `postnr` INT NULL ,
  `epost` VARCHAR(45) NOT NULL ,
  `registrert` DATETIME NOT NULL ,
  `rettigheter` INT(2) NOT NULL ,
  `tlf` INT(12) NOT NULL ,
  PRIMARY KEY (`idbruker`) ,
  INDEX `postnr` () ,
  CONSTRAINT `postnr`
    FOREIGN KEY ()
    REFERENCES `xzindor_db1`.`postnr` ()
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `xzindor_db1`.`kategori`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `xzindor_db1`.`kategori` ;

CREATE  TABLE IF NOT EXISTS `xzindor_db1`.`kategori` (
  `idkategori` INT NOT NULL AUTO_INCREMENT ,
  `tittel` VARCHAR(45) NULL ,
  `aktiv` TINYINT(1)  NULL ,
  PRIMARY KEY (`idkategori`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `xzindor_db1`.`vare`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `xzindor_db1`.`vare` ;

CREATE  TABLE IF NOT EXISTS `xzindor_db1`.`vare` (
  `idvare` INT NOT NULL AUTO_INCREMENT ,
  `date` DATETIME NULL ,
  `tittel` VARCHAR(45) NULL ,
  `tekst` LONGTEXT NULL ,
  `idkategori` INT(4) NULL ,
  `bildeurl` MEDIUMTEXT  NULL ,
  `pris` DOUBLE NULL ,
  `statusAktiv` TINYINT(1)  NULL ,
  `idbruker` INT NULL ,
  PRIMARY KEY (`idvare`) ,
  INDEX `idkategori` () ,
  CONSTRAINT `bruker`
    FOREIGN KEY ()
    REFERENCES `xzindor_db1`.`bruker` ()
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idkategori`
    FOREIGN KEY ()
    REFERENCES `xzindor_db1`.`kategori` ()
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `xzindor_db1`.`Loginlog`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `xzindor_db1`.`Loginlog` ;

CREATE  TABLE IF NOT EXISTS `xzindor_db1`.`Loginlog` (
  `idLoginlog` INT NOT NULL ,
  `ip` VARCHAR(15) NULL ,
  `brukernavn` VARCHAR(45) NULL ,
  `tid` DATETIME NULL ,
  PRIMARY KEY (`idLoginlog`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `xzindor_db1`.`ordre`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `xzindor_db1`.`ordre` ;

CREATE  TABLE IF NOT EXISTS `xzindor_db1`.`ordre` (
  `idordre` INT NOT NULL AUTO_INCREMENT ,
  `ordredato` DATETIME NULL ,
  `idbruker` INT NULL ,
  `sendtdato` DATETIME NULL ,
  `betaltdato` DATETIME NULL ,
  PRIMARY KEY (`idordre`) ,
  INDEX `idbruker` () ,
  CONSTRAINT `idbruker`
    FOREIGN KEY ()
    REFERENCES `xzindor_db1`.`bruker` ()
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `xzindor_db1`.`ordrelinje`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `xzindor_db1`.`ordrelinje` ;

CREATE  TABLE IF NOT EXISTS `xzindor_db1`.`ordrelinje` (
  `ordrelinje` INT NOT NULL AUTO_INCREMENT ,
  `idordre` INT NULL ,
  `idvare` INT NULL ,
  `prisPrEnhet` DOUBLE NULL ,
  `antall` INT NULL ,
  PRIMARY KEY (`ordrelinje`) ,
  INDEX `idordre` () ,
  INDEX `idvare` () ,
  CONSTRAINT `idordre`
    FOREIGN KEY ()
    REFERENCES `xzindor_db1`.`ordre` ()
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idvare`
    FOREIGN KEY ()
    REFERENCES `xzindor_db1`.`vare` ()
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `xzindor_db1`.`vareregister`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `xzindor_db1`.`vareregister` ;

CREATE  TABLE IF NOT EXISTS `xzindor_db1`.`vareregister` (
  `idvareregister` INT NOT NULL AUTO_INCREMENT ,
  `idvare` INT NOT NULL ,
  `sistoppdatert` DATETIME NOT NULL ,
  `antall` INT NOT NULL ,
  PRIMARY KEY (`idvareregister`) ,
  INDEX `idvare` () ,
  CONSTRAINT `idvare`
    FOREIGN KEY ()
    REFERENCES `xzindor_db1`.`vare` ()
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
