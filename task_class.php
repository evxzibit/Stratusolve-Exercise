<?php
/**
 * This class handles the modification of a task object
 */
class Task {
    public $taskId;
    public $taskName;
    public $taskDescription;
    protected $taskDataSource;
    protected $sourceFile;

/**
 * Task contructor
 * @param int $id [description]
 */
    public function __construct($id = null) {
        $this->sourceFile = 'task_data.txt';
        $this->taskDataSource = file_get_contents($this->sourceFile);
        if (strlen($this->taskDataSource) > 0)
            $this->taskDataSource = json_decode($this->taskDataSource); // Should decode to an array of Task objects
        else
            $this->taskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array

        if (!$this->taskDataSource)
            $this->taskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array
        if (!$this->loadFromId($id))
            $this->create();
    }

/**
 * Initialise task data for new values
 */
    protected function create() {
        $this->taskId = $this->getUniqueId();
        $this->taskName = !empty($_POST['taskName']) ? $_POST['taskName'] : 'New name';
        $this->taskDescription = !empty($_POST['taskDescription']) ? $_POST['taskDescription'] : 'New description';
    }

/**
 * Creates new task
 */
    public function createNewTask() {
        $task = new \stdClass();
        $task->taskId = $this->taskId;
        $task->taskName = $this->taskName;
        $task->taskDescription = $this->taskDescription;
        $this->taskDataSource[] = $task;
        $this->save();        
    }

/**
 * Update a specific task
 * @param  int $id the task id to update
 */
    public function updateTask($id) {
        foreach ($this->taskDataSource as &$taskData) {
            if ($taskData->taskId == $id) {
                $taskData->taskName = $_POST['taskName'];
                $taskData->taskDescription = $_POST['taskDescription'];
            }
        }
        $this->save();
    }

/**
 * Generates a new task id
 * @return int The task id generated
 */
    protected function getUniqueId() {
        // Assignment: Code to get new unique ID
        $lastIndex = end(array_keys($this->taskDataSource));
        return (int)$this->taskDataSource[$lastIndex]->taskId + 1;
    }

/**
 * Loads a tasj using an id
 * @param  int $id The task id to load
 * @return object|null The task object or null if none found
 */
    protected function loadFromId($id = null) {
        if ($id) {
            foreach($this->taskDataSource as $struct) {
                if ($struct->taskId == $id) {
                    return $struct;
                }
            }
            return null;
        } else
            return null;
    }

/**
 * Writes the datasource to a file
 */
    public function save() {
        $return = ['success' => false];
        $taskDataSource = json_encode($this->taskDataSource);
        if (file_put_contents($this->sourceFile, $taskDataSource) !== false) {
            $return = ['success' => true];
        }
        echo json_encode($return);
    }

/**
 * Deletes a task given a task id
 * @param int $id The task id to delete
 */
    public function delete($id = null) {
        foreach ($this->taskDataSource as $key => $taskData) {
            if ($taskData->taskId == $id) {
                unset($this->taskDataSource[$key]);
            }
        }
        $this->save();
    }
}