DECLARE @PARTYCOUNT INT 
BEGIN TRANSACTION AddPartyPokemon
    UPDATE Party_Pokemon
    SET POKEMON_ID = 9
    WHERE TRAINER_ID = 1
    AND Party_Slot = 6

    SELECT @PARTYCOUNT = COUNT(*)
    FROM Party_Pokemon
    WHERE Trainer_ID = 1 
    
    IF @Party_Pokemon >= 6
    BEGIN
        ROLLBACK TRANSACTION AddPartyPokemon
        PRINT 'The player already has a full party'
    END
    ELSE
        BEGIN COMMIT TRANSACTION AddPartyPokemon
        PRINT 'Pokemon added to party successfully'
    END
END