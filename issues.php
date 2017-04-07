<?php 
session_start();
include ('header.php');
?>
  <div><a style="padding: 2px;background-color: red;color: #fff;" href="logout.php">Logout</a> <a style="padding: 2px;background-color: green;color: #fff;" href="log.php">Show user activity</a> <a style="padding: 2px;background-color: blue;color: #fff;" href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a></div>
    <?php

     //Using vendor/knplabs PHP library for returning user repos and issues from Github

      require_once 'vendor/autoload.php';

      $client = new \Github\Client();

      $issues = $client->api('issue')->all($_SESSION['login'], $_GET['repo_name'], array('state' => 'all'));
      
      foreach ($issues as $value) {
        echo '<br><div style="border: 1px solid grey;padding: 10px;background-color: #efdfdf;border-radius: 4px;"><a class="click_issue" href="' .$value['html_url']. '" data-toggle="tooltip" title="link on Github">' .$value['title']. '</a> (status: ' .$value['state']. ') '; 

        //for example getting issues labes

        for($i=0; $i<count($value['labels']); $i++){
        	echo '<span style="padding:2px;color:#fff;background-color:#'.$value['labels'][$i]['color'].'">'.$value['labels'][$i]['name'].'</span> ';
        }
        
        echo '</div>';
      }
    ?>
</body>
</html>