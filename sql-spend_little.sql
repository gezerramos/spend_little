-- MySQL Script generated by MySQL Workbench
-- Fri Apr  1 21:12:56 2022
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema food_orders
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema food_orders
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `food_orders` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `food_orders` ;

-- -----------------------------------------------------
-- Table `food_orders`.`breads`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `food_orders`.`breads` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
  `status` TINYINT NOT NULL DEFAULT '1',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `food_orders`.`meats`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `food_orders`.`meats` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
  `status` TINYINT NOT NULL DEFAULT '1',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `food_orders`.`status_orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `food_orders`.`status_orders` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `food_orders`.`levels`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `food_orders`.`levels` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `food_orders`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `food_orders`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(80) NOT NULL,
  `password` VARCHAR(120) NOT NULL,
  `status` TINYINT NOT NULL DEFAULT '1',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  `level_id` INT NOT NULL,
  `image` VARCHAR(150) NULL DEFAULT NULL,
  `address` VARCHAR(80) NOT NULL DEFAULT 'not',
  `number` INT NOT NULL DEFAULT '0',
  `phone` VARCHAR(20) NOT NULL DEFAULT '0',
  `complement` VARCHAR(30) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_level1_idx` (`level_id` ASC) VISIBLE,
  CONSTRAINT `fk_user_level1`
    FOREIGN KEY (`level_id`)
    REFERENCES `food_orders`.`levels` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 15
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `food_orders`.`hamburger`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `food_orders`.`hamburger` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_at` DATETIME NOT NULL,
  `updated_at` VARCHAR(45) NULL DEFAULT NULL,
  `breads_id` INT NOT NULL,
  `meats_id` INT NOT NULL,
  `users_id` INT NOT NULL,
  `status_orders_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_hamburger_paes1_idx` (`breads_id` ASC) VISIBLE,
  INDEX `fk_hamburger_carnes1_idx` (`meats_id` ASC) VISIBLE,
  INDEX `fk_hamburger_users1_idx` (`users_id` ASC) VISIBLE,
  INDEX `fk_hamburger_status_orders1_idx` (`status_orders_id` ASC) VISIBLE,
  CONSTRAINT `fk_hamburger_carnes1`
    FOREIGN KEY (`meats_id`)
    REFERENCES `food_orders`.`meats` (`id`),
  CONSTRAINT `fk_hamburger_paes1`
    FOREIGN KEY (`breads_id`)
    REFERENCES `food_orders`.`breads` (`id`),
  CONSTRAINT `fk_hamburger_status_orders1`
    FOREIGN KEY (`status_orders_id`)
    REFERENCES `food_orders`.`status_orders` (`id`),
  CONSTRAINT `fk_hamburger_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `food_orders`.`users` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 36
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `food_orders`.`merchants`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `food_orders`.`merchants` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `corporate_name` VARCHAR(100) NOT NULL,
  `description` VARCHAR(200) NULL DEFAULT NULL,
  `status` TINYINT NOT NULL DEFAULT '1',
  `updated_at` DATETIME NULL DEFAULT NULL,
  `created_at` DATETIME NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_merchant_user1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_merchant_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `food_orders`.`users` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `food_orders`.`optionals`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `food_orders`.`optionals` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
  `status` TINYINT NOT NULL DEFAULT '1',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `food_orders`.`optionalsburger`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `food_orders`.`optionalsburger` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `optionals_id` INT NOT NULL,
  `hamburger_id` INT NOT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_opcionais_burgers_opcionais1_idx` (`optionals_id` ASC) VISIBLE,
  INDEX `fk_opcionais_burgers_hamburger1_idx` (`hamburger_id` ASC) VISIBLE,
  CONSTRAINT `fk_opcionais_burgers_hamburger1`
    FOREIGN KEY (`hamburger_id`)
    REFERENCES `food_orders`.`hamburger` (`id`),
  CONSTRAINT `fk_opcionais_burgers_opcionais1`
    FOREIGN KEY (`optionals_id`)
    REFERENCES `food_orders`.`optionals` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 28
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `food_orders`.`types`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `food_orders`.`types` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
