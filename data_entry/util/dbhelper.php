<?php

class DbHelper
{
    private $hostname = "127.0.0.1";
    private $username = "root";
    private $password = "";
    private $database = "data_entry";
    private $conn;

    // Constructor to initialize the database connection
    public function __construct()
    {
        // Create the connection
        $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

        // Check connection and throw error if failed
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Destructor to close the connection
    public function __destruct()
    {
        $this->conn->close();
    }

    //insert_Id

    public function getInsertId() {
        return $this->conn->insert_id;
    }

    // Method to prepare a statement with error handling
    public function prepare($query)
    {
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            // Detailed error message if preparation fails
            die('MySQL prepare error: ' . $this->conn->error);
        }
        return $stmt;
    }

    // Method to execute a query
    public function executeQuery($query)
    {
        if ($this->conn->query($query) === false) {
            // Handle query execution failure
            die('MySQL query execution error: ' . $this->conn->error);
        }
        return true;
    }

    // Method to get all records
    public function getAllRecords($table)
    {
        $sql = "SELECT * FROM `$table`";
        $result = $this->conn->query($sql);
        if ($result === false) {
            die('MySQL query error: ' . $this->conn->error);
        }

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    // Method to get a single record
    public function getRecord($table, $args)
    {
        $keys = array_keys($args);
        $values = array_values($args);
        $condition = [];
        for ($i = 0; $i < count($keys); $i++) {
            $condition[] = "`" . $keys[$i] . "` = '" . $values[$i] . "'";
        }
        $cond = implode(" AND ", $condition);
        $sql = "SELECT * FROM `$table` WHERE $cond";
        $query = $this->conn->query($sql);
        if ($query === false) {
            die('MySQL query error: ' . $this->conn->error);
        }
        return $query->fetch_assoc();
    }

    // Method to delete a record
    public function deleteRecord($table, $args)
    {
        $keys = array_keys($args);
        $values = array_values($args);
        $condition = [];
        for ($i = 0; $i < count($keys); $i++) {
            $condition[] = "`" . $keys[$i] . "` = '" . $values[$i] . "'";
        }
        $cond = implode(" AND ", $condition);
        $sql = "DELETE FROM `$table` WHERE $cond";
        $this->conn->query($sql);
        if ($this->conn->affected_rows === -1) {
            die('MySQL delete error: ' . $this->conn->error);
        }
        return $this->conn->affected_rows;
    }

    // Method to add a record
    public function addRecord($table, $args)
    {
        $keys = array_keys($args);
        $values = array_values($args);
        $key = implode("`, `", $keys);
        $value = implode("', '", $values);
        $sql = "INSERT INTO `$table` (`$key`) VALUES ('$value')";
        if ($this->conn->query($sql) === false) {
            die('MySQL insert error: ' . $this->conn->error);
        }
        return $this->conn->affected_rows;
    }

    // Method to update a record
    public function updateRecord($table, $args)
    {
        $keys = array_keys($args);
        $values = array_values($args);
        $condition = [];
        for ($i = 1; $i < count($keys); $i++) {
            $condition[] = "`" . $keys[$i] . "` = '" . $values[$i] . "'";
        }
        $sets = implode(", ", $condition);
        $sql = "UPDATE `$table` SET $sets WHERE `$keys[0]` = '$values[0]'";
        if ($this->conn->query($sql) === false) {
            die('MySQL update error: ' . $this->conn->error);
        }
        return $this->conn->affected_rows;
    }

    // Joining tables

    public function Joiningtables($id)
{
    $sql = "
        SELECT 
            data_entry_table.id AS data_entry_id,
            data_entry_table.name,
            data_entry_table.age,
            data_entry_table.status,
            data_entry_table.date_birth,
            data_entry_table.p_birth,
            data_entry_table.h_address,
            data_entry_table.occupation,
            data_entry_table.religion,
            data_entry_table.contact_num,
            data_entry_table.pantawid,
            data_entry_table.elementary,
            data_entry_table.high_school,
            data_entry_table.vocational,
            data_entry_table.college,
            data_entry_table.others,
            data_entry_table.school_community,
            data_entry_table.civic_community,
            data_entry_table.community_activities,
            data_entry_table.workspace_community,
            data_entry_table.sex,
            GROUP_CONCAT(
                CONCAT(
                    family_composition.family_name, ' (', 
                    family_composition.relationship, ', ',
                    family_composition.age, ' years old, ',
                    family_composition.occupation, ')'
                ) 
                SEPARATOR '; '
            ) AS family_details,
            GROUP_CONCAT(
                CONCAT(
                    seminar_trainings.title_trainings, ' on ',
                    seminar_trainings.date_train, ' (Organized by ',
                    seminar_trainings.organization, ')'
                )
                SEPARATOR '; '
            ) AS seminar_details
        FROM 
            data_entry_table
        LEFT JOIN
            family_composition ON family_composition.user_id = data_entry_table.id
        LEFT JOIN 
            seminar_trainings ON seminar_trainings.user_id = data_entry_table.id
        WHERE 
            data_entry_table.id = ?
        GROUP BY 
            data_entry_table.id
    ";

    $stmt = $this->conn->prepare($sql);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $this->conn->error);
    }
    
    $stmt->bind_param("i", $id);
    
    if (!$stmt->execute()) {
        die('Execute error: ' . $stmt->error);
    }
    
    $result = $stmt->get_result();
    $p_order = array();
    while ($row = $result->fetch_assoc()) {
        $p_order[] = (object) $row;
    }
    
    $stmt->close();

    return $p_order;
}


}
?>
