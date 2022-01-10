LOAD DATA LOCAL INFILE 'E:/Documents/pokedex/csv/types.csv' INTO TABLE `Types`FIELDS TERMINATED BY ',' LINES TERMINATED BY '\r\n' IGNORE 1 Lines (Types_Name);

LOAD DATA LOCAL INFILE 'E:/Documents/pokedex/csv/types_matchups.csv' INTO TABLE `Types_Matchups`FIELDS TERMINATED BY ',' LINES TERMINATED BY '\r\n' IGNORE 1 Lines (@Dummy, @Dummy, Attacking_Types_ID, Defending_Types_ID, Modifier);/

LOAD DATA LOCAL INFILE 'E:/Documents/pokedex/csv/pokemon_species.csv' INTO TABLE `Pokemon_Species`FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY '\r\n' IGNORE 1 Lines;/

LOAD DATA LOCAL INFILE 'E:/Documents/pokedex/csv/pokemon_types.csv' INTO TABLE `Pokemon_Types`FIELDS TERMINATED BY ',' LINES TERMINATED BY '\r\n' IGNORE 1 Lines (Pokemon_Species_ID, @Dummy, Types_ID, Type_Slot);/

LOAD DATA LOCAL INFILE 'E:/Documents/pokedex/csv/moves.csv' INTO TABLE `Moves`FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY '\r\n' IGNORE 1 Lines (@Dummy, Types_ID, Move_Name, Move_Description, Move_PP, Move_Accuracy);
