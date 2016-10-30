<?php

class ProductComments
{
	protected $db;

	/**
	 * FOR DEMONSTRATION PURPOSES ONLY, DO NOT DO THIS!
	 */
	const DB_HOST = '127.0.0.1';
	const DB_USER = 'homestead';
	const DB_PASS = 'secret';
	const DB_NAME = 'homestead';

	public function __construct() {
		// This should be it's own class...
		$this->db = new mysqli(self::DB_HOST, self::DB_USER, self::DB_PASS, self::DB_NAME);

		if ($this->db->connect_errno) {
			die("Fatal Error. Could not connect to DB. Error: " . $this->db->connect_error . " (" . $this->db->connect_errno . ")");
		}
	}

	public function addComment($form_data) {
		// DEBUG: Do data validation here

		$sql = $this->db->prepare("INSERT INTO comments SET user_id=?, product_id=?, comment=?");

		$sql->bind_param('iis', $form_data['user_id'], $form_data['product_id'], $form_data['comment']);

		$sql->execute();

		if ($sql->affected_rows === 0) {
			die("Fatal Error. Comment could not be inserted.");
		}

		return true;
	}

	/**
	 * Should be in Product model
	 */
	public function getProducts() {
		$sql = $this->db->query("SELECT id, name FROM products");
		return $sql->fetch_all(MYSQLI_ASSOC);
	}

	/**
	 * Should be in User/Auth model
	 */
	public function getUsers() {
		$sql = $this->db->query("SELECT id, name FROM users");
		return $sql->fetch_all(MYSQLI_ASSOC);
	}

	/**
	 * Get # of unread comments on a product for a user
	 */
	public function getUnreadCountForUser($user_id) {
		$sql = $this->db->prepare(
			"SELECT p.name, count(c.id) as unread
			   FROM comments c
			   JOIN products p ON p.id = c.product_id
			  WHERE c.user_id = ?
				AND `read` = 0
			  GROUP BY p.name"
		);

		$sql->bind_param("i", $user_id);

		if (! $sql->execute()) {
			return false;
		}

		$result = $sql->get_result();
		
		return $result->fetch_all();
	}
}

?>