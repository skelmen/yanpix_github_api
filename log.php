<?php 
include ('header.php');
require ('db.php');
?>
<div><a style="padding: 2px;background-color: blue;color: #fff;" href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a></div>
<div class="row">
<div class="col-sm-5">
 <table class="table table-striped">
  <thead>
    <tr>
      <th>Date</th>
      <th>User</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
<?php

//Select data from our database

  $conn_select = ConnectDb::getInstance()->getConnection();

  $stmt = $conn_select->prepare('SELECT * FROM activity');
  $stmt->execute();
    
  while($row = $stmt->fetch()) {
  echo 
   '<tr>
     <td>'.$row['date_act'].'</td>
     <td>'.$row['user'].'</td>
     <td>'.$row['action'].'</td>
   </tr>';
  }

?>
  </tbody>
 </table>
</div>
</div>
</body>
</html>