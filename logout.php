<?php
require_once 'functions.php';
require_once 'timestamp.php';
require_once 'db.php';

session_start();
$_SESSION = [];

header("Location: index.php");