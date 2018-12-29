<?php

$conn = new mysqli('localhost','root','','userlogin');

if($conn->connect_error){

    echo "connection Failed";

} else {
    //echo "connection";
}

if(isset($_REQUEST['submit'])) {

    $jsonData = json_encode(array (
            
        'name'=>array($_REQUEST['name'],$_REQUEST['name1'],$_REQUEST['name2'],$_REQUEST['name3']),

            'username'=>$_REQUEST['username'],
            
            'password'=>$_REQUEST['password']
            // 'email'=>$_REQUEST['email']
        ));
    
    //$query = "INSERT INTO 'json' ('id','jsonData') values (null,'$jsonData')";
    $test = "INSERT INTO validJson(json) VALUES ('$jsonData');";

    $result = $conn->query($test);

}

if(isset($_REQUEST['search'])) {
    
    $search = $_REQUEST['search'];

    $query = "SELECT  JSON_SEARCH(json,'all','$search') FROM validjson ";

    $result = $conn->query($query);
   
    if ($result->num_rows>0) {

        while($row = $result->fetch_assoc()) {

            foreach($row as $value) {
                //echo $value;

                if($value!="") {
                    
                     $searchQuery = "SELECT JSON_VALUE(json,$value) FROM validjson where JSON_VALUE(json,$value) = '$search'";//SELECT * FROM validjson JSON_VALUE(json,$value) = '$search'
                    
                     $data = $conn->query($searchQuery);
                    
                     if($data->num_rows>0){
                         
                        
                        while($row1 = $data->fetch_assoc()) {

                            foreach($row1 as $item) {

                                echo $item.'<br>';
                            }
                        }
                    }
                }
            }
        }
    }   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JSON Data Type</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>JSON Data</h1>

    <form action="" method="post" class="form-group col-2">
    <label for="name">First</label>
    <input type='text' name='name' required class="form-control">
    <br>
    <label for="name1">Second</label>
    <input type='text' name='name1' required class="form-control">
    <br>
    <label for="name2">Third</label>
    <input type='text' name='name2' required class="form-control">
    <br>
    <label for="name3">Forth</label>
    <input type='text' name='name3' required class="form-control">
    <br>
    <label for="username">Fifth</label>
    <input type="text" name='username' required class="form-control">
    <br>
    <label for="password">Sixth</label>
    <input type="text" name='password' required class="form-control">
    <!-- <label for="email">Email</label>
    <input type="text" name='email'> -->
    <br>
    <input type="submit" name='submit'>

    </form>
    <div id='id1'>

    <form action="" method='post'>

    Search : <input type="text" name='search'>

    <input type="submit" name=''>   

    </form>
    </div>
</div>
</body>
</html>