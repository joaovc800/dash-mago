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
                    value
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
}
