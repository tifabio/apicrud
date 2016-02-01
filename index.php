<? if(!isset($_POST['token'])) header("location: /login")?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CRUD API</title>
        <link rel="stylesheet" href="ng-admin/ng-admin.min.css">
        <script type="text/javascript">
            var token = "<?php print $_POST['token']?>";
        </script>
    </head>
    <body ng-app="myApp">
        <div ui-view></div>
        <script src="ng-admin/ng-admin.min.js" type="text/javascript"></script>
        <script src="admin.js" type="text/javascript"></script>
    </body>
</html>