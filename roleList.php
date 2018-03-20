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
    header('location:role.php');
}

/*if(isset($_REQUEST['delete']))
{
    $uid=$_REQUEST['delete'];
    $sql="delete from roles where roleid=$uid";
    $result= mysqli_query($con, $sql);
    if($result)
    {
        header('location:roleList.php');
    }
}*/

if(isset($_REQUEST['edit']))
{
    $uid=$_REQUEST['edit'];
    $_SESSION['edituserid']=$uid;  
    header('location:role.php');
}

?>

<html>
    <head>
        
        
                  <script>
            function confirm()
            {
                var a=confirm('Are you sure you want to delete this?');
                if(a)
                  { 
                  <?php 
                    $uid=$_REQUEST['delete'];
    $sql="delete from roles where roleid=$uid";
    $result= mysqli_query($con, $sql);
    if($result)
    {
        header('location:roleList.php');
    }
                  ?>
                              return true;
                   }
                   
                   return false;
            }
            </script>
            
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
                <tr><th>Role ID</th><th>Name</th><th>Description</th><th>createdon</th><th>createdby</th><th>Edit</th><th>Delete</th></tr>
            </thead>
          
            <tbody>
                <?php
                $sql="select * from roles";
                $result= mysqli_query($con, $sql);
                $rows= mysqli_num_rows($result);
                if($rows>0)
                {
                    while($record= mysqli_fetch_assoc($result))
                    {
                        echo "<tr><td>".$record['roleid']."</td><td>".$record['name']."</td><td>".$record['description']."</td><td>".$record['createdon']."</td><td>".$record['createdby']."</td><td><button type='submit' name='edit' value='".$record['roleid']."'>Edit</button></td> <td><button type='submit' name='delete' value='".$record['roleid']."' onclick=\"return(confirm());\">DELETE</button></td></tr>";
                    }
                }
                ?>
                
            </tbody>
        </table>
        <br>
        
       
        <button type="submit" value="Create New Role" name="createNew">Create New Role</button>
        </form>
        </div>
    </body>
        
</html>