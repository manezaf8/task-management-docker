<?php

/**
 * @package   Task Management
 * @author    Ntabethemba Ntshoza
 * @date      11-10-2023
 * @copyright Copyright © 2023 VMP By Maneza
 */


// use User;

require 'Connection.php';

class Task
{
    private $id;
    private $title;
    private $description;
    private $dueDate;
    private $userId;
    private $completed;

    /**
     * Set Id
     *
     * @param [type] $id
     * @return void
     */
    public function setId($id)
    {
        // Validate and sanitize the ID, e.g., ensure it's a positive integer
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        // Validate and sanitize the title, e.g., ensure it's not empty
        $title = trim($title);
        if (!empty($title)) {
            $this->title = $title;
        } else {
            throw new InvalidArgumentException('Title cannot be empty');
        }
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDescription($description)
    {
        //validation for the description if needed
        $this->description = trim($description); //remove empty spaces 
        $this->description = strip_tags($description); //remove html tags;
        $this->description = stripslashes($description); //remove empty spaces;
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDueDate($dueDate)
    {
        if ($dueDate !== null) {
            $this->dueDate = $dueDate;
        }
    }

    public function getDueDate()
    {
        return $this->dueDate;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setCompleted($completed)
    {
        $this->completed = (bool)$completed;
    }

    public function getCompleted($completed)
    {
        return $this->completed;
    }

    public function isCompleted()
    {
        return $this->completed;
    }

    /**
     * Save New users
     *
     * @return bool
     */
    public function save()
    {
        global $db; // Use the database connection from connect.php

        // Prepare the SQL statement
        $sql = "INSERT INTO tasks (title, description, due_date, user_id, completed) 
        VALUES (?, ?, ?, ?, ?)";
        var_dump($sql);
        // You should adjust this logic based on your actual application flow.
        $userId = null; // Initialize user ID as null

        if (isset($_POST["id"])) {
            $userId = $_POST["id"];
        }

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        }

        // Bind parameters and execute the query
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sssii", $this->title, $this->description, $this->dueDate, $userId, $this->completed);

        if ($stmt->execute()) {

            $_SESSION['task_saved'] = "Task: {$this->title} Saved successfully";

            return true; // 
        } else {
            return false; // Task could not be saved
        }
    }

    /**
     * Get All Tasks
     *
     * @return array
     */
    public static function getAllTasks()
    {
        global $db; // Use the database connection from connect.php

        // Perform a query to fetch tasks from the database
        $sql = "SELECT * FROM tasks";
        $result = $db->query($sql);

        $tasks = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $task = new Task();
                $task->setId($row['id']);
                $task->setTitle($row['title']);
                $task->setDescription($row['description']);
                $task->setDueDate($row['due_date']);
                $task->setUserId($row['user_id']);
                $task->setCompleted($row['completed']);
                $tasks[] = $task;
            }
        }

        return $tasks;
    }

    /**
     * Update Tasks
     *
     * @return void
     */
    public function update()
    {
        global $db; // Use the database connection from connect.php

        // Prepare the SQL statement
        $sql = "UPDATE tasks 
                SET title = ?, description = ?, due_date = ?, user_id = ?, completed = ? 
                WHERE id = ?";
        $userId = null;

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        }
        // Bind parameters and execute the query
        $stmt = $db->prepare($sql);
        $stmt->bind_param(
            "sssiii",
            $this->title,
            $this->description,
            $this->dueDate,
            $this->userId,
            $this->completed,
            $this->id
        );

        if ($stmt->execute()) {
            $_SESSION['task_updated'] = "Task: {$this->title} Updated successfully";
            return true; // Task updated successfully
        } else {
            return false; // Task could not be updated
        }
    }

    // Function to delete a task from the database
    public function delete($id)
    {
        global $db; // Use the database connection from connect.php

        // Prepare the SQL statement
        $sql = "DELETE FROM tasks WHERE id = ?";

        // Bind parameters and execute the query
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true; // Task deleted successfully
        } else {
            return false; // Task could not be deleted
        }
    }

    /**
     * Get Tasks by ID
     *
     * @param mixed $id
     * 
     */
    public static function getTaskById($id)
    {
        global $db; // Use the database connection from connect.php

        // Prepare the SQL statement
        $sql = "SELECT * FROM tasks WHERE id = ?";

        // Bind parameters and execute the query
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Fetch the result as an associative array
            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $taskData = $result->fetch_assoc();
                $task = new Task();
                $task->setId($taskData['id']);
                $task->setTitle($taskData['title']);
                $task->setDescription($taskData['description']);
                $task->setDueDate($taskData['due_date']);
                $task->setUserId($taskData['user_id']);
                $task->setCompleted($taskData['completed']);
                return $task;
            } else {
                return null; // Task with the given ID not found
            }
        } else {
            return null; // Error in executing the query
        }
    }
}
