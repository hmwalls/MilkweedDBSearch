Select Commonname, scientificname, databasecode, name, state, zip, url, email, phone, notes, seed, liveplant FROM availability JOIN plants ON availability.plant_ID = plants.plant_ID Join sources ON availability.source_ID = sources.source_ID;

