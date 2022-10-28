<?php
require("router.php");

// add route
// example route name :)
get("/","/frontend/index.php");
get("/getData","/controller/ImportFileController.php");
post("/importFile", "/controller/ImportFileController.php");
