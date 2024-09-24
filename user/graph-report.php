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
            
            define("DOMPDF_ENABLE_REMOTE", false);
            $options = new Options();
            $options->setChroot(__DIR__);
            $dompdf = new Dompdf($options);
            $dompdf->setPaper("A4", "Portrate");
            
            $html = file_get_contents("report.html");

            $date = date_create($graph['created_date_graph']);
            $date = date_format($date,"d / m / Y");
            $html = str_replace("{{ created_date_graph }}", $date, $html);
            $html = str_replace("{{ location }}", $_SERVER["DOCUMENT_ROOT"], $html);
            $html = str_replace("{{ name_graph }}", strtoupper($graph['name_graph']), $html);

            //* Report content
            $graph_report_sql = $connect->prepare("SELECT * FROM reports WHERE id_graph = ?");
            $graph_report_sql->execute([$id_graph]);
            $graph_report = $graph_report_sql->fetch(PDO::FETCH_ASSOC);
            $text_ai_data = json_decode($graph_report['text_ai_report'], true);
            $content = $text_ai_data['choices'][0]['message']['content'];

            $html = str_replace("{{ text_ai_report }}",format_text($content), $html);

            $dompdf->loadHtml($html);
            $dompdf->render();

            $name_graph = $graph['name_graph'];
            $dompdf->stream("$name_graph Report Summary.pdf", ["Attachment" => 0]);

        }
    }
    else{
        alert_message("error", "Data not complete");
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

?>