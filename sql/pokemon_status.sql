Select
    p.Pokemon_Name,
    p.Pokemon_Level,
    ps.Pokemon_Species_Name,
    ps.Pokemon_Species_Description,
    (
        SELECT
            t.types_name
        FROM
            types t
        WHERE
            pt.type_slot = 1
            AND pt.types_id = t.types_id
    ) AS type_1,
    Max(
        (
            SELECT
                t.types_name
            FROM
                types t
            WHERE
                pt.type_slot = 2
                AND pt.types_id = t.types_id
        )
    ) AS type_2,
    (
        Select
            Concat(m.Move_Name, ';', m.Move_PP, ';', t.types_Name)
        From
            Pokemon_moves pm,
            Moves m,
            Types t
        WHERE
            pm.Move_Slot = 1
            AND pm.Pokemon_ID = p.Pokemon_ID
            AND pm.Moves_ID = m.Moves_ID
            AND t.Types_ID = m.Types_ID
    ) AS move_1,
    (
        Select
            Concat(m.Move_Name, ';', m.Move_PP, ';', t.types_Name)
        From
            Pokemon_moves pm,
            Moves m,
            Types t
        WHERE
            pm.Move_Slot = 2
            AND pm.Pokemon_ID = p.Pokemon_ID
            AND pm.Moves_ID = m.Moves_ID
            AND t.Types_ID = m.Types_ID
    ) AS move_2,
    (
        Select
            Concat(m.Move_Name, ';', m.Move_PP, ';', t.types_Name)
        From
            Pokemon_moves pm,
            Moves m,
            Types t
        WHERE
            pm.Move_Slot = 3
            AND pm.Pokemon_ID = p.Pokemon_ID
            AND pm.Moves_ID = m.Moves_ID
            AND t.Types_ID = m.Types_ID
    ) AS move_3,
    (
        Select
            Concat(m.Move_Name, ';', m.Move_PP, ';', t.types_Name)
        From
            Pokemon_moves pm,
            Moves m,
            Types t
        WHERE
            pm.Move_Slot = 4
            AND pm.Pokemon_ID = p.Pokemon_ID
            AND pm.Moves_ID = m.Moves_ID
            AND t.Types_ID = m.Types_ID
    ) AS move_4
FROM
    Pokemon p,
    Pokemon_Species ps,
    pokemon_types pt
WHERE
    p.Pokemon_ID = 11
    AND p.Pokemon_Species_ID = ps.Pokemon_Species_ID
    AND pt.pokemon_species_id = ps.pokemon_species_id
GROUP BY
    ps.pokemon_species_id
ORDER BY
    ps.pokemon_species_id
LIMIT
    1;