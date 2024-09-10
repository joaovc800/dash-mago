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

            return [
                "username" => $result["fetch"][0]["email_login"],
                "id" => $result["fetch"][0]["id"],
            ];
        }

        return ["erro" => true, "message" => "User not found"];
    }
}
