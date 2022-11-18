  <?php
  $servername = "sql12.freesqldatabase.com:3306"; // Your Server Name (Generally 'localhost')
  $username = "sql12578643"; // Your Database Username
  $password = "iPMtimK6QC"; // Your Database Password
  $database = "sql12578643"; // Your Database Name

  $conn = new mysqli($servername, $username, $password, $database);

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $var = false;

  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = md5($_POST["password"]);

  $stmt = $conn->prepare("SELECT * FROM tb_data WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();
  // Checking the account
  if ($stmt->num_rows > 0) {
      echo 1;
  } else {
      //To insert data to mysql
      $var = true;
      $stmt_1 = $conn->prepare(
          "INSERT INTO tb_data (email, password) VALUES (?, ?)"
      );
      $stmt_1->bind_param("ss", $email, $password);
      $stmt_1->execute();
      echo 2;
      $stmt_1->close();
  }
  $conn->close();

  // require_once __DIR__ .'./vendor/autoload.php';
  // // connect to mongodb
  require_once dirname(__DIR__, 1) . "./vendor/autoload.php";
  $conn_mongoDB = new MongoDB\Client(
      "mongodb+srv://sridevi:manju@guvi.yncne6h.mongodb.net/?retryWrites=true&w=majority"
  );
  //create database and table
  $db = $conn_mongoDB->guvi;
  $table = $db->guvi_users;

  $document = [
      "name" => $_POST["name"],
      "email" => $_POST["email"],
      "dob" => $_POST["dob"],
      "address" => $_POST["address"],
  ];
  if ($var == true) {
      $table->insertOne($document);
  }


?>
