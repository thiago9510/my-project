## my-projetc

##### Descrição:
<p>
    O my Project, é um porejto focado em implementar um API para gestão de pessoas real para aprendizado.
    Ele será um monolito com o mínimo de php possível e deve contar tanto as APIS's para manupulação dos recursos de forma externa como a implementação do front-end em si.
</p>

---

##### Banco de Dados MySQL com Docker + PHP PDO:

<p>
    Este projeto utiliza MySQL rodando em um container Docker e conexão via PDO no PHP. Abaixo estão os passos para configurar e testar o ambiente local.
</p>

##### Subindo o Mysql com Docker:

<p>Execute o seguinte comando para criar e iniciar o container:<br/><br/>
<b>mysql-dev:</b> nome do container<br/>
<b>123:</b> senha do usuário root<br/>
<b>my_project:</b> nome do banco de dados<br/>
<b>3306:</b> porta padrão do MySQL<br/>
</p>

```bash 
    docker run --name mysql-dev \
  -e MYSQL_ROOT_PASSWORD=123 \
  -e MYSQL_DATABASE=my_project \
  -p 3306:3306 \
  -d mysql:8.0
```

##### Instalando extensão PDO MySQL no PHP:

<p>Se estiver usando Linux/WSL, instale com:</p>

```bash 
    sudo apt update
    sudo apt install php-mysql 
```

<p>Verifique se foi instalado corretamente:</p>

```bash php -m | grep pdo ```

##### Configurando a conexão PDO:

<p>Crie o arquivo <code>src/core/Database.php</code> com o seguinte conteúdo:</p>

```php
    <?php
    namespace MyProject\core;
    use PDO;
    use PDOException;

    class Database {
        public static function connect(): PDO {
            try {
                $dsn = "mysql:host=127.0.0.1;dbname=my_project;charset=utf8mb4";
                return new PDO($dsn, "root", "123", [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(["error" => "Erro ao conectar ao banco: " . $e->getMessage()]);
                exit;
            }
        }
    }
```

##### Testando a conexão:

<p>Crie o arquivo <code>public/test-db.php</code> </p>

```php
    <?php
    require __DIR__ . '/../vendor/autoload.php';

    use MyProject\core\Database;

    try {
        $pdo = Database::connect();

        // Teste: inserir uma pessoa
        $stmt = $pdo->prepare("INSERT INTO persons (name, email) VALUES (:name, :email)");
        $stmt->execute([
            'name' => 'Thiago Dev',
            'email' => 'thiago@example.com'
        ]);

        // Teste: buscar todas as pessoas
        $result = $pdo->query("SELECT * FROM persons WHERE deleted_at IS NULL")->fetchAll();

        echo "<pre>";
        print_r($result);
        echo "</pre>";
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
```

<p>Execute o servidor PHP:</p>

```bash
    php -S localhost:8000 -t public
```


##### Estrutura da tabela

```sql
    CREATE TABLE persons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL
    );
```

<p>Ao conectar no banco de dados pelo windows é necessário conectar pelo IP do WSL e criar um usuário com acesso %</p>

---

<p>Atualizar o Autoload</p>

```bash
composer dump-autoload -o
```