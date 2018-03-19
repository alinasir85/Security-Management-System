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
date_default_timezone_set('Asia/Karachi'); 
$error="";
$editFlag=0;
$editname="";
$editdescription="";

if(isset($_SESSION['edituserid']))
{
    $editFlag=1;
    $edituserid=$_SESSION['edituserid'];
    $sql="select * from permissions where permissionid='$edituserid'";
    $result= mysqli_query($con, $sql);
    $rows= mysqli_num_rows($result);
    if($rows>0)
    {
        $record= mysqli_fetch_assoc($result);
        $editname=$record['name'];
        $editdescription=$record['description'];
        
    }
}


if(isset($_REQUEST['save']))
{
$name=$_REQUEST['name'];
$description=$_REQUEST['description'];

 if($name==""||$description=="")
	{
		$error="Cannot accept empty values.";
	}

if($editFlag!=1)
{
$sql="select * from permissions where name='$name'";
$result= mysqli_query($con, $sql);
$rows= mysqli_num_rows($result);
if($rows>0)
{
    
    $error="Permission already exists.";
}
else
{
    $datetime=date('Y-m-d H:i:s');
    $uid=$_SESSION['userid'];
    $sql="insert into permissions (name,description,createdon,createdby)  values ('$name','$description','$datetime',$uid)";
    $result= mysqli_query($con, $sql);
    if($result)
    {
       
        header('location:permissionList.php');
    }
}
}

else
{
 
    
    $datetime=date('Y-m-d H:i:s');
    $uid=$_SESSION['userid'];
   
    //$sql="insert into users (login,password,name,email,countryid,createdon,createdby,isadmin)  values ('$login','$pass','$name','$email',$country,'$datetime',$uid,$isadmin) WHERE userid=$edituserid";
   
    $sql="update permissions set description='$description',createdon='$datetime',createdby=$uid where permissionid=$edituserid";
    $result= mysqli_query($con, $sql);
    
    if($result)
    {
      
        $_SESSION['edituserid']=NULL;  
        header('location:permissionList.php');
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
            
             document.getElementById('name').value="";
             document.getElementById('description').value="";
            
            }
            //SAVE
            document.getElementById('save').onclick=function()
            {
             var description=document.getElementById('description').value;
             
             var name=document.getElementById('name').value;
             
             
             var alphaExp = /^[A-Za-z\d\s]+$/;
	     var numExp = /^[0-9]+$/;
	     var alphanumExp = /^[0-9a-zA-Z\d\s]+$/;
             
             if(name==""||description=="")
             {
                 alert("Cannot accept empty values.");
                 return false;
             }
             
             if(!name.match(alphanumExp) || !description.match(alphanumExp))
             {
                 alert('Must contain alpha num only.');
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
                            <td style="background-color:#555;color:white;padding-left:20px;" width="230px" height="40px"><b>Role Management</b></td>
                       </tr>
                    </thead>
                    <tbody style="background-color: white;border-spacing:0;">
                        <tr>
                            <td style="padding:0;border-spacing: 0; ">Name:<br><input type="text" name="name" id="name" style="width: 220px;<?php if($editFlag==1){?>background-color: lightgray;<?php } ?>" value="<?php echo $editname ?>" <?php if($editFlag==1){?>  readonly="true"<?php } ?>></td>
                        </tr>
                         <tr>
                            <td>Description:<br><input type="text" name="description" id="description" style="width: 220px;" value="<?php echo $editdescription ?>"></td>
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
   