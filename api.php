<?php
header('Content-Type:application/json');
$server = "localhost";
$username = "root";
$dbname = "covid19";
$pass = "";


$conn = new mysqli($server, $username , $pass , $dbname);

if($conn->connect_error){
    die("Connection failed :" . $conn->connect_error);
}
$method = $_SERVER['REQUEST_METHOD'];
$json = [];
$i = 1;
if ($method == 'GET'){
    $nama = $_GET['nama'];
    $sql = "SELECT * FROM ODP WHERE nama = '$nama' ";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()){
            $json[$i] = [
                'id_user' => $row['id'],
                'nama' => $row['nama'],
                'umur' => $row['umur'],
                'alamat' => $row['alamat']
            ];
            $i = $i + 1;
        }}
        else{
            echo "0 results";
        }
        
    }
    
    else if ($method == 'POST'){
        $nama = $_POST['nama'];
        $umur = $_POST['umur'];
        $alamat = $_POST['alamat'];
        
        $sql = "INSERT INTO ODP (nama , umur , alamat) VALUES ('$nama' , '$umur', '$alamat')";
        $conn->query($sql);
    }
    else if ($method == 'PUT'){
        parse_str(file_get_contents('php://input'),$_PUT);
        $id = $_PUT['id'];
        $nama = $_PUT['nama'];
        $umur = $_PUT['umur'];
        $alamat = $_PUT['alamat'];
        
        $sql = "UPDATE ODP SET nama = '$nama' ,
                               umur ='$umur',
                               alamat ='$alamat')
                WHERE id = '$id'" ;
        $conn->query($sql);
    }
    else if ($method == 'DELETE'){
        parse_str(file_get_contents('php://input'),$_DELETE);
        $id = $_DELETE['id'];
        
        $sql = "DELETE ODP FROM ODP WHERE id = '$id'";
        $conn->query($sql);
    }
    $data = ['data' => $json];
    echo json_encode($data);
    
?>