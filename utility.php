<?php

function getCountries($con,$id)
{
    $sql="select * from country";
    $result=mysqli_query($con,$sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
        while($record= mysqli_fetch_assoc($result))
        {
            $s="";
            $cid=$record['id'];
            if($cid==$id)
            {
                $s="selected";
            }
            $name=$record['name'];
            echo "<option value='$cid' $s>$name</option>";
        }
    }
}

function getCountryById($con,$id)
{
    $sql="select * from country where id=$id";
    $result=mysqli_query($con,$sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
        $record= mysqli_fetch_assoc($result);
     
    }
    
    return $record;
}

function getRoles($con,$id)
{
    $sql="select * from roles";
    $result=mysqli_query($con,$sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
        while($record= mysqli_fetch_assoc($result))
        {
            $s="";
            $roleid=$record['roleid'];
            if($roleid==$id)
            {
                $s="selected";
            }
            $role=$record['name'];
            echo "<option value='$roleid' $s>$role</option>";
        }
    }
               
}



function getPermissions($con,$id)
{
    $sql="select * from permissions";
    $result= mysqli_query($con, $sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
        while($record= mysqli_fetch_assoc($result))
        {
            $s="";
            $permissionid=$record['permissionid'];
            if($permissionid==$id)
            {
                $s="selected";
            }
            $permission=$record['name'];
            echo "<option value='$permissionid' $s>$permission</option>";
        }
    }
}

function getUsers($con,$id)
{
    $sql="select * from users";
    $result= mysqli_query($con, $sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
        while($record= mysqli_fetch_assoc($result))
        {
            $s="";
            $userid=$record['userid'];
            if($userid==$id)
            {
                $s="selected";
            }
            $user=$record['login'];
            echo "<option value='$userid' $s>$user</option>";
        }
    }
}


function getRoleById($con,$id)
{
    $sql="select * from roles where roleid='$id'";
    $result= mysqli_query($con, $sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
       $record= mysqli_fetch_assoc($result);
       return $record;               
    }
}


function getPermissionById($con,$id)
{
    $sql="select * from permissions where permissionid='$id'";
    $result= mysqli_query($con, $sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
       $record= mysqli_fetch_assoc($result);
       return $record;               
    }
}


function getAllRolesbyId($con,$id)
{
    $k=0;
    $record=[];
    $sql="select roleid from user_role where userid='$id'";
    $result= mysqli_query($con, $sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
       while($r= mysqli_fetch_assoc($result))
       {
           $record[$k]=$r['roleid'];
           $k++;
           
       }
       return $record;               
    }
}


function isUniquePermission($arr,$p)
{
   for($i=0;$i<count($arr);$i++)
   {
       if($arr[$i]==$p)
           return 0;
   }
    
    return 1;
}

function getAllPermissionsByRolesId($conn,$arr)
{   
    if(count($arr)==0)
    {
        return;
    }
    $record=[];
    $k=0;
   foreach($arr as $role=>$value)
   {
    $j=(int)$value;

    $sql="select permissionid from role_permission where roleid=$j"; 
     $result= mysqli_query($conn, $sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
        
        while($r= mysqli_fetch_assoc($result))
        {
            $p=$r['permissionid'];
            $f=isUniquePermission($record,$p);
            if($f==1)
            {
             $record[$k]=$p;
             $k++;
            }
        }
      }
   }
   return $record;
}


function getAllRolesByRolesArray($conn,$arr)
{
     if(count($arr)==0)
    {
        return;
    }
    $record=[];
    $k=0;
   foreach($arr as $role=>$value)
   {
    $j=(int)$value;

    $sql="select * from roles where roleid=$j"; 
     $result= mysqli_query($conn, $sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
        
        while($r= mysqli_fetch_assoc($result))
        {
            
            $record[$k]=$r['name'];
           $k++;
        }
      }
   }
   return $record;
}


function getAllPermissionsByPermissionsArray($conn,$arr)
{
     if(count($arr)==0)
    {
        return;
    }
    $record=[];
    $k=0;
   foreach($arr as $role=>$value)
   {
    $j=(int)$value;

    $sql="select * from permissions where permissionid=$j"; 
     $result= mysqli_query($conn, $sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
        
        while($r= mysqli_fetch_assoc($result))
        {
            
            $record[$k]=$r['name'];
           $k++;
        }
      }
   }
   return $record;
}

?>
