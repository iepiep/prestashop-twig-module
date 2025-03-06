
CREATE TABLE IF NOT EXISTS `PREFIX_dim_rdv` (
    `id_dim_rdv` INT(11) NOT NULL AUTO_INCREMENT,
    `lastname` VARCHAR(255) NOT NULL,
    `firstname` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    `postal_code` VARCHAR(10) NOT NULL,
    `city` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `date_creneau1` VARCHAR(50) NOT NULL,
    `date_creneau2` VARCHAR(50) NOT NULL,
    `visited` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_dim_rdv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `PREFIX_dim_rdv` (`lastname`, `firstname`, `address`, `postal_code`, `city`, `phone`, `email`, `date_creneau1`, `date_creneau2`, `visited`, `created_at`)
VALUES
('Supermarket', 'Carrefour', '1 Rue de Bretagne', '53000', 'Laval', '0123456789', 'carrefour@example.com', 'Monday 24/02/25 MATIN', 'Tuesday 25/02/25 MATIN', 0, NOW()),
('Pharmacy', 'Citypharma', '12 Avenue Robert Buron', '53000', 'Laval', '0123456789', 'citypharma@example.com', 'Monday 24/02/25 APRES-MIDI', 'Tuesday 25/02/25 APRES-MIDI', 0, NOW()),
('Bakery', 'Boulangerie', '5 Rue Charles Landelle', '53000', 'Laval', '0123456789', 'boulangerie@example.com', 'Tuesday 25/02/25 MATIN', 'Wednesday 26/02/25 MATIN', 0, NOW()),
('Library', 'Bibliothèque', '10 Rue de la Paix', '53000', 'Laval', '0123456789', 'bibliotheque@example.com', 'Tuesday 25/02/25 APRES-MIDI', 'Wednesday 26/02/25 APRES-MIDI', 0, NOW()),
('Park', 'Jardin', '2 Place de Hercé', '53000', 'Laval', '0123456789', 'jardin@example.com', 'Wednesday 26/02/25 MATIN', 'Thursday 27/02/25 MATIN', 1, NOW());
