<?php
class Connect
{
    private static ?PDO $pdoObject = null;
    private static string $dsn = "mysql:host=%s;dbname=%s;port=%s;charset=%s";

    /**
     * @return PDO
     */
    public static function getPDO(): PDO
    {
        $CHARSET = 'utf8';
        $DB_NAME = 'ofb84_budget_app';
        $SERVEUR = 'localhost';
        $USERNAME = 'root';
        $DB_PORT = 3307;
        $PASSWORD = '';
        if (self::$pdoObject === null) {
            try {
                $dsn = sprintf(self::$dsn, $SERVEUR, $DB_NAME, $DB_PORT,$CHARSET);
                self::$pdoObject = new PDO($dsn, $USERNAME, $PASSWORD);
                self::$pdoObject->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                self::$pdoObject->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }
            catch (Exception $e) {
                echo "Une erreur est intervenue ";
                file_put_contents('PDOerrorlog.txt', $e->getMessage() .
                    " " . date('d/m/Y H:i:s') . "\n", FILE_APPEND);;
            }
        }
        return self::$pdoObject;
    }
}
?>