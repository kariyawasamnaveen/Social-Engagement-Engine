<?php
  if(session('uid')) {
    require_once __DIR__ . '/user/vertical/main.blade.php';
  }else{
    require_once __DIR__ . '/user/vertical/main.blade.php';
  }
?>