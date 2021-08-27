<?php

require $_SERVER['DOCUMENT_ROOT'] . "/news_task/db/Connection.php";

class Queries extends Connection
{
    private function bindParamsBySettings($generatedQuery, $bindParamArr = [])
    {
        if (count($bindParamArr) > 0) {
            $generatedQuery->execute($bindParamArr);
        } else {
            $generatedQuery->execute();
        }
    }
    public function checkIfUserExists($query, $bindParamArr = [])
    {
        $con = $this->connect();
        $generatedQuery = $con->prepare($query);
        $this->bindParamsBySettings($generatedQuery, $bindParamArr);
        // $generatedQuery->execute();

        return $generatedQuery->rowCount();
    }

    public function loadData($query, $bindParamArr = [])
    {
        $con = $this->connect();
        $generatedQuery = $con->prepare($query);
        $this->bindParamsBySettings($generatedQuery, $bindParamArr);
        // $generatedQuery->execute();
        return $generatedQuery->fetchAll();
    }

    public function executionQuery($query, $bindParamArr = [])
    {
        $con = $this->connect();
        $generatedQuery = $con->prepare($query);
        $this->bindParamsBySettings($generatedQuery, $bindParamArr);
    }
}
