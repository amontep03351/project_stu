<?php
session_start();
if (!isset($_SESSION['userId']) && !isset($_SESSION['student_id'])) { 
   header( "Location: ../../actions/Usernotfound.html" );
}
?>
