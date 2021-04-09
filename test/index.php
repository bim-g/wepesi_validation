<?php
    use Wepesi\app\Validate;

    $valid = new Validate();
    $source = [
        "name" => "Wepesi",
        "age" => 13,
        "country" => "DRC",
        "state" => "North Kivu",
        "password"=>"123456",
        "n_password"=>123456,
        "coty" => "Goma",
        "email"=>"infos@wepesi.com",
        "link"=> "https://github.com/bim-g/wepesi_validation/",
        "status"=> true,
        "address" => "this is The text% to Be camelcaSEd"
    ];
    // include "./test/required.php";
    // include "./test/minmax.php";
    // include "./test/number.php";
    // include "./test/link_email.php";
    // include "./test/match.php";
    // include "./test/boolean.php";
    include "./test/camelcase.php";