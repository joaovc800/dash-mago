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
        $this->password = md5($credentials['password']);
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

            [ $response ] = $result["fetch"];

            return [
                "username" => $response["email_login"],
                "password" => $response["senha_login"],
                "id" => $response["id"],
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

            [ $response ] = $result["fetch"];

            return [
                "initialBankroll" => $response["banca_inicial"],
                "currentBankroll" => $response["banca_atual"],
                "stopwin" => $response["stopwin"],
                "stoploss" => $response["stoplos"],
                "chip" => $response["ficha"],
                "gale" => $response["gale"],
                "on" => $response["ligado"],
                "operations" => $response["noperacoes"],
                "active" => $response["ativo"],
                "signature" => $response["assinatura"],
                "maturity" => $response["vencimento"],
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
}
