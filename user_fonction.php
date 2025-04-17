<?php
function changeUserPassword($conn, $user_id, $current_password, $new_password) {
    try {
        $query = "SELECT password FROM USER WHERE ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return [
                'success' => false,
                'message' => "Utilisateur non trouvé"
            ];
        }

        if (!password_verify($current_password, $user['password'])) {
            return [
                'success' => false,
                'message' => "Le mot de passe actuel est incorrect"
            ];
        }

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $query = "UPDATE USER SET password = ? WHERE ID = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([$hashed_password, $user_id]);

        if ($result) {
            return [
                'success' => true,
                'message' => "Mot de passe modifié avec succès"
            ];
        } else {
            return [
                'success' => false,
                'message' => "Erreur lors de la mise à jour du mot de passe"
            ];
        }
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => "Erreur de base de données: " . $e->getMessage()
        ];
    }
}