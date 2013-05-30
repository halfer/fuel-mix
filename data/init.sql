DROP TABLE IF EXISTS supplier;
DROP TABLE IF EXISTS supplier_alias;
DROP TABLE IF EXISTS energy_type;
DROP TABLE IF EXISTS mix_value;

CREATE TABLE supplier (
	id INTEGER PRIMARY KEY NOT NULL,
	name VARCHAR(100) NOT NULL,
	website VARCHAR(200) NOT NULL,
	created_at INTEGER NOT NULL,
	source VARCHAR(255)
);

CREATE TABLE supplier_alias (
	id INTEGER PRIMARY KEY NOT NULL,
	supplier_id INTEGER NOT NULL,
	name VARCHAR(100) NOT NULL,
	website VARCHAR(200) NOT NULL,
	created_at INTEGER NOT NULL,
	source VARCHAR(255),
	FOREIGN KEY (supplier_id) REFERENCES supplier(id)
);

CREATE TABLE energy_type (
	id INTEGER PRIMARY KEY NOT NULL,
	name VARCHAR(50) NOT NULL
);

CREATE TABLE mix_value (
	supplier_id INTEGER NOT NULL,
	energy_type_id INTEGER NOT NULL,
	date INTEGER NOT NULL,
	percent REAL,
	PRIMARY KEY (supplier_id, energy_type_id, date),
	FOREIGN KEY (supplier_id) REFERENCES supplier(id),
	FOREIGN KEY (energy_type_id) REFERENCES energy_type(id)
);

INSERT INTO energy_type (name) VALUES('Renewables');
INSERT INTO energy_type (name) VALUES('Nuclear');
INSERT INTO energy_type (name) VALUES('Coal');
INSERT INTO energy_type (name) VALUES('Natural gas');
INSERT INTO energy_type (name) VALUES('Other');
