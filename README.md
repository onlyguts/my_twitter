# My E-Commerce App

## 📦 Prérequis
- [Node.js](https://nodejs.org/) (pour React)
- [Composer](https://getcomposer.org/) (pour Symfony)
- [Symfony CLI](https://symfony.com/download)
- [MySQL](https://www.mysql.com/) ou [PostgreSQL](https://www.postgresql.org/)

## 🚀 Installation du projet

### 1️⃣ **Cloner le Repo**
```bash
git clone https://github.com/onlyguts/my_ecommerce.git
cd my_ecommerce
```

### 2️⃣ **Installation du backend (Symfony)**
```bash
cd backend
composer install
```

#### **Configurer les variables d'environnement**
Copiez le fichier `.env` et renommez-le `.env.local`, puis modifiez la ligne de connexion à la base de données :
```env
DATABASE_URL=mysql://user:password@127.0.0.1:3306/ecommerce_db
```

#### **Créer la base de données et appliquer les migrations**
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load # Si vous avez des données de test
```

### 3️⃣ **Installation du frontend (React)**
```bash
cd ../frontend
npm install
```

### 4️⃣ **Lancer les serveurs**
**Backend (Symfony)** :
```bash
cd backend
symfony server:start
```

**Frontend (React)** :
```bash
cd frontend
npm start
```

---

## ✨ Fonctionnalités

### 🛒 Gestion des Produits
- Ajout, modification et suppression de produits
- Affichage des détails d'un produit
- Gestion des stocks

### 👥 Gestion des Utilisateurs
- Inscription / Connexion / Déconnexion
- Gestion du profil utilisateur
- Système d'administrateur

### 🛍️ Commandes et Paiement
- Ajout au panier
- Validation et paiement sécurisé (ex : Stripe, PayPal)
- Historique des commandes

### 🔍 Recherche et Filtrage
- Recherche de produits par nom ou catégorie
- Filtres avancés (prix, disponibilité, promotions)

### 📦 Gestion des Livraisons
- Suivi des commandes
- Intégration avec des services de livraison

## 📸 Captures d'écran
![image](https://github.com/user-attachments/assets/d01012f0-dcdd-4221-b192-098a9079d9db)
![image](https://github.com/user-attachments/assets/6bc329d3-1e7f-47ea-8b01-2791356f33e5)
![image](https://github.com/user-attachments/assets/6d6a4a24-02d9-4822-ac13-c8601e3d4bb6)




