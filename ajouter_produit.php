<?php
require 'db.php';

$nom = 'Nom du Produit';
$description = 'Description du produit';
$prix = 10.00;
$stock = 100;

$sql = "INSERT INTO produits (nom, description, prix, stock) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$nom, $description, $prix, $stock]);

echo "Produit ajouté avec succès.";
?>
