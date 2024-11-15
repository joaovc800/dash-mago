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
                "active" => $result["fetch"][0]["ativo"]
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

            $values = $result["fetch"][0];

            $stopWinRealValue = (int) $values["banca_inicial"] + $values["stopwin"];
            $stopLossRealValue = (int) $values["banca_inicial"] - $values["stopwin"];

            return [
                "initialBankroll" => (int) $values["banca_inicial"],
                "currentBankroll" => (int) $values["banca_atual"],
                "stopwin" => (int) $values["stopwin"],
                "stoploss" => (int) $values["stoplos"],
                "stopwinReal" => $stopWinRealValue,
                "stoplossReal" => $stopLossRealValue,
                "chip" => $values["ficha"],
                "gale" => $values["gale"],
                "status" => $values["status"],
                "operations" => $values["noperacoes"],
                "signature" => $values["assinatura"],
                "maturity" => $values["vencimento"],
                "active" => $values["ativo"]
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
