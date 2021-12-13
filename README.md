# CMPSC 431W Project - Pokedex
-   Jacob Ryan _jwr32_
-   Luke McCleery _lfm5334_

## File Organization
This repository organizes the files contained within by type. Included are the following directories:
-	**CSS**	: Contains styles for html and PHP screens
-	**CSV**	: CSV files containing data preloaded into the database
-	**HTML**: Template files showing the intended visuals for PHP pages
-	**IMG**	: Sprites from _Bulbapedia_ used throughout website
-	**JS**	: JavaScript for handling dynamic elements like dialogue boxes
-	**PHP**	: PHP files created from modifying HTML templates to use database values
-	**SQL**	: References for table definitions, examples from design document, and instructions to load data from csv files in to the database
## Source of Data

### CSV Data 
-	[Moves](csv/moves.csv): JSON file from [this repository](https://github.com/fanzeyi/pokemon.json) was converted into a CSV through python and modified in Excel to fit the _moves_ table in the database.
-	[Pokémon Species](csv/pokemon_species.csv) CSV from [this gist](https://gist.github.com/santiagoolivar2017/0591a53c4dd34ecd8488660c7372b0e3) was modified in excel to match the data
	-	Data for "Evolves From" and "Evolves To" was gathered from the [Pokémon Wiki](https://pokemon.fandom.com/wiki/List_of_Pok%C3%A9mon_by_evolution) and cleaned in excel to exclude evolutions not found in Generation 1 of the Pokémon Games
-	[Pokémon Types](csv/pokemon_types.csv) - Type Data from _pokemon_species.csv_ was taken to create a list of Pokémon types by Pokemon_Species_ID, the list was flattened to assign type slot 1 and 2 based on the 4th column. Types_IDs were taken from the _types_ table to assign foreign keys in the CSV using a function in Excel.
-	[Types_Matchups](csv/types_matchups.csv) - Type matchups were converted into a CSV using python from [this repository](https://github.com/filipekiss/pokemon-type-chart/blob/master/types.json).  Matchups were assigned a modifier of 0, 0.5, and 2 based on immunity, weakness, and strength respectively. Matchups without a modifier are assigned the value of 1. This CSV is ordered by Attacking_Type_ID and Defending_Type_ID before being inserted into _type\_matchups_.
-	[Types](csv/types.csv) - The type_names read from the JSON file in the previous source, and inserted into a CSV using Python.

### IMG Data 
All images used in this repository are from the [Bulbagarden Archives](https://archives.bulbagarden.net/wiki/Main_Page). The images hosted in this archive are taken as direct screenshots from the game _Pokémon Fire Red_ and are listed by the archive under "[Fair Use.](https://en.wikipedia.org/wiki/Fair_use)"
-	[Pokemon Sprites](https://archives.bulbagarden.net/wiki/Category:FireRed_and_LeafGreen_sprites) are downloaded from this page using a web scraper

## Changes From Design Document
The database schema did not receive any changes from the design document. For this section, and changes will be described screen by screen.

-	PC Box Screen - A button was added next to the "Trainer" and "Sort" drop downs. We forgot to include a trigger to submit the form those two \<select\> elements were in. Adding this button will allow the page to reload with a new Trainer ID and Sorting Order selected for the grid.
	-	An additional note, the prompt for changing the Pokémon's name wasn't shown in the original design document. However, pressing the "Change name" dialogue option will trigger the prompt as was originally intended.
-	Pokedex Grid Screen - The Pokedex also has an added button to submit the form. The reasoning is the same as the PC Box. It was an oversight in the original design, and adding this button allows the filter and sort to be done at the database level and instead of with JQuery.