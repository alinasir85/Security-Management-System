<?php
require 'conn.php';session_start();
require 'utility.php';


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
    header('location:user.php');
}

if(isset($_REQUEST['delete']))
{
    $uid=$_REQUEST['delete'];
    $sql="delete from users where userid=$uid";
    $result= mysqli_query($con, $sql);
    if($result)
    {
        header('location:userlist.php');
    }
}

if(isset($_REQUEST['edit']))
{
    $uid=$_REQUEST['edit'];
    $_SESSION['edituserid']=$uid;  
    header('location:user.php');
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
                <tr><th>User ID</th><th>login</th><th>password</th><th>name</th><th>email</th><th>country</th><th>createdon</th><th>createdby</th><th>isadmin</th><th>Edit</th><th>Delete</th></tr>
            </thead>
          
            <tbody>
                <?php
                $sql="select * from users";
                $result= mysqli_query($con, $sql);
                $rows= mysqli_num_rows($result);
                if($rows>0)
                {
                    while($record= mysqli_fetch_assoc($result))
                    {
                        if($record['isadmin']==1)
                        {
                            $admin="Yes";
                        }
                        else {
                            $admin="No";
                                    
                        }
                        $country= getCountryById($con, $record['countryid']);
                        echo "<tr><td>".$record['userid']."</td><td>".$record['login']."</td><td>".$record['password']."</td><td>".$record['name']."</td><td>".$record['email']."</td><td>".$country['name']."</td><td>".$record['createdon']."</td><td>".$record['createdby']."</td><td>$admin</td><td><button type='submit' name='edit' value='".$record['userid']."'>Edit</button></td> <td><button type='submit' name='delete' value='".$record['userid']."'>DELETE</button></td></tr>";
                    }
                }
                ?>
                
            </tbody>
        </table>
        <br>
        
        
        <button type="submit" value="Create New User" name="createNew">Create New User</button>
        </form>
        </div>
    </body>
        
</html>