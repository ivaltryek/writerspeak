<?php
require "../dbconfig/conn.php";
require "../components/session.php";
require "../components/errorfunc.php";
if (!is_admin_logged_in()) {
    header("Location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>WritersPeak|Reports</title>
</head>

<body>
    <?php
    $get_reports_sql = "select * from `reports`";
    $get_reports_data = $conn->query($get_reports_sql);

    ?>
    <table class="table table-responsive-sm table-bordered table-striped ">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Reported Song</th>
                <th scope="col">Reported BY</th>
                <th scope="col">Reported Reason</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($get_reports_data as $gd) { ?>
                <tr>
                    <th scope="row"><?php echo $gd['id'] ?></th>
                    <td><u><a href="getreportdetails.php?id=<?php echo $gd['reported_song'] ?>"><?php echo $gd['reported_song'] ?></a></u></td>
                    <td><?php echo $gd['reported_by'] ?></td>
                    <td><?php echo $gd['reported_reason'];
                    } ?></td>
            </tr>

        </tbody>
    </table>


</body>

</html>