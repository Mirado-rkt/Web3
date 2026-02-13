-- Takalo-takalo Database Schema + Seed Data
-- MySQL compatible

-- Drop tables if they exist (for clean reset)
DROP TABLE IF EXISTS item_history;
DROP TABLE IF EXISTS exchanges;
DROP TABLE IF EXISTS photos;
DROP TABLE IF EXISTS items;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

-- Create Tables
CREATE TABLE users (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(200) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  is_admin BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE items (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  owner_id INTEGER NOT NULL,
  category_id INTEGER,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  estimated_price DECIMAL(10,2) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (owner_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE photos (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  item_id INTEGER NOT NULL,
  file_path VARCHAR(500) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE
);

CREATE TABLE exchanges (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  proposer_id INTEGER NOT NULL,
  proposer_item_id INTEGER NOT NULL,
  target_owner_id INTEGER NOT NULL,
  target_item_id INTEGER NOT NULL,
  status VARCHAR(20) DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (proposer_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (proposer_item_id) REFERENCES items(id) ON DELETE CASCADE,
  FOREIGN KEY (target_owner_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (target_item_id) REFERENCES items(id) ON DELETE CASCADE
);

CREATE TABLE item_history (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  item_id INTEGER NOT NULL,
  previous_owner_id INTEGER NOT NULL,
  new_owner_id INTEGER NOT NULL,
  exchanged_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE,
  FOREIGN KEY (previous_owner_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (new_owner_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =============================================
-- SEED DATA
-- =============================================

-- Utilisateurs (mot de passe admin: admin123, autres: password)
INSERT INTO users (name, email, password, is_admin) VALUES
('Admin User', 'admin@takalo.local', '$2y$10$YhaMZbEH0WifDiAJBc2kEuk/rQbPy1y1RX5MQJsM1URHqySasF9Vu', TRUE),
('Alice Dupont', 'alice@takalo.local', '$2y$10$YA0Gi3mZaiTz63nTwgziD.35ojAZVMdNmOi7T8yXqZIuI9qiaqlo6', FALSE),
('Bob Martin', 'bob@takalo.local', '$2y$10$YA0Gi3mZaiTz63nTwgziD.35ojAZVMdNmOi7T8yXqZIuI9qiaqlo6', FALSE),
('Chloe Durand', 'chloe@takalo.local', '$2y$10$YA0Gi3mZaiTz63nTwgziD.35ojAZVMdNmOi7T8yXqZIuI9qiaqlo6', FALSE),
('David Rakoto', 'david@takalo.local', '$2y$10$YA0Gi3mZaiTz63nTwgziD.35ojAZVMdNmOi7T8yXqZIuI9qiaqlo6', FALSE),
('Emma Rabe', 'emma@takalo.local', '$2y$10$YA0Gi3mZaiTz63nTwgziD.35ojAZVMdNmOi7T8yXqZIuI9qiaqlo6', FALSE);

-- Catégories
INSERT INTO categories (name) VALUES
('Vêtements'),
('Livres'),
('DVD/Film'),
('Électronique'),
('Jeux'),
('Sport'),
('Musique'),
('Autres');

-- Objets (variés, répartis entre plusieurs utilisateurs)
INSERT INTO items (owner_id, category_id, title, description, estimated_price) VALUES
(2, 2, 'Le Petit Prince', 'Édition originale de Saint-Exupéry, très bon état, couverture souple.', 8.00),
(2, 4, 'Casque audio Bluetooth', 'Marque Soundtec, autonomie 10h, son stéréo HD.', 25.00),
(2, 7, 'Guitare acoustique', 'Guitare classique en bois, cordes neuves, idéale pour débutants.', 45.00),
(3, 1, 'Jean bleu taille M', 'Jean denim homme, coupe slim, légèrement usé mais bon état.', 12.00),
(3, 5, 'Monopoly classique', 'Jeu de société complet avec toutes les pièces et billets.', 15.00),
(3, 2, 'Harry Potter Tome 1', 'L\'école des sorciers, édition française, bon état.', 10.00),
(4, 3, 'DVD Inception', 'Film de Christopher Nolan, boîtier plastique, disque intact.', 5.00),
(4, 6, 'Ballon de football', 'Ballon taille 5, bon état, peu utilisé.', 8.00),
(4, 1, 'Veste en cuir noire', 'Taille L, vrai cuir, style motard, quelques éraflures.', 35.00),
(5, 4, 'Clavier mécanique', 'Clavier gaming RGB, switches bleus, rétroéclairage.', 30.00),
(5, 2, 'Les Misérables', 'Victor Hugo, édition poche, 1200 pages.', 7.00),
(5, 5, 'Jeu d\'échecs en bois', 'Échiquier artisanal, pièces sculptées, rangement intégré.', 20.00),
(6, 3, 'DVD Intouchables', 'Comédie française, neuf sous blister.', 6.00),
(6, 7, 'Ukulélé', 'Petit ukulélé soprano, cordes neuves, housse incluse.', 18.00),
(6, 6, 'Raquette de tennis', 'Raquette Wilson, grip neuf, bon état.', 22.00);

-- Photos associées aux objets
INSERT INTO photos (item_id, file_path) VALUES
(2, 'assets/images/casque.jpeg'),
(2, 'assets/images/casque2.jpeg'),
(2, 'assets/images/casuqe1.jpeg');

-- Échanges de test (différents statuts)
-- Échange 1: Bob propose son Jean contre Le Petit Prince d'Alice -> accepté
INSERT INTO exchanges (proposer_id, proposer_item_id, target_owner_id, target_item_id, status, created_at, updated_at) VALUES
(3, 4, 2, 1, 'accepted', '2026-01-15 10:30:00', '2026-01-15 14:00:00');

-- Historique pour cet échange accepté
INSERT INTO item_history (item_id, previous_owner_id, new_owner_id, exchanged_at) VALUES
(1, 2, 3, '2026-01-15 14:00:00'),
(4, 3, 2, '2026-01-15 14:00:00');

-- Mettre à jour les propriétaires après l'échange
UPDATE items SET owner_id = 3 WHERE id = 1;
UPDATE items SET owner_id = 2 WHERE id = 4;

-- Échange 2: Chloe propose DVD Inception contre Casque audio d'Alice -> refusé
INSERT INTO exchanges (proposer_id, proposer_item_id, target_owner_id, target_item_id, status, created_at, updated_at) VALUES
(4, 7, 2, 2, 'refused', '2026-01-20 09:00:00', '2026-01-20 16:00:00');

-- Échange 3: David propose Clavier contre Monopoly de Bob -> accepté
INSERT INTO exchanges (proposer_id, proposer_item_id, target_owner_id, target_item_id, status, created_at, updated_at) VALUES
(5, 10, 3, 5, 'accepted', '2026-02-01 11:00:00', '2026-02-01 15:30:00');

INSERT INTO item_history (item_id, previous_owner_id, new_owner_id, exchanged_at) VALUES
(5, 3, 5, '2026-02-01 15:30:00'),
(10, 5, 3, '2026-02-01 15:30:00');

UPDATE items SET owner_id = 5 WHERE id = 5;
UPDATE items SET owner_id = 3 WHERE id = 10;

-- Échange 4: Emma propose son Ukulélé contre Guitare d'Alice -> en attente
INSERT INTO exchanges (proposer_id, proposer_item_id, target_owner_id, target_item_id, status) VALUES
(6, 14, 2, 3, 'pending');

-- Échange 5: Bob propose Harry Potter contre Jeu d'échecs de David -> en attente
INSERT INTO exchanges (proposer_id, proposer_item_id, target_owner_id, target_item_id, status) VALUES
(3, 6, 5, 12, 'pending');
