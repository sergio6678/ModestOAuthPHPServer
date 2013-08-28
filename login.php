<?php
require_once '../include/common.php';
?>
<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="utf-8">
  <title>Login</title>
 </head>
 <body>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $stmt = $db->prepare('SELECT id FROM users WHERE email = :email');
    $stmt->execute(array(
        'email' => $_POST['requester_email']
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo '<p><strong>Incorrect login</strong></p>';
        die;
    }
    $id = $row['id'];
    $stmt->closeCursor();

   
    $rs = $server->authorizeVerify();
    
   
    $authorized = array_key_exists('allow', $_POST);
    
  
    $server->authorizeFinish($authorized, $id);
}
else {
?>
  <form method="post"
   action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
   <fieldset>
    <legend>Login</legend>
    <div>
     <label for="requester_email">Email</label>
     <input type="text" id="requester_email" name="requester_email">
    </div>
   </fieldset>
   <input type="submit" value="Login">
  </form>
<?php
}
?>
 </body>
</html>