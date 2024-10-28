<?php
require 'db.php';

$id = 1; // ID du produit à supprimer

$sql = "DELETE FROM produits WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

echo "Produit supprimé avec succès.";
?>
