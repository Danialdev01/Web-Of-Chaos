<?php

include '../config/connect.php';

if(isset($_GET['id_graph'])){

    //* Get user info
    $_SESSION['user_login_value'] = $_COOKIE['ChaosRandSeer'];
    $user_value_hash = $_SESSION['user_login_value'];
    $user_value_txt = openssl_decrypt($user_value_hash, 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');
    parse_str($user_value_txt, $user_value);

    //* Find graph in database
    $id_graph = htmlspecialchars($_GET['id_graph']);
    $graph_sql = $connect->prepare("SELECT * FROM graph WHERE id_graph = ? AND id_user = ?");
    $graph_sql->execute([
        $id_graph,
        $user_value['id_user']
    ]);

    //* If graph not found
    if(!$graph = $graph_sql->fetch(PDO::FETCH_ASSOC)){
        $_SESSION['alert-message'] = "Graph not found";
        $_SESSION['alert-error'] = TRUE;
        echo "<script>window.location = './'</script>";
    }
}
else{
    //* Id not set
    $_SESSION['alert-message'] = "Id graph not set";
    $_SESSION['alert-error'] = TRUE;
    echo "<script>window.location = './'</script>";
}

use Dompdf\Dompdf;
use Dompdf\Options;

    if($_GET['id_graph'] != ""){

        require __DIR__ . "../../vendor/autoload.php";
    
        $options = new Options();
        $options->setChroot(__DIR__);
    
        $dompdf = new Dompdf($options);
        $dompdf->setPaper("A4", "Portrate");
    
        $html = file_get_contents("pdf-graph.html");

        $dompdf->loadHtml($html);
        $dompdf->render();
    
        // $dompdf->addInfo("Borang Penyelengaraan", "Penyelengaraan Elektronik");
        $dompdf->stream("borang.pdf", ["Attachment" => 0]);
    }
    else{
        header("location:./");
    }


?>