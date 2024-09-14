<?php
require_once realpath(dirname(__DIR__, 1) . '/core/DB.php');

/**
 * Class Operation
 * 
 * Representa a operação do usuário
 */
class Operation
{
    /**
     * @var int id do usuário que irá fazer a operação
     */
    private int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }


    /**
     * Método para pegar todas as operações do usuário
     *
     * @return array
     * 
     */
    public function getAllOperations(): array
    {

        $result = DB::statement(
            "SELECT 
                    DATE_FORMAT(date, '%d/%m/%Y') as date,
                    value,
                    id
                FROM operations 
                WHERE iduser = :iduser
                ORDER BY date, value
                ", [
            ":iduser" => $this->userId
        ]);

        if (count($result["fetch"]) > 0) {
            return $result["fetch"];
        }

        return ["erro" => true, "message" => "Operations not found"];
    }

    /**
     * Método para inserir uma operações do usuário
     *
     * @param array $collection
     * 
     * @return array
     * 
     */
    public function createOperation(array $collection): array
    {
        $insert = DB::insert('operations', $collection);

        return $insert;
    }

    public function deleteOperation(int $id): array
    {
        $delete = DB::statement("DELETE FROM operations WHERE id = $id");
        return $delete;
    }

    public function getTotalOperations(): array
    {
        $operationstotal = DB::statement("SELECT YEAR(date) AS year,
                                                        COUNT(DISTINCT date) AS daysOperated,
                                                        SUM(value) AS profit
                                                   FROM operations
                                                  WHERE iduser = {$this->userId}
                                               GROUP BY YEAR(date)
                                               ORDER BY YEAR(date) desc");
        return $operationstotal;
    }
    public function getTotalOperationsByMonths(): array
    {
        $operationstotalByMonths = DB::statement("SELECT YEAR(date) AS year,
                                                                MONTH(date) AS month,
                                                                COUNT(DISTINCT date) AS total_days_operated,
                                                                SUM(value) AS total_profit
                                                          FROM operations
                                                         WHERE iduser = {$this->userId}
                                                      GROUP BY YEAR(date), MONTH(date)
                                                      ORDER BY YEAR(date), MONTH(date)");
        return $operationstotalByMonths;
    }
}
