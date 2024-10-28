<?php
require 'db.php';

$id = 1; // ID du produit à modifier
$nouveauNom = 'Nom modifié';
$nouvelleDescription = 'Description modifiée';
$nouveauPrix = 15.00;
$nouveauStock = 200;

$sql = "UPDATE produits SET nom = ?, description = ?, prix = ?, stock = ? WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$nouveauNom, $nouvelleDescription, $nouveauPrix, $nouveauStock, $id]);

echo "Produit modifié avec succès.";
?>
