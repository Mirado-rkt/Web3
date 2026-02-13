# 🧪 GUIDE DE TEST - TAKALO-TAKALO

**Date:** 10 février 2026  
**Plateforme:** Prêt à tester

---

## 🚦 PRÉ-REQUIS

- ✅ Base de données MySQL/MariaDB configurée
- ✅ FlightPHP installé via composer
- ✅ Serveur web pointant vers `/public`
- ✅ Catégories créées par un admin

---

## 🧑‍💼 SCÉNARIO 1: Utilisateur Non-Connecté

### Étape 1: Voir l'accueil
1. Accédez à `/` (racine)
2. Vérifier:
   - ✅ Logo avec gradient bleu
   - ✅ Message de bienvenue "Bienvenue sur Takalo-takalo"
   - ✅ Boutons "S'inscrire" et "Se connecter" visibles
   - ✅ Footer bleu fixe en bas

### Étape 2: S'inscrire
1. Cliquez sur "S'inscrire" ou allez à `/register`
2. Remplissez:
   - Nom: `Jean Dupont`
   - Email: `jean@example.com`
   - Mot de passe: `Password123!`
   - Confirmez le mot de passe
3. Cliquez "S'inscrire"
4. Vérifier:
   - ✅ Inscription réussie
   - ✅ Redirection vers `/login`
   - ✅ Message de succès affiché

### Étape 3: Se connecter
1. Allez à `/login`
2. Remplissez:
   - Email: `jean@example.com`
   - Mot de passe: `Password123!`
3. Cliquez "Se connecter"
4. Vérifier:
   - ✅ Connexion réussie
   - ✅ Redirection vers `/items` ou `/my/items`
   - ✅ Session utilisateur active

---

## 📦 SCÉNARIO 2: Gestion des Objets

### Étape 1: Créer un objet
1. Allez à `/my/items` (depuis le menu connecté)
2. Cliquez "+ Ajouter un objet"
3. Remplissez:
   - Titre: `Vélo de montagne`
   - Description: `Excellent état, peu utilisé`
   - Catégorie: `Sports` (ou autre existante)
   - Prix estimatif: `250.00`
   - Photos: Téléchargez une ou plusieurs images
4. Cliquez "Créer l'objet"
5. Vérifier:
   - ✅ Objet créé avec succès
   - ✅ Redirection vers `/my/items`
   - ✅ Objet apparaît dans la liste avec photo

### Étape 2: Voir la fiche de mon objet
1. Dans `/my/items`, cliquez "Voir" sur l'objet créé
2. Vérifier la page `/items/[id]`:
   - ✅ Galerie de photos complète
   - ✅ Titre, catégorie, propriétaire, prix
   - ✅ Section "Historique d'appartenance" (vide au début)
   - ✅ Bouton de proposition d'échange (pour les autres)

### Étape 3: Éditer mon objet
1. Dans `/my/items`, cliquez "Éditer" sur un objet
2. Modifiez le titre: `Vélo de montagne (neuf modèle 2024)`
3. Ajoutez une photo supplémentaire
4. Cliquez "Mettre à jour"
5. Vérifier:
   - ✅ Objet modifié avec succès
   - ✅ Photos additionnelles ajoutées
   - ✅ Changements visibles dans `/my/items`

### Étape 4: Supprimer mon objet
1. Dans `/my/items`, cliquez "Supprimer" sur un objet
2. Confirmez la suppression (popup)
3. Vérifier:
   - ✅ Objet supprimé
   - ✅ Redirection vers `/my/items`
   - ✅ Objet n'apparaît plus dans la liste

---

## 🔍 SCÉNARIO 3: Recherche et Filtre

### Étape 1: Recherche par titre
1. Allez à `/items` (liste publique)
2. Entrez `Vélo` dans le champ "Mot-clé"
3. Cliquez "Rechercher"
4. Vérifier:
   - ✅ Seuls les objets contenant "Vélo" dans le titre/description
   - ✅ URL: `/items?keyword=Vélo`

### Étape 2: Filtre par catégorie
1. Restez sur `/items`
2. Sélectionnez une catégorie depuis la liste déroulante
3. Cliquez "Rechercher"
4. Vérifier:
   - ✅ Seuls les objets de cette catégorie
   - ✅ URL: `/items?category_id=2` (ou autre ID)

### Étape 3: Recherche combinée
1. Entrez `Vélo` + sélectionnez `Sports`
2. Cliquez "Rechercher"
3. Vérifier:
   - ✅ Objets avec "Vélo" dans le titre ET catégorie Sports uniquement
   - ✅ URL: `/items?keyword=Vélo&category_id=2`

### Étape 4: Réinitialiser
1. Cliquez "Réinitialiser"
2. Vérifier:
   - ✅ Retour à la liste complète
   - ✅ Formulaire vidé
   - ✅ URL: `/items`

---

## 🤝 SCÉNARIO 4: Proposition d'Échange

### Pré-requis: Créer 2 utilisateurs avec objets

#### Utilisateur 1 (Jean)
- Email: `jean@example.com`
- Objet: Vélo (`/my/items`)

#### Utilisateur 2 (Marie)
- Email: `marie@example.com`
- Objet: Caméra

### Étape 1: Proposer un échange (Marie)
1. Se connecter en tant que Marie
2. Aller à `/items`
3. Cliquer sur le Vélo de Jean
4. Voir la fiche avec `Historique d'appartenance` (vide)
5. Sélectionner "Caméra" dans le dropdown "Choisir mon objet"
6. Cliquer "Proposer un échange"
7. Vérifier:
   - ✅ Message "Proposition envoyée"
   - ✅ Redirection vers `/items`

