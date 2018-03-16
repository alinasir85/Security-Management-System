<?php
require 'conn.php';
require 'utility.php';
session_start();
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
date_default_timezone_set('Asia/Karachi'); 
$error="";
$editFlag=0;
$roleid=0;
$permissionid=0;


if(isset($_SESSION['edituserid']))
{
    $editFlag=1;
    $edituserid=$_SESSION['edituserid'];
    $sql="select * from role_permission where id='$edituserid'";
    $result= mysqli_query($con, $sql);
    $rows= mysqli_num_rows($result);
    if($rows>0)
    {
        $record= mysqli_fetch_assoc($result);
        $roleid=$record['roleid'];
        $permissionid=$record['permissionid']; 
    }
}


if(isset($_REQUEST['save']))
{
if($editFlag!=1)    
{$role=$_REQUEST['role'];}
$permission=$_REQUEST['permission'];

if($editFlag!=1)
{
$sql="select * from role_permission where roleid='$role' AND permissionid='$permission'";
$result= mysqli_query($con, $sql);
$rows= mysqli_num_rows($result);
if($rows>0)
{
    
    $error="Role Permission already exists.";
}
else
{
   
    $uid=$_SESSION['userid'];
    $sql="insert into role_permission (roleid,permissionid)  values ('$role','$permission')";
    $result= mysqli_query($con, $sql);
    if($result)
    {
       
        header('location:rolePermissionList.php');
    }
}
}

else
{
 
    $uid=$_SESSION['userid'];
    $sql="select * from role_permission where roleid='$roleid' AND permissionid='$permission'";
    $result= mysqli_query($con, $sql);
    $rows= mysqli_num_rows($result);
    if($rows>0)
    {
    
      $error="Role Permission already exists.";
     }
    //$sql="insert into users (login,password,name,email,countryid,createdon,createdby,isadmin)  values ('$login','$pass','$name','$email',$country,'$datetime',$uid,$isadmin) WHERE userid=$edituserid";
   else
   {
    $sql="update role_permission set permissionid='$permission' where id='$edituserid'";
    $result= mysqli_query($con, $sql);
    
    if($result)
    {
        $_SESSION['edituserid']=NULL;  
        header('location:rolePermissionList.php');
    }
    
   }
}
    
}

?>


<html> 
 <head>
<style>
            
           .btn-group .header
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
               
            }
          .btn-group .header:hover
           {
               background-color: black;
               
           }
        </style>
        
                <script>
        function Main()
        {
            //CLEAR
            document.getElementById('clear').onclick=clear;
            function clear()
            {
            
             document.getElementById('role').value=0;
             document.getElementById('permission').value=0;
            
            }
            //SAVE
            document.getElementById('save').onclick=function()
            {
             var description=document.getElementById('role').value;
             
             var name=document.getElementById('permission').value;
             
             
             if(name==0 ||description== 0)
             {
                 alert("Cannot accept empty values.");
                 return false;
             }
             
             
            } 
        }
        </script>
           
    </head>
    <body style="background-color:whitesmoke" onload="Main();">
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
        
                <div class="main">
            <div class="left">
                <form action="" method="POST">
                <table style=" border-collapse: collapse;">
                    <thead>
                        <tr>
                            <td style="background-color:#555;color:white;padding-left:20px;" width="230px" height="40px"><b>Role Permission Management</b></td>
                       </tr>
                    </thead>
                    <tbody style="background-color: white;border-spacing:0;">
                        <tr>
                            <td style="padding:0;border-spacing: 0; ">Name:<br><select name="role" id="role" style="width: 220px;<?php if($editFlag==1){?>background-color: lightgray;<?php } ?>" <?php if($editFlag==1){?>  readonly="true" disabled="true"<?php } ?>>
                                    <option value="0">--Select--</option>
                                   <?php getRoles($con,$roleid); ?>
                                    
                                </select></td>
                        </tr>
                         <tr>
                            <td>Permission:<br><select name="permission" id="permission" style="width: 220px;" >
                                 <option value="0">--Select--</option>
                                   <?php getPermissions($con,$permissionid); ?>
                                    
                                
                                </select></td>
                        </tr>
                          
                        <tr style="background-color:#555;">
                            
                            <td height="35px"><button type="submit" style="float:right;width:100px;margin-right:10px;" id="save" name="save">Save</button><button style="float:right; width:100px;" id="clear">Clear</button></td>
                                 
                        </tr>
                    </tbody>
                </table>
            </form>
                
                 <span style="color: red; margin-left:10px; "><b><?php echo $error ?></b></span>
            </div>
                </div>
    </body>


</html>
   