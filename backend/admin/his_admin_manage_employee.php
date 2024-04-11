<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['ad_id'];

  if(isset($_GET['disable']))
  {
        $id=intval($_GET['disable']);
        $adn="UPDATE his_docs SET is_active = FALSE WHERE doc_id=?";
        $stmt= $mysqli->prepare($adn);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $stmt->close();

        if($stmt)
        {
            $success = "Employee Disabled";
        }
        else
        {
            $err = "Try Again Later";
        }
  }

if (isset($_GET['enable'])) {
    $id = intval($_GET['enable']);
    $adn = "UPDATE his_docs SET is_active = TRUE WHERE doc_id=?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();

    if ($stmt) {
        $success = "Employee Enabled";
        // Redirect to refresh the page or update the list
        header("Location: his_admin_manage_employee.php"); // Adjust the redirect location if necessary
        exit;
    } else {
        $err = "Try Again Later";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
    <?php include('assets/inc/head.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('assets/inc/nav.php'); ?>
            <?php include("assets/inc/sidebar.php"); ?>

            <div class="content-page">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Employee</a></li>
                                            <li class="breadcrumb-item active">Manage Employees</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Manage Employees Details</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Active Employees -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <div class="table-responsive">
                                        <table class="table table-bordered toggle-circle mb-0" data-page-size="7">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Number</th>
                                                <th>Department</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $ret="SELECT * FROM his_docs WHERE is_active = TRUE ORDER BY RAND()";
                                            $stmt= $mysqli->prepare($ret);
                                            $stmt->execute();
                                            $res=$stmt->get_result();
                                            $cnt=1;
                                            while($row=$res->fetch_object())
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $cnt;?></td>
                                                    <td><?php echo $row->doc_fname;?> <?php echo $row->doc_lname;?></td>
                                                    <td><?php echo $row->doc_number;?></td>
                                                    <td><?php echo $row->doc_dept;?></td>
                                                    <td><?php echo $row->doc_email;?></td>
                                                    <td>
                                                        <a href="his_admin_manage_employee.php?disable=<?php echo $row->doc_id;?>" class="badge badge-warning">Disable</a>
                                                        <a href="his_admin_view_single_employee.php?doc_id=<?php echo $row->doc_id;?>&&doc_number=<?php echo $row->doc_number;?>" class="badge badge-success">View</a>
                                                        <a href="his_admin_update_single_employee.php?doc_number=<?php echo $row->doc_number;?>" class="badge badge-primary">Update</a>
                                                    </td>
                                                </tr>
                                                <?php $cnt++; } ?>
                                            </tbody>
                                        </table>
                                    </div> <!-- end .table-responsive-->
                                </div> <!-- end card-box -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end Active Employees row -->

                        <!-- Disabled Employees -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="header-title">Disabled Employees</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered toggle-circle mb-0">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Number</th>
                                                <th>Department</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $ret="SELECT * FROM his_docs WHERE is_active = FALSE ORDER BY doc_fname"; 
                                            $stmt= $mysqli->prepare($ret);
                                            $stmt->execute();
                                            $res=$stmt->get_result();
                                            $cnt=1;
                                            while($row=$res->fetch_object())
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $cnt;?></td>
                                                    <td><?php echo $row->doc_fname;?> <?php echo $row->doc_lname;?></td>
                                                    <td><?php echo $row->doc_number;?></td>
                                                    <td><?php echo $row->doc_dept;?></td>
                                                    <td><?php echo $row->doc_email;?></td>
                                                    <td>
                                                        <a href="his_admin_manage_employee.php?enable=<?php echo $row->doc_id;?>" class="badge badge-success">Enable</a>
                                                    </td>
                                                </tr>
                                                <?php $cnt++; } ?>
                                            </tbody>
                                        </table>
                                    </div> <!-- end table-responsive -->
                                </div> <!-- end card-box -->
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                    </div> <!-- container -->
                </div> <!-- content -->
                <?php include('assets/inc/footer.php'); ?>
            </div> <!-- End Page content -->
        </div> <!-- END wrapper -->
        <div class="rightbar-overlay"></div>
        <script src="assets/js/vendor.min.js"></script>
        <script src="assets/libs/footable/footable.all.min.js"></script>
        <script src="assets/js/pages/foo-tables.init.js"></script>
        <script src="assets/js/app.min.js"></script>
    </body>
</html>