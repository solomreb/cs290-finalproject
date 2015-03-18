INSERT INTO dogs_walkers VALUES ((SELECT walkers.walker_id, dogs. FROM ), (SELECT dogs.dog_id) FROM );


SELECT w.walker_id, t.time_id, d.dog_id FROM walkers w 
	INNER JOIN walkers_time wt ON w.walker_id = wt.walker_id 
	INNER JOIN time_slots t ON wt.time_id = t.time_id
	INNER JOIN dogs_time dt ON t.time_id = dt.time_id
	INNER JOIN dogs d ON dt.dog_id = d.dog_id
	WHERE wt.time_id = dt.time_id