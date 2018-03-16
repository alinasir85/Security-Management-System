<?php
require 'conn.php';session_start();require 'utility.php';
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
$cid=0;
$editFlag=0;
$editlogin="";
$editpass="";
$editname="";
$editemail="";
$editcountry="";
$editisadmin="";

if(isset($_SESSION['edituserid']))
{
    $editFlag=1;
    $edituserid=$_SESSION['edituserid'];
    $sql="select * from users where userid='$edituserid'";
    $result= mysqli_query($con, $sql);
    $rows= mysqli_num_rows($result);
    if($rows>0)
    {
        $record= mysqli_fetch_assoc($result);
        $editlogin=$record['login'];
        $editpass=$record['password'];
        $editname=$record['name'];
        $editemail=$record['email'];
        $editcountry=$record['countryid'];
        $cid=$record['countryid'];
        $editisadmin=$record['isadmin'];
    }
}


if(isset($_REQUEST['save']))
{
$login=$_REQUEST['login'];
$pass=$_REQUEST['password'];
$name=$_REQUEST['name'];
$email=$_REQUEST['email'];
$country=$_REQUEST['country'];
$isadmin=0;
if(($_REQUEST['isadmin']))
{
    $isadmin=1;
}


if($editFlag!=1)
{
    
$sql="select * from users where login='$login' OR email='$email'";
$result= mysqli_query($con, $sql);
$rows= mysqli_num_rows($result);
if($rows>0)
{
    
    $error="User with login/email already exists.";
}
else
{
    $datetime=date('Y-m-d H:i:s');
    $uid=$_SESSION['userid'];
    $sql="insert into users (login,password,name,email,countryid,createdon,createdby,isadmin)  values ('$login','$pass','$name','$email',$country,'$datetime',$uid,$isadmin)";
    $result= mysqli_query($con, $sql);
    if($result)
    {
       
        header('location:userlist.php');
    }
}
}

else
{
 
    
    $datetime=date('Y-m-d H:i:s');
    $uid=$_SESSION['userid'];
    echo $login.$email;
    $sql="insert into users (login,password,name,email,countryid,createdon,createdby,isadmin)  values ('$login','$pass','$name','$email',$country,'$datetime',$uid,$isadmin) WHERE userid=$edituserid";
    $sql="update users set password='$pass',name='$name',email='$email',countryid=$country,createdon='$datetime',createdby=$uid,isadmin=$isadmin where login='$login'";
    $result= mysqli_query($con, $sql);
    
    if($result)
    {
      
        $_SESSION['edituserid']=NULL;  
        header('location:userlist.php');
    }
}
    
}

?>
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
             document.getElementById('login').value="";   
             document.getElementById('password').value="";
             document.getElementById('name').value="";
             document.getElementById('email').value="";
             document.getElementById('country').value=0;
             //document.getElementById('isadmin').value="";
            }
            //SAVE
            document.getElementById('save').onclick=function()
            {
             var login=document.getElementById('login').value;
             var password=document.getElementById('password').value;
             var name=document.getElementById('name').value;
             var email=document.getElementById('email').value;
             var country=document.getElementById('country').value;
             var isadmin=document.getElementById('isadmin').value;
             
             
             var alphaExp = /^[A-Za-z\d\s]+$/;
	     var numExp = /^[0-9]+$/;
	     var alphanumExp = /^[0-9a-zA-Z]+$/;
             
             if(login==""||password==""||name==""||email==""||country=="")
             {
                 alert("Cannot accept empty values.");
                 return false;
             }
             
             if(!login.match(alphanumExp) || !password.match(alphanumExp))
             {
                 alert('Must contain alpha num only.');
                 return false;
             }
             
             if(!name.match(alphaExp))
             {
              alert('Must only contain Alphabets.');
              return false;
             }
             
           
         
             
             var atpos=email.indexOf("@");
             var dotpos=email.lastIndexOf(".");
             if(atpos<1 || (dotpos-atpos<2))
             {
                 alert("Please enter your correct email.");
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
                            <td style="background-color:#555;color:white;padding-left:20px;" width="230px" height="40px"><b>User Management</b></td>
                       </tr>
                    </thead>
                    <tbody style="background-color: white;border-spacing:0;">
                        <tr>
                            <td style="padding:0;border-spacing: 0; ">Login:<br><input type="text" name="login" id="login" style="width: 220px;<?php if($editFlag==1){?>background-color: lightgray;<?php } ?>" value="<?php echo $editlogin ?>" <?php if($editFlag==1){?>  readonly="true"<?php } ?>></td>
                        </tr>
                         <tr>
                            <td>Password:<br><input type="text" name="password" id="password" style="width: 220px;" value="<?php echo $editpass ?>"></td>
                        </tr>
                         <tr>
                            <td>Name:<br><input type="text" name="name" id="name" style="width: 220px;" value="<?php echo $editname ?>"></td>
                        </tr>
                         <tr>
                             <td>Email:<br><input type="text" name="email" id="email" style="width: 220px;<?php if($editFlag==1){?>background-color: lightgray;<?php } ?>" value="<?php echo $editemail ?>" <?php if($editFlag==1){?> readonly="true"<?php } ?>></td>
                        </tr>
                        <tr>
                                    <td> Country:<br> <select name="country" id="country" style="width: 220px;">
                                     <option value="0">--Select--</option>
                                      <?php getCountries($con,$cid); ?>
                                            
                                            
                                </select></td>
                 
                        </tr>
                        <tr>
                            <td> Is admin?:<input type="checkbox" id="isadmin" name="isadmin" >
                    
                            </td>
                        </tr>
                        <tr style="background-color:#555;">
                            <td height="35px"><button type="submit" style="float:right;width:100px;margin-right:10px;" id="save" name="save">Save</button><button style="float:right; width:100px;" id="clear">Clear</button></td>
                                 
                        </tr>
                    </tbody>
                </table>
            </form>
                
                 <span style="color: red; margin-left:10px; "><b><?php echo $error ?></b></span>
            </div>
                    
    </body>
</html>