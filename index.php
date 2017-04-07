<?php 
session_start();
include ('header.php');

if (isset($_SESSION['login'])) {
?>
 <div class="row">
  <div class="col-sm-3">
      <div><a style="padding: 2px;background-color: red;color: #fff;" href="logout.php">Logout</a> <a style="padding: 2px;background-color: green;color: #fff;" href="log.php">Show user activity</a></div>
          <?php

          //Using vendor/knplabs PHP library for returning user repos and issues from Github
          require_once 'vendor/autoload.php';

          $client = new \Github\Client();

          $repos = $client->api('user')->repositories($_SESSION['login']);
  
          foreach ($repos as $value) {
            $issues = $client->api('issue')->all($_SESSION['login'], $value['name'], array('state' => 'all'));
           
           //2 counts for tooltips - opened and closed issues 
            $count_open = 0;
            $count_close = 0;

            foreach ($issues as $key) {
              if ($key['state'] == 'open') {
                $count_open++;
              } elseif ($key['state'] == 'closed') {
                $count_close++;
              }
            }
            echo '<br><div class="repos"><a class="click_repo" href="' .$value['html_url']. '" data-toggle="tooltip" title="link on Github">' .$value['name']. '</a><a class="open_issues pull-right" href="issues.php?repo_name='.$value['name'].'" data-toggle="tooltip" title="Opened issues: '.$count_open.' Closed issues: '.$count_close.'">Issues(' .count($issues). ')</a></div>';
          }
          ?>
  </div>
 </div>
 <?php } else { ?>
 <div class="row">
  <div class="col-sm-3">
  <form role="form" id="form" method="post">
   <div class="form-group">
   <input type="text" class="form-control" name="login" id="login" placeholder="login">
   </div>
   <div class="form-group">
   <input type="password" class="form-control" name="pass" id="pass" placeholder="password">
   </div>
   <button type="submit" id="submit" class="btn btn-success">Submit</button>
  </form>
  </div>
 </div>
        <div class="overlay"></div>
        <div class="loader" id="loader"><img src="loader.gif" width="100" height="100" /><br>Loading...
        </div>
<?php } ?>
</body>
</html>
