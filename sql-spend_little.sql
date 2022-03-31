-- MySQL Script generated by MySQL Workbench
-- Thu Mar 31 20:30:07 2022
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
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  `level_id` INT NOT NULL,
  `status` TINYINT NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  INDEX `fk_user_level1_idx` (`level_id` ASC) VISIBLE,
  CONSTRAINT `fk_user_level1`
    FOREIGN KEY (`level_id`)
    REFERENCES `food_orders`.`levels` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 8
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
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `food_orders`.`status_orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `food_orders`.`status_orders` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `food_orders`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `food_orders`.`orders` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `catalog_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` VARCHAR(45) NULL DEFAULT NULL,
  `status_orders_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_orders_user1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_orders_status_orders1_idx` (`status_orders_id` ASC) VISIBLE,
  CONSTRAINT `fk_orders_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `food_orders`.`users` (`id`),
  CONSTRAINT `fk_orders_status_orders1`
    FOREIGN KEY (`status_orders_id`)
    REFERENCES `food_orders`.`status_orders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `food_orders`.`types`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `food_orders`.`types` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `food_orders`.`ingredients`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `food_orders`.`ingredients` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
  `status` TINYINT NOT NULL DEFAULT '1',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `types_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ingredients_types1_idx` (`types_id` ASC) VISIBLE,
  CONSTRAINT `fk_ingredients_types1`
    FOREIGN KEY (`types_id`)
    REFERENCES `food_orders`.`types` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `food_orders`.`itens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `food_orders`.`itens` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ingredients_id` INT NOT NULL,
  `orders_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_itens_ingredients1_idx` (`ingredients_id` ASC) VISIBLE,
  INDEX `fk_itens_orders1_idx` (`orders_id` ASC) VISIBLE,
  CONSTRAINT `fk_itens_ingredients1`
    FOREIGN KEY (`ingredients_id`)
    REFERENCES `food_orders`.`ingredients` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_itens_orders1`
    FOREIGN KEY (`orders_id`)
    REFERENCES `food_orders`.`orders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
