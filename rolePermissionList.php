<?php
require 'conn.php';session_start();


 if(!(isset($_SESSION["user"])))
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
    header('location:rolepermission.php');
}

if(isset($_REQUEST['delete']))
{
    $uid=$_REQUEST['delete'];
    $sql="delete from role_permission where id='$uid'";
    $result= mysqli_query($con, $sql);
    if($result)
    {
        header('location:rolePermissionList.php');
    }
}

if(isset($_REQUEST['edit']))
{
    $uid=$_REQUEST['edit'];
    $_SESSION['edituserid']=$uid;  
    header('location:rolePermission.php');
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
        <button class="header" onclick="window.location='LOGIN.php'">Logout</button>
        </div>
        <br><br><br>
        <form action="">
        <table border="1" cellpadding="10">
            <thead>
                <tr><th>Role</th><th>Description</th><th>Permission</th><th>Description</th><th>Edit</th><th>Delete</th></tr>
            </thead>
          
            <tbody>
                <?php
                $sql="select * from role_permission";
                $result= mysqli_query($con, $sql);
                $rows= mysqli_num_rows($result);
                if($rows>0)
                {
                    while($record= mysqli_fetch_assoc($result))
                    {
                        $roleid=$record['roleid'];
                        $permissionid=$record['permissionid'];
                        $query1="select * from roles where roleid='$roleid'";
                        $query2="select * from permissions where permissionid='$permissionid'";
                        $r1= mysqli_query($con, $query1);
                        $r2= mysqli_query($con, $query2);
                        $role= mysqli_fetch_assoc($r1);
                        $permission= mysqli_fetch_assoc($r2);
                        
                        echo "<tr><td>".$role['name']."</td><td>".$role['description']."</td><td>".$permission['name']."</td><td>".$permission['description']."</td><td><button type='submit' name='edit' value='".$record['id']."'>Edit</button></td> <td><button type='submit' name='delete' value='".$record['id']."'>DELETE</button></td></tr>";
                    }
                }
                ?>
                
            </tbody>
        </table>
        <br>
        
       
        <button type="submit" value="Create New Role Permission" name="createNew">Create New Role Permission</button>
        </form>
        </div>
    </body>
        
</html>