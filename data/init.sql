DROP TABLE IF EXISTS supplier;
DROP TABLE IF EXISTS supplier_alias;
DROP TABLE IF EXISTS energy_type;
DROP TABLE IF EXISTS mix_value;

CREATE TABLE supplier (
	id INTEGER PRIMARY KEY NOT NULL,
	name VARCHAR(100) NOT NULL,
	website VARCHAR(200),
	created_at INTEGER NOT NULL,
	/* Date supplier opened for business */
	business_open_at INTEGER,
	/* Date supplier ceased trading or merged into another supplier */
	business_close_at INTEGER,
	source VARCHAR(255),
	is_enabled BOOLEAN NOT NULL DEFAULT 1
);

CREATE TABLE supplier_alias (
	id INTEGER PRIMARY KEY NOT NULL,
	supplier_id INTEGER NOT NULL,
	name VARCHAR(100) NOT NULL,
	website VARCHAR(200),
	created_at INTEGER NOT NULL,
	source VARCHAR(255),
	FOREIGN KEY (supplier_id) REFERENCES supplier(id)
);

CREATE TABLE energy_type (
	id INTEGER PRIMARY KEY NOT NULL,
	name VARCHAR(50) NOT NULL,
	short_name VARCHAR(12) NOT NULL
);

CREATE TABLE mix_value (
	supplier_id INTEGER NOT NULL,
	energy_type_id INTEGER NOT NULL,
	date VARCHAR(10) NOT NULL,
	percent REAL,
	/* Each figure can be independently referenced if required */
	source VARCHAR(255),
	created_at INTEGER NOT NULL,
	PRIMARY KEY (supplier_id, energy_type_id, date),
	FOREIGN KEY (supplier_id) REFERENCES supplier(id),
	FOREIGN KEY (energy_type_id) REFERENCES energy_type(id)
);

INSERT INTO energy_type (name, short_name) VALUES('Renewables', 'renewable');
INSERT INTO energy_type (name, short_name) VALUES('Nuclear', 'nuclear');
INSERT INTO energy_type (name, short_name) VALUES('Coal', 'coal');
INSERT INTO energy_type (name, short_name) VALUES('Natural gas', 'gas');
INSERT INTO energy_type (name, short_name) VALUES('Other', 'other');
