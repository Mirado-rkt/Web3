# Takalo-takalo - Plateforme d'échange d'objets

Plateforme FlightPHP permettant aux utilisateurs d'échanger des objets entre eux.

## 🎯 Fonctionnalités

### Partie 1 - Base
- ✅ Inscription et authentification
- ✅ Gestion de catégories d'objets (Admin)
- ✅ Mise en ligne d'objets personnels
- ✅ Consultation des objets des autres utilisateurs
- ✅ Proposition d'échange
- ✅ Gestion des propositions reçues (acceptation/refus)

### Partie 2 - Avancé
- 📊 Statistiques admin (nombre d'utilisateurs, d'échanges)
- 🔍 Barre de recherche par titre et catégorie
- 📜 Historique d'appartenance des objets
- 📸 Support des images d'objets (à implémenter)

## 🛠️ Stack Technique

- **Framework**: FlightPHP
- **Base de données**: MySQL / PostgreSQL
- **Session**: PHP native ($_SESSION)
- **CSS**: Vanilla CSS (pas de dépendances externes)

## 📋 Prérequis

- PHP 7.4+
- MySQL 5.7+ ou PostgreSQL 10+
- Composer

## 🚀 Installation & Configuration

### 1. **Cloner et installer les dépendances**

```bash
cd /home/mirindra/Documents/Web3
composer install
```

### 2. **Configurer la base de données**

Éditer `app/config/config.php` et adapter vos identifiants MySQL/PostgreSQL:

```php
'database' => [
    'host'     => 'localhost',
    'dbname'   => 'takalo_db',
    'user'     => 'root',
    'password' => '',
],
```

### 3. **Créer la base de données**

**MySQL:**
```bash
mysql -u root -p -e "CREATE DATABASE takalo_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p takalo_db < database/database.sql
```

**PostgreSQL:**
```bash
createdb takalo_db
psql takalo_db < database/database.sql
```

### 4. **Démarrer le serveur**

```bash
php -S localhost:8080 -t public
```

Accédez à: **http://localhost:8080**

## 👥 Comptes de test

| Email | Mot de passe | Rôle |
|-------|--------------|------|
| `admin@takalo.local` | (voir seeds.sql) | Admin |
| `alice@takalo.local` | (voir seeds.sql) | Utilisateur |
| `bob@takalo.local` | (voir seeds.sql) | Utilisateur |
| `chloe@takalo.local` | (voir seeds.sql) | Utilisateur |

*Note: Les mots de passe dans seeds.sql sont des hashs d'exemple. Pour tester, créez un compte via /register.*

## 📁 Structure du projet

```
app/
├── config/          # Configuration (database, routes, services)
├── controllers/     # Contrôleurs (Auth, Item, Exchange)
├── models/          # Modèles (User, Item, Exchange)
├── middlewares/     # Middleware personnalisé
├── utils/           # Classes utilitaires (ViewHelper, Session)
├── views/           # Templates HTML
│   ├── layout/      # Layout de base + footer
│   ├── auth/        # Pages login/register
│   ├── items/       # Gestion des objets
│   └── exchanges/   # Gestion des propositions
└── cache/           # Cache temporaire
database/
├── database.sql     # Schéma + données de test
└── ...
public/
├── index.php        # Point d'entrée
└── ...
```

## 🔗 Routes principales

| Route | Méthode | Description |
|-------|---------|-------------|
| `/` | GET | Page d'accueil |
| `/register` | GET/POST | Inscription |
| `/login` | GET/POST | Connexion |
| `/logout` | GET | Déconnexion |
| `/items` | GET | Liste des objets |
| `/items/:id` | GET | Détail d'un objet |
| `/my/items` | GET | Mes objets (connecté) |
| `/exchanges` | GET | Mes propositions reçues |
| `/exchanges/accept/:id` | GET | Accepter une proposition |
| `/exchanges/refuse/:id` | GET | Refuser une proposition |

## 🎨 Design

- Template responsive sans framework CSS externe
- Couleurs: Purple gradient (#667eea - #764ba2)
- Cartes (cards) pour la présentation des objets
- Componants réutilisables (buttons, forms, alerts)

## 👨‍💻 Équipe du projet

- **Alice Dupont** (ETU123456)
- **Bob Martin** (ETU654321)
- **Chloe Durand** (ETU789012)

*À adapter avec vos vrais noms et numéros ETU dans `app/views/layout/base.php`*

## 📌 Notes de développement

### Modèles
- `User::find()` / `User::findByEmail()` - Recherche utilisateurs
- `Item::all()` / `Item::find()` - Gestion des objets
- `Exchange::create()` / `Exchange::findByTargetOwner()` - Propositions

### Helpers
- `ViewHelper::render($app, 'view/path', ['data' => $value])` - Rendu avec layout
- `Session::get()` / `Session::set()` / `Session::flash()` - Gestion sessions

### Controllers
Tous les contrôleurs utilisent `ViewHelper::render()` pour afficher avec le layout automatiquement.

## 🔧 À faire

- [ ] Implémentation complète upload d'images
- [ ] Logique complète d'échange (transfert propriété + historique)
- [ ] Barre de recherche avec filtres avancés
- [ ] Dashboard admin avec statistiques
- [ ] Pagination des listes
- [ ] Emails de notification
- [ ] Tests unitaires

## 📝 Licences

Projet FlightPHP | Framework open-source MIT

---

**Créé avec ❤️ - février 2026**
