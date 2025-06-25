    <?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'db_zalopedia');

    class Database
    {
        public $mysqli;

        function __construct()
        {
            $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($this->mysqli->connect_errno) {
                echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
            }
        }

        function select($table, $where = null)
        {
            $sql = "SELECT * FROM $table";

            if ($where != null && count($where) > 0) {
                $conditions = [];
                foreach ($where as $key => $value) {
                    $escaped_value = $this->mysqli->real_escape_string($value);
                    $conditions[] = "$key = '$escaped_value'";
                }
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }

            $result = $this->mysqli->query($sql);
            if (!$result) {
                throw new Exception("Query Error: " . $this->mysqli->error);
            }

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function insert($table, $data)
        {
            $sql = "INSERT INTO $table SET ";
            $sets = [];
            foreach ($data as $key => $value) {
                $escaped_value = $this->mysqli->real_escape_string($value);
                $sets[] = "$key = '$escaped_value'";
            }
            $sql .= implode(', ', $sets);

            if (!$this->mysqli->query($sql)) {
                throw new Exception("Insert Error: " . $this->mysqli->error);
            }

            return $this->mysqli->insert_id;
        }

        function update($table, $data, $where)
        {
            $sql = "UPDATE $table SET ";
            $sets = [];
            foreach ($data as $key => $value) {
                if ($value === null) {
                    continue;
                }
                $escaped_value = $this->mysqli->real_escape_string($value);
                $sets[] = "$key = '$escaped_value'";
            }
            $sql .= implode(', ', $sets);

            if (empty($where)) {
                throw new Exception("Update Error: WHERE condition is required.");
            }

            $conditions = [];
            foreach ($where as $key => $value) {
                $escaped_value = $this->mysqli->real_escape_string($value);
                $conditions[] = "$key = '$escaped_value'";
            }
            $sql .= " WHERE " . implode(' AND ', $conditions);

            if (!$this->mysqli->query($sql)) {
                throw new Exception("Update Error: " . $this->mysqli->error);
            }

            return $this->mysqli->affected_rows;
        }

        function delete($table, $where)
        {
            if (empty($where)) {
                throw new Exception("Delete Error: WHERE condition is required.");
            }

            $sql = "DELETE FROM $table WHERE ";
            $conditions = [];
            foreach ($where as $key => $value) {
                $escaped_value = $this->mysqli->real_escape_string($value);
                $conditions[] = "$key = '$escaped_value'";
            }
            $sql .= implode(' AND ', $conditions);

            if (!$this->mysqli->query($sql)) {
                throw new Exception("Delete Error: " . $this->mysqli->error);
            }

            return $this->mysqli->affected_rows;
        }


        function __destruct()
        {
            $this->mysqli->close();
        }
    }
