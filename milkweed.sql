sourcessourcesSET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `milkweed` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `milkweed` ;

-- -----------------------------------------------------
-- Table `milkweed`.`sources`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `milkweed`.`sources` (
  `Source_ID` INT NOT NULL ,
  `name` TEXT NULL ,
  `state` TEXT NULL ,
  `zip` INT NULL ,
  `url` TEXT NULL ,
  `email` TEXT NULL ,
  `phone` TEXT NULL ,
  `notes` TEXT NULL ,
  PRIMARY KEY (`Source_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `milkweed`.`plants`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `milkweed`.`plants` (
  `Plant_ID` INT NOT NULL ,
  `commonname` TEXT NULL ,
  `scientificname` TEXT NULL ,
  `databasecode` TEXT NULL ,
  PRIMARY KEY (`Plant_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `milkweed`.`availability`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `milkweed`.`availability` (
  `availability_ID` INT NOT NULL ,
  `seed` TEXT NULL ,
  `liveplant` TEXT NULL ,
  `Source_ID` INT NOT NULL ,
  `Plant_ID` INT NOT NULL ,
  PRIMARY KEY (`availability_ID`, `Source_ID`, `Plant_ID`) ,
  INDEX `fk_availability_sources_idx` (`Source_ID` ASC) ,
  INDEX `fk_availability_plants1_idx` (`Plant_ID` ASC) ,
  CONSTRAINT `fk_availability_sources`
    FOREIGN KEY (`Source_ID` )
    REFERENCES `milkweed`.`sources` (`Source_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_availability_plants1`
    FOREIGN KEY (`Plant_ID` )
    REFERENCES `milkweed`.`plants` (`Plant_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
