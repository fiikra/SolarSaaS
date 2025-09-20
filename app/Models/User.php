<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class User extends Model
{
    protected $table = 'users';

    /**
     * Crée un nouvel utilisateur avec un mot de passe haché.
     *
     * @param int    $clientId L'ID du client auquel l'utilisateur appartient.
     * @param string $name     Le nom complet de l'utilisateur.
     * @param string $email    L'email de l'utilisateur (doit être unique).
     * @param string $password Le mot de passe en clair.
     * @param string $role     Le rôle de l'utilisateur ('user' ou 'admin').
     * @return int|false L'ID de l'utilisateur inséré ou false en cas d'échec.
     */
    public function create($data)
    {
        $this->db->query('INSERT INTO users (client_id, name, email, password, role_id) VALUES (:client_id, :name, :email, :password, :role_id)');
        $this->db->bind(':client_id', $data['client_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        // In registration, role is 'admin' which has id 1
        $this->db->bind(':role_id', 1);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    /**
     * Trouve un utilisateur par son adresse email.
     *
     * @param string $email
     * @return mixed L'utilisateur trouvé ou false.
     */
    public function findByEmail($email)
    {
        $this->db->query('
            SELECT u.*, r.name as role_name 
            FROM ' . $this->table . ' u
            JOIN roles r ON u.role_id = r.id
            WHERE u.email = :email
        ');
        $this->db->bind(':email', $email);
        return $this->db->single();
    }
    
    /**
     * Récupère tous les utilisateurs d'un client spécifique.
     *
     * @param int $clientId
     * @return array La liste des utilisateurs.
     */
    public function getUsersByClientId($clientId)
    {
        $this->db->query('
            SELECT u.id, u.name, u.email, r.name as role 
            FROM users u
            JOIN roles r ON u.role_id = r.id
            WHERE u.client_id = :client_id
        ');
        $this->db->bind(':client_id', $clientId);
        return $this->db->resultSet();
    }
    
    /**
     * Compte le nombre d'utilisateurs pour un client.
     *
     * @param int $clientId
     * @return int Le nombre d'utilisateurs.
     */
    public function countByClientId($clientId)
    {
        $this->db->query('SELECT COUNT(*) as user_count FROM users WHERE client_id = :client_id');
        $this->db->bind(':client_id', $clientId);
        return $this->db->single()->user_count;
    }
    
    /**
     * Supprime un utilisateur, en s'assurant qu'il appartient au bon client (sécurité).
     *
     * @param int $id       L'ID de l'utilisateur à supprimer.
     * @param int $clientId L'ID du client de l'administrateur effectuant l'action.
     * @return bool True si la suppression a réussi, false sinon.
     */
    public function delete($id, $clientId)
    {
        $this->db->query('DELETE FROM users WHERE id = :id AND client_id = :client_id');
        $this->db->bind(':id', $id);
        $this->db->bind(':client_id', $clientId);
        return $this->db->execute();
    }

    public function findById($id)
    {
        $this->db->query('
            SELECT u.*, r.name as role_name, r.id as role_id
            FROM ' . $this->table . ' u
            JOIN roles r ON u.role_id = r.id
            WHERE u.id = :id
        ');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateLastLogin($id)
    {
        $this->db->query('UPDATE users SET last_login = NOW() WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function findAdminsAndProjectManagers($clientId)
    {
        $this->db->query("
            SELECT u.id, u.email
            FROM users u
            JOIN roles r ON u.role_id = r.id
            WHERE u.client_id = :client_id AND r.name IN ('Admin', 'Project Manager')
        ");
        $this->db->bind(':client_id', $clientId);
        return $this->db->resultSet();
    }

    public function enable2FA($userId, $secret)
    {
        $this->db->query('UPDATE users SET google2fa_secret = :secret, google2fa_enabled = 1 WHERE id = :id');
        $this->db->bind(':secret', $secret);
        $this->db->bind(':id', $userId);
        return $this->db->execute();
    }

    public function disable2FA($userId)
    {
        $this->db->query('UPDATE users SET google2fa_secret = NULL, google2fa_enabled = 0 WHERE id = :id');
        $this->db->bind(':id', $userId);
        return $this->db->execute();
    }
}

