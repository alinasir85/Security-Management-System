<?php
require 'conn.php';session_start();


 if($_SESSION["user"]==NULL)
 {
      header('location:LOGIN.php');
 }
 else
 {
     
 $user=$_SESSION["user"];

$sql="select * from users where login='$user' AND isadmin=1";
$result= mysqli_query($con, $sql);
$rows= mysqli_num_rows($result);

if(!($rows>0))
{
  header('location:LOGIN.php');
}

}  
?>
<?php


if(isset($_REQUEST['createNew']))
{
    $_SESSION['edituserid']=NULL;
    header('location:userrole.php');
}

if(isset($_REQUEST['delete']))
{
    $uid=$_REQUEST['delete'];
    $sql="delete from user_role where id='$uid'";
    $result= mysqli_query($con, $sql);
    if($result)
    {
        header('location:userRoleList.php');
    }
}

if(isset($_REQUEST['edit']))
{
    $uid=$_REQUEST['edit'];
    $_SESSION['edituserid']=$uid;  
    header('location:userrole.php');
}

?>

<html>
    <head>
            <style>
            
             
                
           .container .btn-group .header
            {
               background-color: #555;
               color: white;
               float: left;
               border: none;
               outline: none;
               cursor: pointer;
               padding: 8px;
               font-size: 11px;
               width: 12.5%;
               margin: 0px;
               
            }
          .container .btn-group .header:hover
           {
               background-color: black;
               
           }
           
        
       
        </style>
    </head>
    <body style="background-color:whitesmoke">
        <div class="container">
        <div class="btn-group">
        <button class="header" onclick="window.location='Home.php'">Home</button>
        <button class="header" onclick="window.location='userList.php'">User Management</button>
        <button class="header" onclick="window.location='roleList.php'">Role Management</button>
        <button class="header" onclick="window.location='permissionList.php'">Permission Management</button>
        <button class="header" onclick="window.location='rolePermissionList.php'">Role-Permissions Management</button>
        <button class="header" onclick="window.location='UserRoleList.php'">User-Role Management</button>
        <button class="header" onclick="window.location='loginHistory.php'">Login History</button>
        <button class="header" onclick="window.location='logout.php'">Logout</button>
        </div>
        <br><br><br>
        <form action="">
        <table border="1" cellpadding="10">
            <thead>
                <tr><th>Role</th><th>User</th><th>Edit</th><th>Delete</th></tr>
            </thead>
          
            <tbody>
                <?php
                $sql="select * from user_role";
                $result= mysqli_query($con, $sql);
                $rows= mysqli_num_rows($result);
                if($rows>0)
                {
                    while($record= mysqli_fetch_assoc($result))
                    {
                        $roleid=$record['roleid'];
                        $userid=$record['userid'];
                        
                        $query1="select * from roles where roleid='$roleid'";
                        $query2="select * from users where userid='$userid'";
                        $r1= mysqli_query($con, $query1);
                        $r2= mysqli_query($con, $query2);
                        $role= mysqli_fetch_assoc($r1);
                        $user= mysqli_fetch_assoc($r2);
                        
                        echo "<tr><td>".$role['name']."</td><td>".$user['login']."</td><td><button type='submit' name='edit' value='".$record['id']."'>Edit</button></td> <td><button type='submit' name='delete' value='".$record['id']."'>DELETE</button></td></tr>";
                    }
                }
                ?>
                
            </tbody>
        </table>
        <br>
        
       
        <button type="submit" value="Create New User Role" name="createNew">Create New User Role</button>
        </form>
        </div>
    </body>
        
</html>