Select
    t.Trainer_Name,
    p.Pokemon_Name,
    p.Pokemon_Level,
    ps.Pokemon_Species_Name,
    ps.Pokemon_Species_Description,
    Type_1 = (
        Select
            t.Type_Name
        From
            Pokemon_Types pt,
            Types t
        WHERE
            pt.Type_Slot = 1
            AND pt.Pokemon_Species_ID = ps.Pokemon_Species_ID
            AND t.Types_ID == pt.Types_ID
    ),
    Type_2 = (
        Select
            t.Type_Name
        From
            Pokemon_Types pt,
            Types t
        WHERE
            pt.Type_Slot = 2
            AND pt.Pokemon_Species_ID = ps.Pokemon_Species_ID
            AND t.Types_ID == pt.Types_ID
    ),
    Move_1 = (
        Select
            Concat(m.Move_Name, ';', m.Move_PP, ';', t.type_Name)
        From
            Pokemon_moves pm,
            Moves m,
            Types t
        WHERE
            pm.Move_Slot = 1
            AND pm.Pokemon_ID = p.Pokemon_ID
            AND pm.Moves_ID = m.Moves_ID
            AND t.Types_ID == pt.Types_ID
    ),
    Move_2 = (
        Select
            Concat(m.Move_Name, ';', m.Move_PP, ';', t.type_Name)
        From
            Pokemon_moves pm,
            Moves m,
            Types t
        WHERE
            pm.Move_Slot = 2
            AND pm.Pokemon_ID = p.Pokemon_ID
            AND pm.Moves_ID = m.Moves_ID
            AND t.Types_ID == pt.Types_ID
    ),
    Move_3 = (
        Select
            Concat(m.Move_Name, ';', m.Move_PP, ';', t.type_Name)
        From
            Pokemon_moves pm,
            Moves m,
            Types t
        WHERE
            pm.Move_Slot = 3
            AND pm.Pokemon_ID = p.Pokemon_ID
            AND pm.Moves_ID = m.Moves_ID
            AND t.Types_ID == pt.Types_ID
    ),
    Move_4 = (
        Select
            Concat(m.Move_Name, ';', m.Move_PP, ';', t.type_Name)
        From
            Pokemon_moves pm,
            Moves m,
            Types t
        WHERE
            pm.Move_Slot = 4
            AND pm.Pokemon_ID = p.Pokemon_ID
            AND pm.Moves_ID = m.Moves_ID
            AND t.Types_ID == pt.Types_ID
    ),
FROM
    Trainers t,
    Pokemon p,
    Pokemon_Species ps
WHERE
    p.Pokemon_ID = 101
    AND p.Trainer_ID = t.Trainer_ID
    AND p.Pokemon_Species_ID = ps.Pokemon_Species_ID
LIMIT 1;