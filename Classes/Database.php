<?php

class Database
{
    
    /**
     * Database connection
     *  @var PDO
     */
    protected $con = null;


    /**
     * Store configuration the data
     * @var array 
     */
    protected $config = [
        'type' => 'mysql',
        'name' => 'root',
        'password' => '',
        'database' => 'pankaj',
        'host' => 'localhost:3306',
        'attributes' => [
            PDO::ATTR_CASE => PDO::CASE_NATURAL,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ],
        'commands' => [
            'SET SQL_MODE=ANSI_QUOTES'
        ]
    ];


    /**
     * connect with database.
     */
    public function __construct()
    {
        if(!isset($this->db)) {
            try 
            {
                $conn = new PDO(
                    "{$this->config['type']}:host=".$this->config['host'].";dbname=".$this->config['database'], 
                    $this->config['name'], $this->config['password']
                );

                // exectue all the attributes
                foreach($this->config['attributes'] as $key => $val)  $conn->setAttribute($key, $val);

                // execute all the commands
                foreach($this->config['commands'] as $val) $conn->exec($val);

                // set the connection
                $this->con = $conn;
            } 
            catch (Throwable $e) 
            {
                throw new PDOException($e->getMessage());
            }
        }
    }
    

    /**
     * Return all the tables in current connected database.
     * @return bool|array
     */
    public function get_tables()
    {
        $st = $this->con->prepare("SHOW TABLES FROM {$this->config['database']}");
        $st->execute();
        $tables = false;
        
        while( $row = $st->fetch(PDO::FETCH_ASSOC) ) 
        {
            $tables[$row['Tables_in_'.$this->config['database']]] = true;
        }
        
        return $tables;
    }

}