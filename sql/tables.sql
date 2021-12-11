CREATE TABLE `Trainers` (
	`Trainer_ID` INT NOT NULL AUTO_INCREMENT,
	`Trainer_Name` VARCHAR(32) NOT NULL,
	`Trainer_Gender` VARCHAR(8) NOT NULL,
	PRIMARY KEY (`Trainer_ID`)
);

CREATE TABLE `Pokemon` (
	`Pokemon_ID` INT NOT NULL AUTO_INCREMENT,
	`Pokemon_Name` VARCHAR(32) NOT NULL,
	`Pokemon_Level` INT NOT NULL DEFAULT '0',
	`Trainer_Gender` VARCHAR(8) NOT NULL,
	`Pokemon_Health` INT NOT NULL DEFAULT '100',
	`Pokemon_Exp` INT NOT NULL DEFAULT '0',
	`Pokemon_Species_ID` INT NOT NULL,
	`Trainer_ID` INT NOT NULL,
	PRIMARY KEY (`Pokemon_ID`),
	FOREIGN KEY (`Pokemon_Species_ID`) REFERENCES Pokemon_Species(`Pokemon_Species_ID`),
	FOREIGN KEY (`Trainer_ID`) REFERENCES Trainers(`Trainer_ID`)
);

CREATE TABLE `Party_Pokemon` (
	`Party_Pokemon_ID` INT NOT NULL AUTO_INCREMENT,
	`Trainer_ID` INT NOT NULL,
	`Pokemon_ID` INT NOT NULL,
	`Party_Slot` INT NOT NULL DEFAULT '1',
	PRIMARY KEY (`Party_Pokemon_ID`),
	FOREIGN KEY (`Pokemon_ID`) REFERENCES Pokemon(`Pokemon_ID`),
	FOREIGN KEY (`Trainer_ID`) REFERENCES Trainers(`Trainer_ID`)
);

CREATE TABLE `Pokemon_Species` (
	`Pokemon_Species_ID` INT NOT NULL AUTO_INCREMENT,
	`Pokemon_Species_Name` VARCHAR(32) NOT NULL,
	`Pokemon_Species_Description` VARCHAR(240) DEFAULT 'Not much is known about this creature.',
	`Evolves_From` VARCHAR(32) NOT NULL,
	`Evolves_Into` VARCHAR(32) NOT NULL,
	PRIMARY KEY (`Pokemon_Species_ID`)
);

CREATE TABLE `Moves` (
	`Moves_ID` INT NOT NULL AUTO_INCREMENT,
	`Types_ID` INT NOT NULL,
	`Move_Name` VARCHAR(32) NOT NULL,
	`Move_Description` VARCHAR(240),
	`Move_PP` INT NOT NULL,
	`Move_Accuracy` INT NOT NULL,
	PRIMARY KEY (`Moves_ID`),
	FOREIGN KEY (`Types_ID`) REFERENCES Types(`Types_ID`)
);

CREATE TABLE `Pokemon_Moves` (
	`Pokemon_Moves_ID` INT NOT NULL AUTO_INCREMENT,
	`Moves_ID` INT NOT NULL,
	`Pokemon_ID` INT NOT NULL,
	`Move_Slot` INT NOT NULL DEFAULT '1',
	PRIMARY KEY (`Pokemon_Moves_ID`),
	FOREIGN KEY (`Moves_ID`) REFERENCES Moves(`Moves_ID`),
	FOREIGN KEY (`Pokemon_ID`) REFERENCES Pokemon(`Pokemon_ID`)
);

CREATE TABLE `Pokemon_Types` (
	`Pokemon_Types_ID` INT NOT NULL AUTO_INCREMENT,
	`Pokemon_Species_ID` INT NOT NULL,
	`Types_ID` INT NOT NULL,
	`Type_Slot` INT NOT NULL DEFAULT '1',
	PRIMARY KEY (`Pokemon_Types_ID`),
	FOREIGN KEY (`Pokemon_Species_ID`) REFERENCES Pokemon_Species(`Pokemon_Species_ID`),
	FOREIGN KEY (`Types_ID`) REFERENCES Types(`Types_ID`)
);

CREATE TABLE `Types` (
	`Types_ID` INT NOT NULL AUTO_INCREMENT,
	`Types_Name` VARCHAR(16) NOT NULL,
	PRIMARY KEY (`Types_ID`)
);

CREATE TABLE `Types_Matchups` (
	`Types_Matchups_ID` INT NOT NULL AUTO_INCREMENT,
	`Attacking_Types_ID` INT NOT NULL,
	`Defending_Types_ID` INT NOT NULL,
	`Modifier` FLOAT NOT NULL DEFAULT '1',
	PRIMARY KEY (`Types_Matchups_ID`),
	FOREIGN KEY (`Attacking_Types_ID`) REFERENCES Types(`Types_ID`),
	FOREIGN KEY (`Defending_Types_ID`) REFERENCES Types(`Types_ID`)
);