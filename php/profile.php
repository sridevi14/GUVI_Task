<?php

if (isset($_POST["name"])) {
    require_once dirname(__DIR__, 1) . "./vendor/autoload.php";
    // connect to mongodb
    $conn_mongoDB = new MongoDB\Client(
        "mongodb+srv://sridevi:manju@guvi.yncne6h.mongodb.net/?retryWrites=true&w=majority"
    );
    //create database and table
    $db = $conn_mongoDB->guvi;
    $table = $db->guvi_users;
    $val = $_GET["session_Id"];
    //echo $val;
    // require "predis/autoload.php";
    require_once dirname(__DIR__, 1) . "/vendor/predis/predis/autoload.php";
    Predis\Autoloader::register();
    $redis = new Predis\Client([
        "scheme" => "tcp",
        "host" => "redis-11083.c305.ap-south-1-1.ec2.cloud.redislabs.com",
        "port" => 11083,
        "password" => "gyOkIyrxtraXfB3F5tvU7G3ODZuYRzMv",
    ]);

    if (!$redis->ping()) {
        echo "not connected";
    }

    $email = $redis->get($val);
    //echo $sree;

    $table->updateOne(
        ["email" => $email],
        [
            '$set' => [
                "name" => $_POST["name"],
                "address" => $_POST["address"],
                "dob" => $_POST["dob"],
            ],
        ]
    );
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    require_once dirname(__DIR__, 1) . "/vendor/predis/predis/autoload.php";
    Predis\Autoloader::register();
    $redis = new Predis\Client([
        "scheme" => "tcp",
        "host" => "redis-11083.c305.ap-south-1-1.ec2.cloud.redislabs.com",
        "port" => 11083,
        "password" => "gyOkIyrxtraXfB3F5tvU7G3ODZuYRzMv",
    ]);

    if (!$redis->ping()) {
        echo "not connected";
    }
    $val = $_GET["session_Id"];
    echo $val;
    $redis->delete($val);
    echo "i am deleted";
} elseif ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST["name"])) {
    require_once dirname(__DIR__, 1) . "/vendor/predis/predis/autoload.php";
    Predis\Autoloader::register();
    $redis = new Predis\Client([
        "scheme" => "tcp",
        "host" => "redis-11083.c305.ap-south-1-1.ec2.cloud.redislabs.com",
        "port" => 11083,
        "password" => "gyOkIyrxtraXfB3F5tvU7G3ODZuYRzMv",
    ]);

    if (!$redis->ping()) {
        echo "not connected";
    }
    $ses_id = $_POST["myData"];
    $sree = $redis->get($ses_id);

    require_once dirname(__DIR__, 1) . "./vendor/autoload.php";
    // connect to mongodb
    $conn_mongoDB = new MongoDB\Client(
        "mongodb+srv://sridevi:manju@guvi.yncne6h.mongodb.net/?retryWrites=true&w=majority"
    );
    //create database and table
    $db = $conn_mongoDB->guvi;
    $table = $db->guvi_users;
    $cursor = $table->find();
    foreach ($cursor as $doc) {
        if ($doc["email"] == $sree) {
            echo json_encode($doc);
            //echo "hai";
        }
    }
}

?>
