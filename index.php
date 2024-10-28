<?php
require 'db.php';

// Initialisation des variables pour garder l'ID et les données du produit en cours de modification
$editProduct = null;

// Ajout d'un produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];
    $stmt = $pdo->prepare("INSERT INTO produits (nom, description, prix, stock) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $description, $prix, $stock]);
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Préparer les données du produit pour modification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_request') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    $editProduct = $stmt->fetch();
}

// Modification d'un produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];
    $stmt = $pdo->prepare("UPDATE produits SET nom = ?, description = ?, prix = ?, stock = ? WHERE id = ?");
    $stmt->execute([$nom, $description, $prix, $stock, $id]);
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Suppression d'un produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Gestion de la recherche et des filtres
$filters = [];
$sql = "SELECT * FROM produits";

if (isset($_GET['search']) && $_GET['search'] !== '') {
    $filters[] = "nom LIKE :search";
}
if (isset($_GET['min_price']) && $_GET['min_price'] !== '') {
    $filters[] = "prix >= :min_price";
}
if (isset($_GET['max_price']) && $_GET['max_price'] !== '') {
    $filters[] = "prix <= :max_price";
}
if (isset($_GET['stock']) && $_GET['stock'] !== '') {
    $filters[] = "stock = :stock";
}

if ($filters) {
    $sql .= " WHERE " . implode(" AND ", $filters);
}

$stmt = $pdo->prepare($sql);

if (isset($_GET['search']) && $_GET['search'] !== '') {
    $stmt->bindValue(':search', '%' . $_GET['search'] . '%');
}
if (isset($_GET['min_price']) && $_GET['min_price'] !== '') {
    $stmt->bindValue(':min_price', $_GET['min_price']);
}
if (isset($_GET['max_price']) && $_GET['max_price'] !== '') {
    $stmt->bindValue(':max_price', $_GET['max_price']);
}
if (isset($_GET['stock']) && $_GET['stock'] !== '') {
    $stmt->bindValue(':stock', $_GET['stock']);
}

$stmt->execute();
$produits = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion d'inventaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
            color: #333;
        }

        h1 {
            color: #007bff;
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        h2 {
            color: #007bff;
            font-size: 1.8em;
            margin-bottom: 15px;
        }

        .form-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        form {
            background: #fff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            max-width: 650px;
            flex: 1;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            max-width: 80%;
            display: flex;
        }

        button {
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        button[type="submit"] {
            background-color: #007bff;
        }

        .produits-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .produit {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 100%;
            max-width: 250px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
            box-sizing: border-box;
        }

        .produit:hover {
            transform: scale(1.05);
        }

        .produit h3 {
            color: #333;
            margin: 0 0 10px;
        }

        .produit p {
            font-size: 1em;
            margin: 5px 0;
        }

        .actions {
            margin-top: 10px;
            display: flex;
            gap: 5px;
            justify-content: space-between;
        }

        .actions form {
            display: inline-block;
            flex: 1;
        }

        .btn-edit,
        .btn-delete {
            padding: 8px 10px;
            color: #fff;
            border-radius: 5px;
            font-size: 0.9em;
            cursor: pointer;
            transition: background-color 0.3s ease;
            border: none;
            flex: 1;
            text-align: center;
        }

        .btn-edit {
            background-color: #28a745;
        }

        .btn-edit:hover {
            background-color: #218838;
        }

        .btn-delete {
            background-color: #ff4d4f;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <h1>Inventaire des Produits</h1>

    <!-- Formulaire pour ajouter un produit et filtrer -->
    <center> <h2>Ajouter un produit et filtrer</h2></center>
    <div class="form-container">
        <form method="post">
            <input type="hidden" name="action" value="add">
            <label>Nom: <input type="text" name="nom" required></label><br>
            <label>Description: <textarea name="description" required></textarea></label><br>
            <label>Prix: <input type="number" step="0.01" name="prix" required></label><br>
            <label>Stock: <input type="number" name="stock" required></label><br>
            <button type="submit">Ajouter</button>
        </form>

        <form method="get">
            <h3>Filtrer</h3>
            <label>Recherche: <input type="text" name="search"></label><br>
            <label>Prix min: <input type="number" step="0.01" name="min_price"></label><br>
            <label>Prix max: <input type="number" step="0.01" name="max_price"></label><br>
            <label>Stock: <input type="number" name="stock"></label><br>
            <button type="submit">Filtrer</button>
        </form>
    </div>

    <!-- Liste des produits -->
    <center><h2>Liste des produits</h2></center>
    <div class="produits-container">
        <?php foreach ($produits as $produit): ?>
            <div class="produit">
                <h3><?= htmlspecialchars($produit['nom']) ?></h3>
                <p>Description: <?= htmlspecialchars($produit['description']) ?></p>
                <p>Prix: <?= htmlspecialchars($produit['prix']) ?> €</p>
                <p>Stock: <?= htmlspecialchars($produit['stock']) ?></p>
                <div class="actions">
                    <form method="post">
                        <input type="hidden" name="id" value="<?= $produit['id'] ?>">
                        <input type="hidden" name="action" value="edit_request">
                        <button class="btn-edit" type="submit">Modifier</button>
                    </form>
                    <form method="post">
                        <input type="hidden" name="id" value="<?= $produit['id'] ?>">
                        <input type="hidden" name="action" value="delete">
                        <button class="btn-delete" type="submit">Supprimer</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($editProduct): ?>
        <h2>Modifier le produit</h2>
        <form method="post">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $editProduct['id'] ?>">
            <label>Nom: <input type="text" name="nom" value="<?= htmlspecialchars($editProduct['nom']) ?>" required></label><br>
            <label>Description: <textarea name="description" required><?= htmlspecialchars($editProduct['description']) ?></textarea></label><br>
            <label>Prix: <input type="number" step="0.01" name="prix" value="<?= htmlspecialchars($editProduct['prix']) ?>" required></label><br>
            <label>Stock: <input type="number" name="stock" value="<?= htmlspecialchars($editProduct['stock']) ?>" required></label><br>
            <button type="submit">Modifier le produit</button>
        </form>
    <?php endif; ?>
</body>
</html>
