<?php
class Database {
    protected $host;
    protected $user;
    protected $password;
    protected $db_name;
    protected $conn;

    public function __construct() {
        $this->getConfig();
        $this->connect();
    }

    private function getConfig() {
        include_once("config.php");
        $this->config = $config ?? [];
        $this->host = $this->config['localhost'];
        $this->user = $this->config['username'];
        $this->password = $this->config['password'];
        $this->db_name = $this->config['db_name'];
    }
    

    private function connect() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->db_name);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }

    public function get($table, $where = null) {
        if ($where) {
            $where = " WHERE " . $where;
        }
        $sql = "SELECT * FROM " . $table . $where;
        $result = $this->conn->query($sql);
        $data = $result->fetch_assoc();
        return $data;
    }

    public function insert($table, $data) {
        if (is_array($data)) {
            $columns = implode(",", array_keys($data));
            $values = "'" . implode("','", array_values($data)) . "'";
        }
        $sql = "INSERT INTO " . $table . " (" . $columns . ") VALUES (" . $values . ")";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function update($table, $data, $where) {
        $update_value = "";
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                $update_value[] = "$key='{$val}'";
            }
            $update_value = implode(",", $update_value);
        }
        $sql = "UPDATE " . $table . " SET " . $update_value . " WHERE " . $where;
        $result = $this->conn->query($sql);
        return $result;
    }

    public function delete($table, $filter) {
        $sql = "DELETE FROM " . $table . " " . $filter;
        $result = $this->conn->query($sql);
        return $result;
    }
}
?>
