<?php
require_once realpath(dirname(__DIR__, 1) . '/core/DB.php');

/**
 * Class User
 * 
 * Representa um usuário com email e senha.
 */
class User
{
    /**
     * @var string O endereço de e-mail do usuário.
     */
    private string $email;
    /**
     * @var string A senha do usuário, armazenada como um hash MD5.
     */
    private string $password;

    /**
     * Construtor da classe User.
     *
     * @param array $credentials Um array associativo contendo 'email' e 'password'.
     *                           'email' deve ser uma string representando o endereço de e-mail.
     *                           'password' deve ser uma string representando a senha do usuário.
     */
    public function __construct(array $credentials)
    {
        $this->email = $credentials['email'];

        if(isset($credentials['passwordhash'])){
            $this->password = $credentials['passwordhash'];
        }

        if(isset($credentials['password'])){
            $this->password = md5($credentials['password']);
        }
        
    }


    /**
     * Método para verificar se o login e senha está válido
     *
     * @return array
     * 
     */
    public function getUser(): array
    {

        $result = DB::statement("SELECT * FROM magoautomation WHERE email_login = :username AND senha_login = :password", [
            ":username" => $this->email,
            ":password" => $this->password,
        ]);

        if (count($result["fetch"]) > 0) {

            return [
                "username" => $result["fetch"][0]["email_login"],
                "password" => $result["fetch"][0]["senha_login"],
                "id" => $result["fetch"][0]["id"],
                "maturity" => $result["fetch"][0]["vencimento"],
                "signature" => $result["fetch"][0]["assinatura"],
            ];
        }

        return ["erro" => true, "message" => "User not found"];
    }

    public function getDetails(): array
    {

        $result = DB::statement("SELECT * FROM magoautomation WHERE email_login = :username AND senha_login = :password", [
            ":username" => $this->email,
            ":password" => $this->password,
        ]);

        if (count($result["fetch"]) > 0) {

            return [
                "initialBankroll" => (int) $result["fetch"][0]["banca_inicial"],
                "currentBankroll" => (int) $result["fetch"][0]["banca_atual"],
                "stopwin" => (int) $result["fetch"][0]["stopwin"],
                "stoploss" => (int) $result["fetch"][0]["stoplos"],
                "chip" => $result["fetch"][0]["ficha"],
                "gale" => $result["fetch"][0]["gale"],
                "status" => $result["fetch"][0]["status"],
                "operations" => $result["fetch"][0]["noperacoes"],
                "signature" => $result["fetch"][0]["assinatura"],
                "maturity" => $result["fetch"][0]["vencimento"],
            ];
        }

        return ["erro" => true, "message" => "User not found"];
    }


    /**
     * Método para alterar a senha
     *
     * @param string $newpassword
     * @param int $userId
     * 
     * @return array
     * 
     */
    public function updatePassword(string $newpassword, int $userId): array
    {
        $result = DB::update(
            "magoautomation",
            [
                "senha_login" => md5($newpassword)
            ],
            [
                ['id', $userId, '=']
            ]
        );
        return $result;
    }

    public function updateInformations(array $collection, int $userId): array
    {
        $result = DB::update(
            "magoautomation",
            $collection,
            [
                ['id', $userId, '=']
            ]
        );
        return $result;
    }
}
