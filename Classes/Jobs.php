<?php

class Jobs extends Database
{

    /**
     * Get the search query string and parse all the skills out of it.
     * @param string query
     * @return array
     */
    public function parseSkillsQuery(string $query = null)
    {
        if($query === "" || $query === null) return [];
        $search_terms = explode(",",$query);
        return array_filter($search_terms);
    }


    /**
     * Get data from database for a query
     * @param string $query
     * @return array|null
     */
    public function searchData(string $query)
    {
        $prepared = $this->con->prepare($query);
        $prepared->execute();
        $results = $prepared->fetchAll(PDO::FETCH_UNIQUE);
        return $results ? $results : null;
    }
    

    /**
     * A method to search universities from database.
     * @param array $search_term
     * @return array
     */
    public function search(array $search_term)
    {
        if(empty($search_term)) return null;

        // build query for each term
        $query = "SELECT * FROM jobs WHERE required_skills LIKE '%$search_term[0]%' ";
        for ($i = 1; $i < count($search_term); $i++) { 
            $query .= "OR required_skills LIKE '%$search_term[$i]%' ";
        }
        
        // send query to search data method which will find connect to db and return data as array.
        return $this->searchData($query);
    }

}