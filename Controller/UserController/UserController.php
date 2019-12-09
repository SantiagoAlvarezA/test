<?php
require_once '../../DB/Connection.php';
require_once '../../Utilities/Utilities.php';

class UserController
{
    private $conn = null;
    private $utilities = null;

    public function __construct()
    {
        $this->conn = new Connection();
        $this->utilities = new Utilities();
    }

    public function get()
    {
        $msg = '';
        $data = null;

        $connection = $this->conn->getConnection();
        $sql = "SELECT
                    *
                FROM test
                ";

        $query = $connection->prepare($sql); // Prepara una sentencia para su ejecución y devuelve un objeto sentencia

        try {
            $query->execute(); //Ejecuta una sentencia preparada

            while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
                $rows[] = $result;
            }

            if ($rows) {
                foreach ($rows as $row) {
                    $data[] = $row;
                }
                $msg = 'Los datos se cargaron con éxito';
            } else {
                $msg = 'No hay datos para mostrar';
            }
        } catch (PDOExeption $e) {
            $msg = $e->getMessage();
        }
        $this->utilities::response("200", $msg, $data);
    }

    public function show($id)
    {
        $msg = '';
        $data = null;

        $connection = $this->conn->getConnection();
        $sql = "SELECT
                    *
                FROM test
                WHERE id = :id
                LIMIT 1";

        $query = $connection->prepare($sql); // Prepara una sentencia para su ejecución y devuelve un objeto sentencia
        $query->bindParam(':id', $id, PDO::PARAM_INT); //Vincula un parámetro al nombre de variable especificado

        if ($query) {
            try {
                $query->execute(); //Ejecuta una sentencia preparada
                $data = $query->fetch(PDO::FETCH_ASSOC);
                if ($query->rowCount() > 0) { //Devuelve el número de filas afectadas por la última sentencia SQL
                    $msg = 'El usuario fue encontrado con exito';
                } else {
                    $data = null;
                    $msg = 'El usuario no esta registrado';
                }
            } catch (PDOExeption $e) {
                $msg = $e->getMessage();
            }
        } else {
            $msg = "Ocurrió un problema al intentar ejecutar la petición";
        }

        $this->utilities::response("200", $msg, $data);
    }

    public function post($body)
    {
        $conexion = $this->conn->getConnection();
        $msg = '';
        $data = null;

        $sql = "INSERT
                INTO test(name, last_name)
                VALUES(:name, :last_name)";
        $query = $conexion->prepare($sql); // Prepara una sentencia para su ejecución y devuelve un objeto sentencia
        $query->bindParam(':name', $body->name, PDO::PARAM_STR); //Vincula un parámetro al nombre de variable especificado
        $query->bindParam(':last_name', $body->last_name, PDO::PARAM_STR); //Vincula un parámetro al nombre de variable especificado

        if (!$query) {
            $msg = 'No se pudo realizar el registro';
        } else {
            try {
                $query->execute(); //Ejecuta una sentencia preparada
                if ($query->rowCount() > 0) { //Devuelve el número de filas afectadas por la última sentencia SQL
                    $msg = "Registro realizado con exito";
                } else {
                    $msg = "El registro no se pudo crear";
                }

            } catch (PDOExeption $e) {
                $msg = $e->getMessage();
            }
        }
        $this->utilities::response("200", $msg, $data);
    }

    public function put($id, $body)
    {

        $msg = '';
        $connection = $this->conn->getConnection();

        $sql = 'UPDATE test
                    SET
                        name = :name,
                        last_name = :last_name
                WHERE id = :id';
        $query = $connection->prepare($sql); // Prepara una sentencia para su ejecución y devuelve un objeto sentencia
        $query->bindParam(':id', $id, PDO::PARAM_INT); //Vincula un parámetro al nombre de variable especificado
        $query->bindParam(':name', $body->name, PDO::PARAM_STR); //Vincula un parámetro al nombre de variable especificado
        $query->bindParam(':last_name', $body->last_name, PDO::PARAM_STR); //Vincula un parámetro al nombre de variable especificado
        if (!$query) {
            $msg = "Error al intentar actualizar el registro";
        } else {
            try {
                $query->execute(); //Ejecuta una sentencia preparada
                if ($query->rowCount() > 0) { //Devuelve el número de filas afectadas por la última sentencia SQL
                    $msg = "Registro actualizado con exito";
                } else {
                    $msg = "Imposible actualizar este registro";
                }

            } catch (PDOExeption $e) {
                $msg = $e->getMessage();
            }
        }
        $this->utilities::response("200", $msg, null);
    }

    public function delete($id)
    {
        $msg = '';
        $connection = $this->conn->getConnection();

        $sql = 'DELETE
            FROM test
            WHERE id = :id';

        $query = $connection->prepare($sql); // Prepara una sentencia para su ejecución y devuelve un objeto sentencia
        $query->bindParam(':id', $id, PDO::PARAM_INT); //Vincula un parámetro al nombre de variable especificado
        if (!$query) {
            $msg = "Error al eliminar registro";
        } else {
            try {
                $query->execute(); //Ejecuta una sentencia preparada
                if ($query->rowCount() > 0) { //Devuelve el número de filas afectadas por la última sentencia SQL
                    $msg = "Registro eliminado con éxito";
                } else {
                    $msg = "No fue posible eliminmar este registro";
                }

            } catch (PDOExeption $e) {
                $msg = $e->getMessage();
            }
        }
        $this->utilities::response("200", $msg, null);
    }

}
