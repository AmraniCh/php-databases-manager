<!DOCTYPE html>
<html lang="en">
<head>
   <title>Document</title>
   <script src="../js/jquery.min.js"></script>
   <script src="../js/utilities.js"></script>
</head>
<body>
    <script>
        ajax ("../modules/handler.php", "POST", {
            type:'update',
            database: 'testdatabase',
            table:'band',
            /** Hadu updates li khsni neemel f wahd row */
            name: 'GREEN DAY',
            genre: 'PUNK',
            /** hada specification faien haneemel had changes dial data */
            id: 1
        });
    </script>
</body>
</html>


