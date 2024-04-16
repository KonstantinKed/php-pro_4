CREATE TABLE city_catalog (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              new_post_city_id VARCHAR(255),
                              justin_city_id INT,
                              ukr_poshta_city_id INT,
                              slug VARCHAR(255)
);

CREATE TABLE area_catalog (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              name VARCHAR(255)
);
CREATE TABLE region_catalog (
                                id INT AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR(255)
);

CREATE TABLE translation (
                             id INT AUTO_INCREMENT PRIMARY KEY,
                             city_id INT NULL,
                             area_id INT NULL,
                             region_id INT NULL,
                             language VARCHAR(5),
                             text VARCHAR(255),
                             INDEX (city_id),
                             INDEX (area_id),
                             INDEX (region_id),
                             FOREIGN KEY (city_id) REFERENCES city_catalog(id),
                             FOREIGN KEY (area_id) REFERENCES area_catalog(id),
                             FOREIGN KEY (region_id) REFERENCES region_catalog(id)
);

CREATE TABLE timestamp (
                           city_id INT PRIMARY KEY,
                           created_at DATETIME,
                           updated_at DATETIME,
                           FOREIGN KEY (city_id) REFERENCES city_catalog(id)
);

INSERT INTO area_catalog (name)
SELECT DISTINCT area_name_uk
FROM catalog_city;

INSERT INTO region_catalog (name)
SELECT DISTINCT region_name_uk
FROM catalog_city;

INSERT INTO city_catalog (new_post_city_id, justin_city_id, ukr_poshta_city_id, slug)
SELECT DISTINCT new_post_city_id, justin_city_id, ukr_poshta_city_id, slug
FROM catalog_city;

INSERT INTO timestamp (city_id, created_at, updated_at)
SELECT city.id, old.created_at, old.updated_at
FROM catalog_city old
         JOIN city_catalog city ON city.slug = old.slug;


INSERT INTO translation (city_id, language, text)
SELECT new.id, 'uk', old.name_uk
FROM catalog_city old
         JOIN city_catalog new ON new.slug = old.slug
UNION ALL
SELECT new.id, 'ru', old.name_ru
FROM catalog_city old
         JOIN city_catalog new ON new.slug = old.slug;

INSERT INTO translation (area_id, language, text)
SELECT area.id, 'uk', area.name
FROM area_catalog area
UNION
SELECT area.id, 'ru', old.area_name_ru
FROM catalog_city old
         JOIN area_catalog area ON area.name = old.area_name_uk;

INSERT INTO translation (region_id, language, text)
SELECT region.id, 'uk', region.name
FROM region_catalog region
UNION
SELECT region.id, 'ru', old.region_name_ru
FROM catalog_city old
         JOIN region_catalog region ON region.name = old.region_name_uk;

RENAME TABLE catalog_city TO catalog_city_old;

RENAME TABLE city_catalog TO catalog_city;
# TRUNCATE TABLE catalog_city_old