### Étape 2: Voir les propositions reçues (Jean)
1. Déconnectez Marie (logout)
2. Connectez Jean
3. Allez à `/exchanges`
4. Vérifier le tableau:
   - ✅ Colonne "De": Marie
   - ✅ Colonne "Mon objet": Vélo
   - ✅ Colonne "Son objet": Caméra
   - ✅ Colonne "Statut": "En attente"
   - ✅ Boutons "Accepter" et "Refuser"

### Étape 3: Accepter la proposition (Jean)
1. Cliquez "Accepter"
2. Vérifier:
   - ✅ Message "Proposition acceptée"
   - ✅ Tableau mis à jour: Statut = "Accepté"
   - ✅ Boutons d'action disparus

### Étape 4: Vérifier l'historique d'appartenance
1. Allez à `/items` et cliquez sur le Vélo
2. Vérifier l'historique:
   - ✅ Section "Historique d'appartenance" avec table
   - ✅ Ligne: Marie | Date exacte de l'échange
   - ✅ Nouveau propriétaire = Marie

### Étape 5: Contrôler la propriété (Marie)
1. Déconnectez Jean
2. Connectez Marie
3. Allez à `/my/items`
4. Vérifier:
   - ✅ Le Vélo apparaît dans "Mes objets"
   - ✅ Propriétaire = Marie

---

## 👨‍💼 SCÉNARIO 5: Admin

### Étape 1: Accès Admin
1. Allez à `/admin/login`
2. Remplissez:
   - Username: `admin`
   - Password: `admin`
3. Cliquez "Se connecter"
4. Vérifier:
   - ✅ Accès au Dashboard
   - ✅ URL: `/admin`

### Étape 2: Voir le Dashboard
1. Dashboard `/admin` affiche 3 stats:
   - ✅ **Utilisateurs inscrits**: Nombre correct (ex: 2)
   - ✅ **Échanges effectués**: Nombre correct (ex: 1 si 1 accepté)
   - ✅ **Catégories**: Nombre exact de catégories
2. Vérifier les boutons:
   - ✅ "Voir les utilisateurs" → `/admin/users`
   - ✅ "Voir les échanges" → `/admin/exchanges`
   - ✅ "Gérer les catégories" → `/admin/categories`

### Étape 3: Liste des utilisateurs
1. Cliquez "Voir les utilisateurs" ou allez à `/admin/users`
2. Vérifier le tableau:
   - ✅ Colonne ID: #1, #2, etc.
   - ✅ Colonne Nom: Jean, Marie
   - ✅ Colonne Email: jean@example.com, marie@example.com
   - ✅ Colonne "Date d'inscription": Format DD/MM/YYYY HH:MM

### Étape 4: Historique des échanges
1. Allez à `/admin/exchanges` (depuis dashboard)
2. Vérifier le tableau:
   - ✅ Colonne "De": Marie
   - ✅ Colonne "Propose": Caméra
   - ✅ Colonne "À": Jean
   - ✅ Colonne "Contre": Vélo
   - ✅ Colonne "Statut": Accepted
   - ✅ Colonne "Date": Format DD/MM/YYYY HH:MM

### Étape 5: Gestion des catégories
1. Allez à `/admin/categories`
2. Vérifier:
   - ✅ Liste de toutes les catégories
   - ✅ Bouton "+ Créer une catégorie"
   - ✅ Bouton "Supprimer" pour chaque catégorie
3. Créez une catégorie:
   - Titre: `Automobile`
   - Cliquez "Créer"
   - ✅ Catégorie apparaît dans la liste

---

## 🎨 SCÉNARIO 6: Vérification du Design

À chaque étape, vérifiez:

### Couleurs
- ✅ Fond body: Gradient bleu (ciel → nuit)
- ✅ Boutons primaires: Bleu ciel avec shadow
- ✅ Logos/titres: Gradient bleu
- ✅ Footer: Bleu nuit avec bordure cyan
- ✅ Aucune trace de purple (#667eea)

### Layout
- ✅ Contenu centré avec padding
- ✅ Footer toujours en bas même si peu de contenu
- ✅ Responsive sur mobile
- ✅ Images bien alignées

### Navigation
- ✅ Tous les liens de navigation fonctionnels
- ✅ Retours "Retour" ou "Annuler" présents
- ✅ Menus accessibles depuis chaque page

---

## 🐛 CHECKLIST DE DÉBOGAGE

Si un test échoue, vérifiez:

1. **Erreur de base de données**
   - ✅ Vérifier que toutes les tables existent
   - ✅ Vérifier les colonnes requis dans les modèles

2. **Erreur 404 (page non trouvée)**
   - ✅ Route définie dans `/app/config/routes.php`?
   - ✅ Vue fichier existe dans `/app/views/`?

3. **Erreur de session/authentification**
   - ✅ Vérifier `app\utils\Session` est utilisée
   - ✅ Session::set('user', ...) appelé lors du login

4. **Photos ne s'affichent pas**
   - ✅ Dossier `/public/uploads/` existe?
   - ✅ Permissions en écriture (755 ou 777)?

5. **Historique d'appartenance vide**
   - ✅ Table `item_history` existe?
   - ✅ Trigger INSERT appelé quand échange accepté?

---

## ✨ RÉSUMÉ

Après avoir suivi tous ces scénarios:
- ✅ Vous aurez testé les **8 fonctionnalités** (4+4)
- ✅ Vous aurez vérifié le **design bleu complet**
- ✅ Vous aurez confirmé la **traçabilité des échanges**
- ✅ Vous aurez validé tous les **liens et boutons**
- ✅ La plateforme est **ready for production** 🚀

**Bonne chance! 🎉**
