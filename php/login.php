<?php
$servername = "sql12.freesqldatabase.com:3306"; // Your Server Name (Generally 'localhost')
$username = "sql12578643"; // Your Database Username
$password = "iPMtimK6QC"; // Your Database Password
$database = "sql12578643"; // Your Database Name

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$email = $_POST["email"];
$password = md5($_POST["password"]);

$stmt = $conn->prepare("SELECT * FROM tb_data WHERE email = ? && password= ?");
$stmt->bind_param("ss", $email, $password);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $num_rows = $result->num_rows;
}

if ($num_rows > 0) {
    //Connecting to Redis
    // require "predis/autoload.php";

    require_once dirname(__DIR__, 1) . "./vendor/predis/predis/autoload.php";
    Predis\Autoloader::register();
    $redis = new Predis\Client([
        "scheme" => "tcp",
        "host" => "redis-11083.c305.ap-south-1-1.ec2.cloud.redislabs.com",
        "port" => 11083,
        "password" => "gyOkIyrxtraXfB3F5tvU7G3ODZuYRzMv",
    ]);

    if (!$redis->ping()) {
        echo "Connection failed";
    }
    $session_id = generateRandomString();
    $redis->set($session_id, $email);

    echo $session_id;
    // $redis->close();
} else {
    echo 5;
}

$conn->close();

function generateRandomString($length = 10)
{
    return substr(
        str_shuffle(
            str_repeat(
                $x =
                    "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ",
                ceil($length / strlen($x))
            )
        ),
        1,
        $length
    );
}
