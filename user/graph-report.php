<?php
include("../config/connect.php");
include("../config/functions.php");

if(isset($_COOKIE['WebOfChaosUser']) || isset($_SESSION['user_login_value'])){

    //* If the user session is not set but cookie is set
    if(!isset($_SESSION['user_login_value']) && isset($_COOKIE['WebOfChaosUser'])){

        //* Set session value
        $_SESSION['user_login_value'] = $_COOKIE['WebOfChaosUser'];
    }
    else{
        // header("location:$location_index/");
    }
}
else{
    header("location:$location_index/");
}


use Dompdf\Dompdf;
use Dompdf\Options;

    if(isset($_GET['id_graph'])){

        //* Get User info
        $user_value_hash = $_SESSION['user_login_value'];
        $user_value_txt = openssl_decrypt($user_value_hash, 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');
        parse_str($user_value_txt, $user_value);
        
        $id_graph = validateInput($_GET['id_graph']);
        $graph_sql = $connect->prepare("SELECT * FROM graphs WHERE id_graph = ?");
        $graph_sql->execute([$id_graph]);
        $graph = $graph_sql->fetch(PDO::FETCH_ASSOC);

        //* Make sure graph is user's
        if($graph['id_user'] == $user_value['id_user']){

            require __DIR__ . "../../vendor/autoload.php";
            
            $options = new Options();
            $options->setChroot(__DIR__);
            
            $dompdf = new Dompdf($options);
            $dompdf->setPaper("A4", "Portrate");
            
            $html = file_get_contents("report.html");

            $date = date_create($graph['created_date_graph']);
            $date = date_format($date,"d / m / Y");
            $html = str_replace("{{ created_date_graph }}", $date, $html);
            $html = str_replace("{{ name_graph }}", strtoupper($graph['name_graph']), $html);

            $dompdf->loadHtml($html);
            $dompdf->render();
            $dompdf->stream("graph-report.pdf", ["Attachment" => 0]);
            echo "thig";
            

        }
    }
    else{
        alert_message("error", "Data not complete");
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

?>